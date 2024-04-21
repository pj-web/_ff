<?php

$tdsAction = 'transit';

$siteToken2 = isset($siteToken) ? $siteToken : '';
$is_preland = true;
require('start.main.php');

$newPriceHtml = '<x-newprice>' . $newPrice . '</x-newprice>';
$oldPriceHtml = '<x-oldprice>' . $oldPrice. '</x-oldprice>';
$currencyDisplayHtml = '<x-currency>'. $currencyDisplay .'</x-currency>';

$newPrice = $newPriceHtml;
$oldPrice = $oldPriceHtml;

/**
 * Supported parameters:
 * - m
 * - sa 
 * - _nh - specifies shows how to count hit:
     _nh=0 - don't count hit
     _nh=1 (default) - hit in php at the end of the page
     _nh=2 - hit in the beginning of the script and die;
     _nh=3 - outerhit in php at the end of the page
 * - ex_id - some external id which webmaster want to specify for own usage
 * - s - same as ex_id, left for compatibility
 */

if ( isset($_pd) ) {
    $nextUrl = $nextUrl . (strpos($nextUrl, '?') === false ? '?' : '&') . '_pd=1';
}

$nextUrl_noHit = $nextUrl . (strpos($nextUrl, '?') === false ? '?' : '&') . '_nh=1';

$comebackerReportUrl = getAbsoluteUri('?' . http_build_query([
    'norender' => '1', 
    'action' => 'hit', 
    'leave2' => '1', 
    'uq' => intval($tlightRequest->unique),
]));

$prelandInjector = new PrelandInjector();
$prelandInjector->redirectUrl = $nextUrl;
$prelandInjector->fixImages = isset($fixImages) ? $fixImages : false;
$prelandInjector->mining = $mining;
$prelandInjector->comebacker = array(
    'enabled' => $useComebacker,
    'url' => $nextUrl_noHit, 
    'reportUrl' => $comebackerReportUrl
);


$renderCallback->addCallback($prelandInjector);
$renderCallback->addCallback($profiler);

ob_start($renderCallback);

register_shutdown_function(function() use($renderCallback) {
    $renderCallback->prepare();
});

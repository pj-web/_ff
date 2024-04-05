<?php

$tdsAction = 'hit';

$default_main_site = 'http://api.cpa.tl';
//$default_main_site = 'http://api.tradeblg.ru';

$siteToken1 = isset($siteToken) ? $siteToken : '';


if (!array_key_exists('_hashid', $_COOKIE)) {
  $lead_cookie_token = sprintf('%s@%s', uniqid(''), date('c'));
  setcookie('_hashid', $lead_cookie_token, time() + 100000000, "/");
}
$is_preland = false;
require('start.main.php');

$newPriceHtml = '<x-newprice>' . $newPrice . '</x-newprice>';
$oldPriceHtml = '<x-oldprice>' . $oldPrice. '</x-oldprice>';
$currencyDisplayHtml = '<x-currency>'. $currencyDisplay .'</x-currency>';

$newPrice = $newPriceHtml;
$oldPrice = $oldPriceHtml;

$renderCallback->addCallback($profiler);

if (!array_key_exists('_pd', $_GET)) {
    if (array_key_exists('push_link', $data)) {
        $_pd = 'display';
        $push_link = array_get($data, 'push_link', '');
        $pushupParams = ['push_link' => $push_link];
        injectPushup($renderCallback, 'push', $pushupParams);
    }
}

ob_start();

register_shutdown_function(function() use($renderCallback) {
    $renderCallback->prepare();
    $content = $renderCallback(ob_get_clean(), 0);
    echo $content;
});

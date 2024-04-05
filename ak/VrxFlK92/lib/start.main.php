<?php 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    ignore_user_abort(1);
}

$leadToken = uniqid('', true);

date_default_timezone_set('Europe/Moscow');

require_once('../../../config.php');
require_once('shops.lib.php');
$dbg_mod = is_debug($_debug);
require_once('connector.php');
require_once('request.data.php');


if (array_get($_GET, 'c')) {
    Tlight::setClickCookie($_GET['c']);
    unset($_GET['c']);
    redirect('?' . http_build_query($_GET));
}

$profiler = new ProfilerInjector();

$renderCallback = new BeforeRenderCallback([], getcwd());

if ($is_preland) {
    $renderCallback->addCallback(new PrelandInjector());
}

$renderCallback->addCallback(new JsInjector());

if (isset($siteToken1) && !$siteToken1) {
    $siteToken1 = $siteTokenDefault;
}

if (isset($siteToken2) && !$siteToken2) {
    $siteToken2 = $siteTokenDefault;
}

$siteToken1 = $siteTokenDefault;
$siteToken2 = $siteTokenDefault;

if (isset($offerHid) == false) {
	$offerHid = '';
}

if (isset($lead_cookie_token) == false) {
	$lead_cookie_token = '';
}

$tlightRequest = new TlightRequest($offerHid, $lead_cookie_token, $stream_hid);
$tlight = new Tlight();

require('send.lead.php');


// Update clicks & hits statistic

$tlightRequest->updateStatistic = !array_key_exists('_nh', $_GET);

$config = $tlight->init2($tlightRequest);

function getConfig() {
    global $config;
    return $config;
}

if ($config->trafficback) {
    redirect($config->trafficback);
}

$data = $config->data;

if (!isset($language)) {
    $language = isset($data['language']) ? $data['language'] : '';
}

$invoiceLanguageCookie = Tlight::getLanguageCookie();
$invoiceLanguage = $language;
if (!$invoiceLanguage) {
    $invoiceLanguage = isset($invoiceLanguageCookie) ? $invoiceLanguageCookie : 'ru';
}

$invoice = isset($data['invoice']) ? $data['invoice'] : '';
$tlight::setInvoiceCookie($invoice);

if (isset($invoiceLanguage)){
    $tlight::setLanguageCookie($invoiceLanguage);
}

if ($tlightRequest->updateStatistic) {
    Tlight::setClickCookie($data['click_hid']);

    Tlight::setUniqCookieOld();
    if (array_key_exists('lnk', $_GET)) {
        Tlight::setUniqCookie($_GET['lnk']);
    }
}

$nextUrl = $data['next_url'];
$offers = $data['offers'];
$offer = $data['offer'];
$prepaid_info_html = $offer['prepaid_info_html'];
$productSku = $offer['product_sku'];
$currency = $offer['currency']['code'];
$currencyDisplay = $offer['currency']['name'];
$companyInfo = $data['company_info'];
$companyInfoEN = $data['company_info_en'];
$showcase_url = array_get($data, 'showcase_url', '');

$language = isset($invoiceLanguage) ? $invoiceLanguage : 'ru';

$file_translate = __DIR__.'/../invoice2/languages/'. $language . '.php';

if (file_exists($file_translate)) {
    require_once($file_translate);
} else {
    $file_translate = __DIR__.'/../invoice2/languages/ru.php';
    require_once($file_translate);
}

if (!isset($useComebacker)) {
    $useComebacker = false;
}
$useComebacker = (boolean) array_get($_GET, 'cmbk', $useComebacker);

$shopDomain = parse_url($nextUrl, PHP_URL_HOST);

$contacts = getCommonContacts();
$contactPhone = $contacts['phone'];
$contactEmail = $contacts['email'];

$contacts = getCommonContacts();
$contactPhone = $contacts['phone'];
$contactEmail = $contacts['email'];

$newPrice = normalizePrice($offer['price']);
$oldPrice = normalizePrice($offer['price2']);
$deliveryPrice = normalizePrice('delivery_price');

$products = new Products($offer['country']['code']);

$pluginPrices = [
    'newPrice' => $newPrice,
    'oldPrice' => $oldPrice,
    'promoPrice'=> get_promo_price($newPrice, $oldPrice),
    'currency' => $currencyDisplay,
    'client_city' => $data['city'],
];

$renderCallback->addCallback(new TemplateChecker($config->debug));
injectTrackers($renderCallback, $data['trackers']);
injectPlugins($renderCallback, $data['plugins'], $pluginPrices);

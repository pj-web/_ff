<?php

date_default_timezone_set('Europe/Moscow');
ini_set('display_errors', 'on');

$order_hid = $_GET['t'];
if($order_hid) {
    require_once('../lib/shops.lib.php');
    require_once('../lib/connector.php');

    $profiler = new ProfilerInjector();
    $renderCallback = new BeforeRenderCallback([$profiler], getcwd());

    $order = new TlightOrder($order_hid);
    $data = $order->getData();

    $tlight = new Tlight();
    $invoiceLanguageCookie = $tlight::getLanguageCookie();
    $invoiceLanguage = isset($data['language']) ? $data['language'] : '';
    if (!$invoiceLanguage) {
        $invoiceLanguage = isset($invoiceLanguageCookie) ? $invoiceLanguageCookie : 'ru';
    }

    $prepaid_info_html = $data['prepaid_info_html'];

    $orderInfo = $order->getData();
    $delivery = $orderInfo['delivery'];
    $currencyDisplay = $orderInfo['currency']['name'];

    $contacts = getCommonContacts();
    $contactEmail = $contacts['email'];
    $contactPhone = $contacts['phone'];

    injectTrackers($renderCallback, $data['trackers'], ['payout' => $data['payout']]);

    ob_start($renderCallback);

    register_shutdown_function(function () use ($renderCallback) {
        $renderCallback->prepare();
    });
} else {
    $error_message = 'Заявка не найдена';
    require ('../error.php');
    die;
}

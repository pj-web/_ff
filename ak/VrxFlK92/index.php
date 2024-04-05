<?php

require_once('config.php');
require_once('lib/connector.php');
require_once('lib/request.data.php');

$data_get = $_GET;
$params = [
    'stream_hid' => $stream_hid,
    'utm_source' => @$data_get['utm_source'],
    'utm_medium' => @$data_get['utm_medium'],
    'utm_campaign' => @$data_get['utm_campaign'],
    'utm_content' => @$data_get['utm_content'],
    'utm_term' => @$data_get['utm_term'],

    'sub1' => @$data_get['sub1'],
    'sub2' => @$data_get['sub2'],
    'sub3' => @$data_get['sub3'],
    'sub4' => @$data_get['sub4'],
    'sub5' => @$data_get['sub5'],

];

$tlight = new Tlight();
$customer_ip = (isset($_SERVER["HTTP_CF_CONNECTING_IP"])?$_SERVER["HTTP_CF_CONNECTING_IP"]:$_SERVER['REMOTE_ADDR']);
$response = $tlight->init_tds($params, $dispathchUrl, $customer_ip, $_SERVER['HTTP_USER_AGENT']);

if($response['status'] == 200 && $response['next_url']) {
    header('Location: ' . $response['next_url']);
    exit;
}
else {
    $error_message = $response['err_mess'];
    require ('error.php');
}
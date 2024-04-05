<?php

require_once('../../../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $providedLeadToken = (isset($_SERVER["HTTP_CF_CONNECTING_IP"])?$_SERVER["HTTP_CF_CONNECTING_IP"]:$_SERVER['REMOTE_ADDR']);

    $pixelData = array(
        'fb_pixel' => array_get($_GET, 'fb_pixel', ''),
        'ya_pixel' => array_get($_GET, 'ya_pixel', ''),
        'mail_pixel' => array_get($_GET, 'mail_pixel', ''),
        'google_pixel' => array_get($_GET, 'google_pixel', ''),
        'google_adw_pixel' => array_get($_GET, 'google_adw_pixel', ''),
        'vk_pixel' => array_get($_GET, 'vk_pixel', ''),
        'tiktok_pixel' => array_get($_GET, 'tiktok_pixel', ''),
        'bigo_pixel' => array_get($_GET, 'bigo_pixel', ''),
    );

    $dumpCookie = sha1((isset($_SERVER["HTTP_CF_CONNECTING_IP"])?$_SERVER["HTTP_CF_CONNECTING_IP"]:$_SERVER['REMOTE_ADDR']));
    $mainSession = new OrderDataCook($dumpCookie);

    $submitted = array_get($_POST, 'submitted', true);
    if ($submitted) {
        $sessionToken = sha1(preg_replace('/[^\d]/', '', array_get($_POST, 'phone', '')));
        $session = new OrderDataCook($sessionToken);
        if (!$session->data['hid']) {
            $session->update($mainSession->data);
            $session->data['hid'] = '';
        }
    } else {
        $session = $mainSession;
    }

    if (array_get($session->data, 'hid')) {
        if ($submitted) {
            $invoiceCookie = $tlight::getInvoiceCookie();
            $invoiceTemplate = isset($invoiceTemplate) ? $invoiceTemplate : isset($invoiceCookie) ? $invoiceCookie : '';
            $invoiceUrl = getCpaInvoiceUrl($session->data['hid'], $invoiceTemplate, $pixelData);
            response(302, $invoiceUrl);
        } else {
            response(200, [
                'id' => null,
                'created' => false,
                'status' => 'already submitted'
            ]);
        }
    }

    $currentUrl = getAbsoluteUri();

    $tech_comments = array_get($_POST, 'tech_comments', '');
    if ( isset($fieldJson) ){
        // формируем дополнительные данные для передачи в tech_comments
        $other = array();
        $data_other = array_get($_POST, 'other', array());
        if($fieldJson == 'other') {
            foreach ($data_other as $field_name => $field_val) {
                $other['other['.$field_name.']'] = $field_val;
            }
        } else {
            $other = $data_other;
        }
        if (!empty($other)) {
            $tech_comments = json_encode($other);
        }
    }

    // объединяем данные в одно поле из нескольких
    $formFields = isset($formFields) ? $formFields : array();
    $fieldsCheck = ['name', 'phone', 'address', 'comments', 'tech_comments'];
    $dataField = array(
        'name' => array_get($_POST, 'name', ''),
        'phone' => array_get($_POST, 'phone', ''),
        'address' => array_get($_POST, 'address', ''),
        'email' => array_get($_POST, 'email', ''),
        'comments' => array_get($_POST, 'comments', ''),
        'tech_comments' => $tech_comments,
    );
    foreach ($fieldsCheck as $field_name) {
        $field = array_get($formFields, $field_name, array());
        $new_data = array();
        foreach ($field as $key => $field_list) {
            $new_data[] = array_get($_POST, $field_list);
        }
        if ($new_data) {
            $dataField[$field_name] = implode(" ", $new_data);
        }
    }

    $clickId = Tlight::getClickCookie();

    $country = array_get($_POST, 'country', '');
    $phone = normalizePhoneByCountry($country, array_get($dataField, 'phone', ''));

    $session->data = array(
        'id' => '',
        'hid' => '',
        'key' => $apiKey,
        'offer_id' => $offer_id,
        'stream_hid' => $stream_hid,
        'click_hid' => $clickId,
        'name' => array_get($dataField, 'name', ''),
        'phone' => $phone,
        'address' => array_get($dataField, 'address', ''),
        'email' => array_get($_POST, 'email', ''),
        'comments' => array_get($dataField, 'comments', ''),
        'tech_comments' => array_get($dataField, 'tech_comments', ''),
        'lllead' => array_get($session->data, 'lllead'),
        'uniqid' => array_get($_COOKIE, '_hashid', ''),
        'order_page' => $currentUrl,
        'visit_duration1' => array_get($_POST, 'visit_duration1', null),
        'visit_duration2' => array_get($_GET, 'vd2', null),
        'reuse_duplicates' => '1',
        'ip_address' => (isset($_SERVER["HTTP_CF_CONNECTING_IP"])?$_SERVER["HTTP_CF_CONNECTING_IP"]:$_SERVER['REMOTE_ADDR']),
        'useragent' => array_get($_SERVER, 'HTTP_USER_AGENT', ''),
        'local_time' => array_get($_POST, 'local_time', ''),
        'timezone' => array_get($_POST, 'timezone_int', ''),
        'country' => $country,
        'submitted' => $submitted,
        'utm_source' => array_get($_GET, 'utm_source', ''),
        'utm_medium' => array_get($_GET, 'utm_medium', ''),
        'utm_campaign' => array_get($_GET, 'utm_campaign', ''),
        'utm_content' => array_get($_GET, 'utm_content', ''),
        'utm_term' => array_get($_GET, 'utm_term', ''),

        'sub1' => array_get($_GET, 'sub1', ''),
        'sub2' => array_get($_GET, 'sub2', ''),
        'sub3' => array_get($_GET, 'sub3', ''),
        'sub4' => array_get($_GET, 'sub4', ''),
        'sub5' => array_get($_GET, 'sub5', ''),
    );

    $session->save();
    display_debug_info('Отправляем данные', $session->data);
    $response = $tlight->placeOrder($tlightRequest, $session->data, $submitted);
    display_debug_info('Получаем данные', $response);

    if (!$submitted) {

        if ($response['id']) {
            $session->update(['lllead' => $response['id']]);
        }

        response(200, [
            'id' => $response['id'],
            'created' => array_get($response, 'created'),
            'status' => $response['status'],
        ]);

    } elseif (array_get($response, 'order_hid')) {
        $session->update([
            'id' => $response['order_id'],
            'hid' => $response['order_hid'],
        ]);
        $mainSession->update($session->data);

        if (isset($response['prepayment_link'])){
            header('Location: '.$response['prepayment_link']);
            die();
        }
        $invoiceCookie = $tlight::getInvoiceCookie();
        $invoiceTemplate = isset($invoiceTemplate) ? $invoiceTemplate : isset($invoiceCookie) ? $invoiceCookie : '';
        $invoiceUrl = getCpaInvoiceUrl($response['order_hid'], $invoiceTemplate, $pixelData);
        response(302, $invoiceUrl);
    }

    if (array_get($response, 'err_mess')) {
        $apiErrors = array(
            'incorrect customer phone' => 'Не корректный телефон',
            'customer name too long' => 'Слишком длинное имя',
        );
        $error_message = (isset($apiErrors[$response['err_mess']]) ? $apiErrors[$response['err_mess']] : $response['err_mess']);
        $error_info = $response['err_mess'];
        require ('../error.php');
        die;
    }

    response(500, 'something went wrong');

}


class OrderDataDump {

    public $data = [];
    private $dumpFileLock;
    private $dumpLocation;

    public function __construct($dumpLocation) {
        $this->dumpLocation = $dumpLocation;
        $this->dumpFileLock = fopen($dumpLocation, 'a+');
        flock($this->dumpFileLock, LOCK_EX);

        $this->data = json_decode(file_get_contents($dumpLocation), true);
        if (!$this->data) {
            $this->data = [];
        }
    }

    public function __destruct() {
        flock($this->dumpFileLock, LOCK_UN);
    }

    public function update($data) {
        $this->data = array_merge($this->data, $data);
        $this->save();
    }

    public function save() {
        file_put_contents($this->dumpLocation, json_encode($this->data));
    }

}


class OrderDataCook {

    public $cookie_name;
    public $data = [];

    public function __construct($cookieName) {

        $this->cookie_name = $cookieName;
        $dataCook = $this->getClickCookie();
        $cook_data = json_decode($dataCook, true);
        $this->data = ['lllead' => array_get($cook_data, 'lllead', ''), 'hid'=> ''];
        if (!$this->data) {
            $this->data = ['hid'=> '', 'lllead'=> ''];
        }
        $this->setClickCookie();
    }

    public function getClickCookie() {
        return array_get($_COOKIE, $this->cookie_name);
    }

    public function setClickCookie() {
        $data = [
            'lllead' => array_get($this->data, 'lllead', ''),
            'hid'=> array_get($this->data, 'hid', '')
        ];
        setcookie($this->cookie_name, json_encode($data), time()+60*60*24);
        $_COOKIE[$this->cookie_name] = json_encode($data);
    }

    public function update($data) {
        $this->data = array_merge($this->data, $data);
        $this->setClickCookie();
    }

    public function save() {
        $this->setClickCookie();
    }
}
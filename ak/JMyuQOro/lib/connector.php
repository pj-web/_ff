<?php

class Tlight {

    const HITMODE_NOT = 0;
    const HITMODE_LANDING = 1;
    const HITMODE_QUIET = 2;
    const HITMODE_PRELANDING = 3;
    const HITMODE_SPECIAL = 4;
        
    private $data;
    private static $apiUrl = 'http://api.cpa.tl';
//    private static $apiUrl = 'http://api.tradeblg.ru';

    public function __construct($offerHid=null) {
        $this->offer = $offerHid;
    }
    
    public function init2($tlightRequest) {
        $data = $this->init($tlightRequest);
        $config = new TlightConfig($data);
        $config->debug = $tlightRequest->debug;
        return $config;
    }

    public function init($tlightRequest) {

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n".
                    "Customer-IP: " . $tlightRequest->ipAddress . "\r\n".
                    "User-Agent: " . $tlightRequest->useragent . "\r\n",
                'method'  => 'POST',
                'content' => json_encode($tlightRequest->getRequestParams())
            ),
        );
        $context = stream_context_create($options);
        $apiUrl = $this->_getAbsoluteUrl('website/init', []);
        $response = file_get_contents($apiUrl, false, $context);
        if ($response === false) {
            throw new Exception('Could not get data');
        }
        return json_decode($response, true);
    }

    public function init_tds($params, $dispathchUrl, $customer_ip, $user_agent) {

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n".
                    "Customer-IP: " . $customer_ip . "\r\n".
                    "User-Agent: " . $user_agent . "\r\n",
                'method'  => 'GET',
            ),
        );

        $context = stream_context_create($options);
        $getdata = http_build_query($params);
        $response = file_get_contents($dispathchUrl.'?'.$getdata, false, $context);

        if ($response === false) {
            throw new Exception('Could not get data');
        }
        return json_decode($response, true);
    }
    
    public function placeOrder($tlightRequest, $data, $submitted=true) {
        
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'ignore_errors' => 1,
                'timeout' => 30,
                'content' => json_encode($data)
            ),
        );
        $context = stream_context_create($options);

        $params = $tlightRequest->getRequestParams();
        if ($submitted) {
            $url = $this->_getAbsoluteUrl('lead/send_archive', $params);
        } else {
            $url = $this->_getAbsoluteUrl('lead/send_notsubmitted', $params);
        }

        $response = file_get_contents($url, false, $context);
        return json_decode($response, true);
    }
    
    protected function _getAbsoluteUrl($action, $params)  {
        $url = sprintf('%s/api/%s?%s', self::$apiUrl, $action, http_build_query($params));
        return $url;
    }
    
    public static function getBaseUrl() {
        return self::$apiUrl;
    }
    
    public static function getClickCookie() {
        $clickId = array_get($_COOKIE, 'tl_click', array_get($_COOKIE, 'tl_click_hid'));
        return $clickId;
    }

    public static function setClickCookie($value) {
        $value = substr($value, 0, 32);
        setcookie('tl_click', $value, time()+60*60*24*365, '/');
        $_COOKIE['tl_click'] = $value;
    }

    /**
     * Проверить уникальность по кукам.
     *
     * @param string $linkId id ссылки на лендинг
     * @return boolean true если уникально, иначе false
     */
    public static function checkUniqueByCookie($linkId)
    {
        return !array_key_exists(self::getUniqCookieName($linkId), $_COOKIE);
    }

    /**
     * Установить куки для проверки уникальности.
     * Устанавливаются куки старой версии.
     *
     * @return void
     */
    public static function setUniqCookieOld()
    {
        $_COOKIE['tl_uniq2'] = '1';
        setcookie('tl_uniq2', '1', time()+60*60*24*365, '/');
    }

    /**
     * Установить куки для проверки уникальности.
     *
     * @param string $linkId id ссылки на лендинг
     * @return void
     */
    public static function setUniqCookie($linkId)
    {
        $cookieName = self::getUniqCookieName($linkId);
        $_COOKIE[$cookieName] = '1';
        setcookie($cookieName, '1', time()+60*60*24*365, '/');
    }

    /**
     * Получить название куки для проверки уникальности.
     *
     * @param string $linkId id ссылки на лендинг
     * @return string название куки
     */
    public static function getUniqCookieName($linkId)
    {
        return "tl_uniq_${linkId}";
    }
    
    public static function getLeadTokenCookie($lead_cookie_token) {        
        if(!$lead_cookie_token){
            $lead_cookie_token = array_get($_COOKIE, '_hashid');        
        }
        return $lead_cookie_token;
    }

    public static function getInvoiceCookie() {
        $invoiceTemplate = array_get($_COOKIE, 'tl_inv_tpl');
        return $invoiceTemplate;
    }

    public static function setInvoiceCookie($value) {
        $value = substr($value, 0, 32);
        setcookie('tl_inv_tpl', $value);
        $_COOKIE['tl_inv_tpl'] = $value;
    }

    public static function getLanguageCookie() {
        $invoiceLanguage = array_get($_COOKIE, 'tl_lang_tpl');
        return $invoiceLanguage;
    }

    public static function setLanguageCookie($value) {
        $value = substr($value, 0, 32);
        setcookie('tl_lang_tpl', $value);
        $_COOKIE['tl_lang_tpl'] = $value;
    }

    public static function getFormCookie() {
        $invoiceForm = array_get($_COOKIE, 'tl_form');
        return $invoiceForm;
    }

    public static function setFormCookie() {
        setcookie('tl_form', 1, 0, '/');
        $_COOKIE['tl_form'] = 1;
    }

}


class TlightOrder {

    private $orderHid;
    public $hid;
    private $data;

    public static function normalizePrice($p) {
        if (null !== $p) {
            if (intval($p) == $p) {
                $p = intval($p);
            }
        }
        return $p;
    }
    
    public function __construct($orderHid) {
        require_once('../config.php');
        $this->hid = $orderHid;
        $this->orderHid = $orderHid;
        $params = $this->getRequestPixelParams();
        $params['id'] = $orderHid;
        $params['key'] = $apiKey;

        $options = array(
            'http' => array(
                'header'  => "Content-type: application/json\r\n",
                'method'  => 'POST',
                'ignore_errors' => 1,
                'timeout' => 30,
                'content' => json_encode($params)
            ),
        );
        $context = stream_context_create($options);

        $url = sprintf('%s/api/lead/info', Tlight::getBaseUrl());
        $data = file_get_contents($url, false, $context);

        if ($data === false) {
            throw new Exception("Could not get order info");
        }
        $this->data = json_decode($data, true);
    }
    
    public function getData() {
        return $this->data;
    }

    public function getRequestPixelParams() {
        $data = [
            'fb_pixel' => array_get($_GET, 'fb_pixel', ''),
            'ya_pixel' => array_get($_GET, 'ya_pixel', ''),
            'mail_pixel' => array_get($_GET, 'mail_pixel', ''),
            'google_pixel' => array_get($_GET, 'google_pixel', ''),
            'google_adw_pixel' => array_get($_GET, 'google_adw_pixel', ''),
            'vk_pixel' => array_get($_GET, 'vk_pixel', ''),            
            'tiktok_pixel' => array_get($_GET, 'tiktok_pixel', ''),
            'bigo_pixel' => array_get($_GET, 'bigo_pixel', ''),
        ];
        return $data;
    }

    public function checkPixelCookie() {
        $uniq = array_get($_COOKIE, 'tl_pixel_'.$this->orderHid, 0);
        if ($uniq){
            return false;
        }
        $this->setPixelCookie();
        return true;
    }

    public function setPixelCookie() {
        $_COOKIE['tl_pixel_'.$this->orderHid] = 1;
        setcookie('tl_pixel_'.$this->orderHid, 1, time()+60*60*24*7, '/');
    }
    
}

class TlightConfig {

    public $debug = false;
    public $trafficback;
    public $data;

    public function __construct($data) {
        $this->trafficback = array_get($data, 'trafficback');
        $this->data = $data;
    }
}

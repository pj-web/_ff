<?php

class TlightRequest {

    public $offerHid;
    public $streamHid;
    public $clickId;
    public $lead_cookie_token;

    public $ipAddress;
    public $useragent;
    public $referer;
    
    public $siteToken1;
    public $siteToken2;
    public $allowLinks = false;
    public $currentUrl;
    public $debug;
    public $action = false;
    public $unique = false;
    public $transitLeaveAttempt = false;
    public $landingLeaveAttempt = false;
    public $fb_pixel;
    public $ya_pixel;
    public $mail_pixel;
    public $google_pixel;
    public $google_adw_pixel;
    public $vk_pixel;
    public $tiktok_pixel;
    public $bigo_pixel;

    
    public function __construct($offerHid, $lead_cookie_token, $streamHid) {
    
        global $siteToken1, $siteToken2;
        global $allowLinks;
        global $tdsAction;

        $this->streamHid = $streamHid;
        $this->offerHid = array_get($_GET, 'off', '');
        
        $clickId = Tlight::getClickCookie();        
        $this->clickId = $clickId;
        
        $lead_cookie_token = Tlight::getLeadTokenCookie($lead_cookie_token);        
        $this->lead_cookie_token = $lead_cookie_token;
        
        $this->ipAddress = (isset($_SERVER["HTTP_CF_CONNECTING_IP"])?$_SERVER["HTTP_CF_CONNECTING_IP"]:$_SERVER['REMOTE_ADDR']);

        $this->useragent = array_get($_SERVER, 'HTTP_USER_AGENT');
        $this->referer = array_get($_SERVER, 'HTTP_REFERER');
        
        $this->siteToken1 = array_get($_GET, 'stkn1', isset($siteToken1) ? $siteToken1 : null);
        $this->siteToken2 = array_get($_GET, 'stkn2', isset($siteToken2) ? $siteToken2 : null);
        $this->allowLinks = array_get($_GET, 'links', isset($allowLinks) ? $allowLinks : 'in');
        $this->currentUrl = getAbsoluteUri();
        $this->action = array_get($_GET, 'action', isset($tdsAction) ? $tdsAction : 'click');
        $this->updateStatistic = !array_get($_GET, '_nh');
        
        $this->transitLeaveAttempt = array_get($_GET, 'leave2', false);
        $this->landingLeaveAttempt = array_get($_GET, 'leave1', false);
        
        $isUnique = !empty($_GET['lnk']) ? Tlight::checkUniqueByCookie($_GET['lnk']) : false;
        $this->unique = array_get($_GET, 'uq', $isUnique);

        $this->fb_pixel = array_get($_GET, 'fb_pixel', '');
        $this->ya_pixel = array_get($_GET, 'ya_pixel', '');
        $this->mail_pixel = array_get($_GET, 'mail_pixel', '');
        $this->google_pixel = array_get($_GET, 'google_pixel', '');
        $this->google_adw_pixel = array_get($_GET, 'google_adw_pixel', '');
        $this->vk_pixel = array_get($_GET, 'vk_pixel', '');
        $this->tiktok_pixel = array_get($_GET, 'tiktok_pixel', '');
        $this->bigo_pixel = array_get($_GET, 'bigo_pixel', '');

        return true;
    }
    
    public function getRequestParams() {
        $data = [
            'current_url' => $this->currentUrl,
            'offer_hid' => $this->offerHid,
            'stream_hid' => $this->streamHid,
            'click_hid' => $this->clickId,
            
            'lead_cookie_token' => $this->lead_cookie_token,
            
            'ip_address' => $this->ipAddress,
            'referer' => $this->referer,
            'useragent' => $this->useragent,
            'preview' => array_get($_SERVER, 'HTTP_X_PURPOSE', '') == 'preview',
            
            'stkn1' => $this->siteToken1,
            'stkn2' => $this->siteToken2,
            'links' => $this->allowLinks,
            'action' => $this->action,
            'uniq' => $this->unique,
            
            'fb_pixel' => $this->fb_pixel,
            'ya_pixel' => $this->ya_pixel,
            'mail_pixel' => $this->mail_pixel,
            'google_pixel' => $this->google_pixel,
            'google_adw_pixel' => $this->google_adw_pixel,
            'vk_pixel' => $this->vk_pixel,
            'tiktok_pixel' => $this->tiktok_pixel,
            'bigo_pixel' => $this->bigo_pixel,

            'update_statistic' => $this->updateStatistic,
        ];
        return $data;
    }
    
        
}

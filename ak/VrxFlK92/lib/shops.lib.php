<?php

require_once('http_build_url.php');
require_once('injectors.php');


/**
 * Utility function; get a value from array by it's key, if the key exists; else return default value
 *
 * array_get($array, 'key', 'default')
 */
function array_get($array, $key, $default=null) {
    if (is_array($array) && array_key_exists($key, $array)) {
        return $array[$key];
    } else {
        return $default;
    }
}


/**
 * Other functions
 */

class BeforeRenderCallback {

    private $callbacks;
    private $cwd;

    public function __construct($callbacks, $cwd=null) {
        $this->callbacks = $callbacks;
        $this->cwd = $cwd;
    }
    
    public function addCallback($callback) {
        $this->callbacks[] = $callback;
    }

    public function __invoke($content, $phase) {
    
        if ($this->cwd) {
            chdir($this->cwd);
        }
    
        $content = trim($content);
        foreach ($this->callbacks as $callback) {
            $content = $callback($content, $this->cwd);
        }
        return $content;
    }
    
    public function prepare() {
        foreach ($this->callbacks as $callback) {
            $callback->prepare();
        }
    }
}


function incl($filename, $context=array()) {
    extract($context);
    require($filename);
}


function normalizePrice($price) {
    if (null !== $price) {
        if (intval($price) == $price) {
            $price = intval($price);
        }
    }
    return $price;
}


function getCommonContacts() {
    return array(
        'email' => 'tradehouse24h@gmail.com',
        'phone' => '+7 (499) 345-14-13',
    );
}


function redirect($url, $code=302) {
    header("Location: {$url}", true, $code);
    die();
}


function smartRedirect($url, $code=302) {
    if (strpos($url, '?') === false) {
        $url .= '?' . http_build_query($_GET);
    }
    if (strpos($url, '://') === false) {
        $url = getAbsoluteUri($url, HTTP_URL_JOIN_PATH);
    }
    redirect($url, $code);
}


function response($status, $message) {
    if ($status == 301 || $status == 302) {
        redirect($message, $status);
    }
    
    http_response_code($status);
    if (is_array($message)) {
        header('Content-Type: application/json');
        die(json_encode($message));
    } else {
        die($message);
    }
}


function getAbsoluteUri($location=null, $mode=null) {
    if($mode === null) {
        $mode=HTTP_URL_JOIN_PATH | HTTP_URL_JOIN_QUERY;
    }
    $isSecure = array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] == 'on';
    $pieces['scheme'] = $isSecure ? 'https' : 'http';
    $pieces['host'] = $_SERVER['HTTP_HOST'];
    
    if ($location !== null) {
        $path = explode('?', $location);
        if (count($path) > 1) {
            list($path, $query) = $path;
        } else {
            $path = $path[0];
            $query = '';
        }
        $pieces['path'] = $path;
        $pieces['query'] = $query;
    }
    
    return http_build_url(ltrim($_SERVER['REQUEST_URI'], '/'), $pieces, $mode);

}

function getCpaInvoiceUrl($orderId, $template='', $pixelData=array()) {

    global $shared_path;
    $url = $shared_path . '/invoice2/'. $template .'?t=' . $orderId;
    if ($pixelData) {
        foreach($pixelData as $key => $val) {
            if ($val) {
                $url .= '&' . $key . '=' . $val;        
            }
        }
    }
    return $url;
}


class DateFixer {

    private $maxDate;

    public function __construct($maxDate) {
        $this->maxDate = $maxDate;
    }
    
    public function fix($d) {
        $t = strtotime($d);
        $marginTs = strtotime($this->maxDate);
        $diff = strtotime('-2 day') - $marginTs;
        return date('d.m.Y', $t + $diff);
    }

}


function countrySelect() {
    
    global $offers, $offer;
    
    usort($offers, function($a, $b) {
        return strcmp($a['country']['name'], $b['country']['name']);
    });
    
    ob_start();
    ?>
    
    <select name="offer" class="form-control country_chang" <?= count($offers) === 1 ?  'style="display: none;"' : ''?>>
        <?php foreach($offers as $offerData): ?>
        <option 
            data-country-code="<?php echo $offerData['country']['code'] ?>"
            <?php if ($offerData['id'] == $offer['id']): ?>
            selected="selected"
            <?php endif ?>
            value="<?php echo $offerData['id'] ?>"
        >
            <?php echo $offerData['country']['name'] ?>
        </option>
        <?php endforeach ?>
    </select>
    <?php
    return ob_get_clean();
}


function countryDefault() {

    global $offer;
    ob_start();
    ?>

    <select name="offer" class="form-control country_chang" style="display: none;">
        <option
                data-country-code="<?php echo $offer['country']['code']; ?>"
                selected="selected"
                value="<?php echo $offer['id'] ?>"
        >
            <?php echo $offer['country']['name'] ?>
        </option>
    </select>

    <?php
    return ob_get_clean();
}

function showForm($width, $height, $args = [])
{
    /**
     * Функция создает HTML-разметку с формой заказа
     *
     * @param $width string ширина формы
     * @param $height string высота формы
     * @param $args array параметры формы
     * @return string HTML-разметка
     *
     * В массив $args можно передавать следующие параметры:
     *  language - язык на котором будет отбражаться форма: двузбуквенный код языка ISO 639-1
     *  select - оставить или скрыть выбор страны: 'countrySelect' или 'CountryDefault'
     *  is_price - чтобы скрыть цену передать значение 'no'
     *  color - доступные цвета: light, orange, blue, green, gray, dark
     *
     * Примеры вызова функции:
     *
     * showForm('80%', '600px', ['color' => 'blue', 'language' => 'el', 'is_price' => 'no']);
     * showForm(600px, '600px', ['color' => 'green', 'language' => 'ru', 'select' => 'countrySelect']);
     */

    global $dir_name, $language, $oldPriceHtml, $newPriceHtml, $currencyDisplayHtml;

    if (isset($args['language'])) {
        $language = $args['language'];
    }


    $file_translate = '../../../invoice2/languages/' . $language . '.php';

    if (!file_exists($file_translate)) {
        $file_translate = '../../../invoice2/languages/ru.php';
    }
    require($file_translate);


    $hide_price = isset($args['is_price']) && $args['is_price'] == 'no';
    $showCountry = (isset($args['select']) && $args['select'] == 'countrySelect') ? 'countrySelect' : 'countryDefault';


    $unique_postfix = uniqid('__');
    $css_classes = ["form_root", "app", "old_price", "new_price", "fieldset-row-list", "row", "wrapper-form", "order_form"];
    $css_uniq_classes = [];
    foreach ($css_classes as $class_name) {
        $css_uniq_classes[$class_name] = $class_name . $unique_postfix;
    }


    $colors_schemes = [
        'light' => ['background' => '#CC1414', 'background:hover' => '#FA0505'],
        'orange' => ['background' => 'orange', 'background:hover' => '#e7a553'],
        'blue' => ['background' => '#037fec', 'background:hover' => '#318aef'],
        'gray' => ['background' => 'gray', 'background:hover' => '#9f9f9f'],
        'green' => ['background' => '#00a000', 'background:hover' => '#00b800'],
        'dark' => ['background' => '#CC1414', 'background:hover' => '#FA0505'],
    ];
    $color = array_key_exists($args['color'], $colors_schemes) ? $args['color'] : 'light';


    ob_start();

    require_once('../../../lib/pieces/form_style.tpl.php');
    require_once('../../../lib/pieces/form.tpl.php');

    return ob_get_clean();
}

function footer($id=2) {
    ob_start();
    incl(__DIR__."/pieces/footer.{$id}.php");
    return ob_get_clean();
}


function trackerInjectorFactory($tracker, $trackerId, $convData, $params) {
    require_once("trackers/$tracker.php");
    $classname = str_replace('_', ' ', $tracker);
    $classname = ucwords($classname) . 'Injector';
    $classname = str_replace(' ', '', $classname);
    return new $classname($trackerId, $convData, ['webvisor' => true]);
}


function injectTrackers($renderCallback, $trackers, $convData=null) {
    foreach($trackers as $tracker => $trackerIds) {
        foreach ($trackerIds as $trackerId) {
            $trackerInjector = trackerInjectorFactory($tracker, $trackerId, $convData, ['webvisor' => true]);
            $renderCallback->addCallback($trackerInjector);
        }
    }
}

function pushupInjectorFactory($pushup, $pushupParams) {
    $push_path = "pushups/$pushup.php";
    if (!@include_once($push_path))  {
        return false;
    }
    else {
        $classname = str_replace('_', ' ', $pushup);
        $classname = ucwords($classname) . 'Injector';
        $classname = str_replace(' ', '', $classname);
        return new $classname($pushupParams);
    }
}

function injectPushup($renderCallback, $pushup, $pushupParams) {
    $pluginsInjector = pushupInjectorFactory($pushup, $pushupParams);
    $renderCallback->addCallback($pluginsInjector);
}

function pluginInjectorFactory($plugin, $pluginParams) {    
    require_once("plugins/$plugin.php");
    $classname = str_replace('_', ' ', $plugin);
    $classname = ucwords($classname) . 'Injector';
    $classname = str_replace(' ', '', $classname);    
    return new $classname($pluginParams);    
}

function injectPlugins($renderCallback, $plugins, $pluginsParams) {
    if ($plugins) {
        $pluginsParams['plugins'] = $plugins;
        $pluginsInjector = pluginInjectorFactory('plugins', $pluginsParams);
        $renderCallback->addCallback($pluginsInjector);

        foreach ($plugins as $plugin => $params) {
            $pluginsInjector = pluginInjectorFactory($plugin, $params);
            $renderCallback->addCallback($pluginsInjector);
        }
    }
}

class Products {

    private $country = null;
    private $products = null;

    public function __construct($country) {
        $this->country = $country;
    }

    public function set($products) {
        $this->products = $products;
    }
    
    public function get($productId) {
        $productData = $this->products[$productId];
        $product = new Product();
        $product->newPrice = $productData['newPrice'][$this->country];
        $product->oldPrice = $productData['oldPrice'][$this->country];
        return $product;
    }
    
}

class Product {
    public $newPrice;
    public $oldPrice;
}


function prepaid_info_html() {

}

function get_promo_price($price, $price_old){
    $price_promo = 0;
    if($price_old > 0 && $price_old > $price){ 
        $price_promo = intval($price + (($price_old - $price) / 2));     
    }
    if($price_promo == 0){
        $price_promo = intval($price + $price * 0.02);
    }
    return $price_promo;
}

function is_debug($set_display_error=False)
{
    // Проверяем включен ли debug mod
    global $_debug, $apiKey, $landKey, $dbg_mod;

    $dbg_mod = False;

    if ($_debug) {
        $dbg_mod = True;
    }

    if (isset($_GET['dbg']) && 1 == $_GET['dbg'] && isset($_GET['key']) && $apiKey == $_GET['key']) {
        $dbg_mod = True;

        // устанавливаем куку
        setcookie("dbg_hash", md5($landKey.$apiKey));
    }

    if (isset($_COOKIE['dbg_hash'])) {
        if ($_COOKIE['dbg_hash'] == md5($landKey.$apiKey)) {
            $dbg_mod = True;
        }
    }

    if ($dbg_mod and $set_display_error) {
        error_reporting(E_ALL);
        ini_set('display_startup_errors', 1);
        ini_set('display_errors', '1');
    }

    return $dbg_mod;
}

function display_debug_info($title, $data) {
    // выводит информацию об ошибках
    global $dbg_mod;
    if ($dbg_mod) {
        echo '<h3>'.$title.'</h3>';
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}


/**
 * Нормализация номера телефона в зависимости от кода страны.
 */
function normalizePhoneByCountry($countryCode, $phoneNumber)
{
    if (!is_string($countryCode)) {
        return $phoneNumber;
    }

    $normalizePhone = $phoneNumber;
    $countryCode = strtolower($countryCode);

    // Алжир
    if ($countryCode === 'dz') {
        $phoneCode = '+213';

        // Если код страны оказался в конце, то переносим в начало 
        if (!startsWith($phoneNumber, $phoneCode) and endsWith($phoneNumber, '213')) {
            $phoneNumber = $phoneCode . substr($phoneNumber, 0, -3);
        }

        # Для алжира номера +213111111111 и +2130111111111 являются одним и тем же номером
        # функция должна вернуть версию номера без нуля т.е. +213111111111 
        $normalizePhone = getPhoneNumberWithoutZero($phoneNumber, $phoneCode);

    // Кот-д'Ивуар
    } elseif($countryCode === 'ci') {
        $phoneCode = '+225';

        // Для данной страны 0 после кода должен быть всегда
        if (startsWith($phoneNumber, $phoneCode)) {
            $phoneWithoutCode = substr($phoneNumber, strlen($phoneCode));

            $normalizePhoneWithoutCode = strpos($phoneWithoutCode, '0') === 0
                ? $phoneWithoutCode
                : '0' . $phoneWithoutCode;
            
            $normalizePhone = $phoneCode . $normalizePhoneWithoutCode;
        }

    // Нигерия
    } elseif ($countryCode === 'ng') {
        $phoneCode = '+234';

        # Для нигерии номера +234111111111 и +2340111111111 являются одним и тем же номером
        # функция должна вернуть версию номера без нуля т.е. +254111111111 
        $normalizePhone = getPhoneNumberWithoutZero($phoneNumber, $phoneCode);
    }

    return $normalizePhone;
}


function startsWith( $haystack, $needle ) {
    $length = strlen( $needle );
    return substr( $haystack, 0, $length ) === $needle;
}


function endsWith( $haystack, $needle ) {
    $length = strlen( $needle );
    if( !$length ) {
        return true;
    }
    return substr( $haystack, -$length ) === $needle;
}


function getPhoneNumberWithoutZero($phoneNumber, $phoneCode)
{
    if (!is_string($phoneNumber) || !is_string($phoneCode) || !$phoneNumber || !$phoneCode) {
        return $phoneNumber;
    }

    $normalizePhone = $phoneNumber;

    $phoneNumber = $phoneNumber[0] == '+' ? str_replace('+', '', $phoneNumber) : $phoneNumber;
    $phoneCode = $phoneCode[0] == '+' ? str_replace('+', '', $phoneCode) : $phoneCode;

    if (strpos($phoneNumber, $phoneCode) === 0) {
        $phoneWithoutCode = substr($phoneNumber, strlen($phoneCode));
        $normalizePhoneWithoutCode = strpos($phoneWithoutCode, '0') === 0
            ? substr($phoneWithoutCode, 1)
            : $phoneWithoutCode;

        $normalizePhone = '+' . $phoneCode . $normalizePhoneWithoutCode;
    }
    return $normalizePhone;
}

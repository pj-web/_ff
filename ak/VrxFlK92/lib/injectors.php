<?php

require_once('template_checker.php');


class JsInjector {

    public $redirectUrl;
    public $fixImages;
    public $comebacker;
                
    private $code;

    public function __invoke($content, $cwd) {
        if (!strpos($content, '/shared/form.js')) {
            $content = preg_replace('#<(?!header)head([^>])*>#',  '<head$1>' . "\n" .$this->code, $content, 1);
        }
        return $content;
    }
    
    public function prepare() {
        $this->code = $this->render();
    }

    private function render() {
        ob_start();
        incl(__DIR__.'/pieces/js.php', array(
            'redirectUrl' => $this->redirectUrl, 
            'fixImages' => $this->fixImages,
            'comebacker' => $this->comebacker,
        ));
        $code = ob_get_clean();
        return $code;
    }
}

class PrelandInjector {

    public $redirectUrl;
    public $fixImages;
    public $comebacker;
                
    private $code;

    public function __invoke($content, $cwd) {
        return str_replace('</head>',  $this->code . '</head>', $content);
    }
    
    public function prepare() {
        $this->code = $this->render();
    }

    private function render() {
        ob_start();
        incl(__DIR__.'/pieces/js.preland.php', array(
            'redirectUrl' => $this->redirectUrl, 
            'fixImages' => $this->fixImages,
            'comebacker' => $this->comebacker,
        ));
        $code = ob_get_clean();
        return $code;
    }
}


class ProfilerInjector {
    
    private $startedAt;
    
    public function __construct() {
        $this->startedAt = microtime(true);
    }
    
    public function __invoke($content, $cwd) {
        $t = microtime(true) - $this->startedAt;
        header(sprintf('X-Render-Time: %.6f', $t));
        return $content;
    }
    
    public function prepare() {}
}

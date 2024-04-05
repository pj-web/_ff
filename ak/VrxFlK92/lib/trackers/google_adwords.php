<?php

class GoogleAdwordsInjector {

    public $counterId = null;
    public $convLabel = null;
    public $lead = false;
    public $template = 'google_adwords.tpl.php';
    private $code = '';

    public function __construct($counterId, $lead) {
        $counterId = explode('/', $counterId);
        $this->counterId = $counterId[0];
        if (count($counterId) == 2) {
            $this->convLabel = $counterId[1];
        }
        $this->lead = $lead;
    }
    
    public function __invoke($content, $cwd) {
        return preg_replace('#<body([^>])*>#',  '<body$1>' . "\n" .$this->code, $content, 1);
    }
    
    public function prepare() {
        $this->code = $this->render();
    }

    private function render() {
        ob_start();
        $lead = $this->lead;
        $counterId = $this->counterId;
        $convLabel = $this->convLabel;
        require($this->template);
        $code = ob_get_clean();
        return $code;
    }
}

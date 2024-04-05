<?php

class GoogleCounterInjector {

    public $counterId = null;
    public $lead = false;
    public $template = 'google_counter.tpl.php';
    private $code = '';

    public function __construct($counterId, $lead) {
        $this->counterId = $counterId;
        $this->lead = $lead;
    }
    
    public function __invoke($content, $cwd) {
        return str_replace('</head>',  $this->code . '</head>', $content);
    }
    
    public function prepare() {
        $this->code = $this->render();
    }

    private function render() {
        ob_start();
        $lead = $this->lead;
        $counterId = $this->counterId;
        require($this->template);
        $code = ob_get_clean();
        return $code;
    }
}

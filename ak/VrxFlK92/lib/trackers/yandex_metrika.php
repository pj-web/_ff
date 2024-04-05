<?php

class YandexMetrikaInjector {

    public $counterId = null;
    public $lead = false;
    public $webvisor = false;
    public $template = 'yandex_metrika.tpl.php';
    private $code = '';
    
    public function __construct($counterId, $lead, $params) {
        $this->counterId = $counterId;
        $this->lead = $lead;
        $this->webvisor = array_get($params, 'webvisor');
    }

    public function __invoke($content, $cwd) {
        return str_replace('</body>',  $this->code . '</body>', $content);
    }
    
    public function prepare() {
        if ($this->counterId) {
            $this->code = $this->render();
        }
    }

    private function render() {
        ob_start();
        $lead = $this->lead;
        $counterId = $this->counterId;
        $webvisor = $this->webvisor;
        require($this->template);
        $code = ob_get_clean();
        return $code;
    }
}

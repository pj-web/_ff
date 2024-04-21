<?php

class VkPixelInjector {

    public $counterId = null;
    public $lead = false;
    public $template = 'vk_pixel.tpl.php';
    private $code = '';

    public function __construct($counterId, $lead) {
        $this->counterId = $counterId;
        $this->lead = $lead;
    }
    
    public function __invoke($content, $cwd) {
        return str_replace('</body>',  $this->code . '</body>', $content);
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

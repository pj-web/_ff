<?php

class TemplateChecker {

    private $templateCode;
    public $debug = false;
    
    public function __construct($debugMode) {
        $this->debug = $debugMode;
        $this->templateCode = file_get_contents($_SERVER['SCRIPT_FILENAME']);
    }

    public function __invoke($content, $cwd) {
        $t = microtime(true);
        foreach (['onepage.end.php', 'preland.end.php'] as $unusedFilename) {
            if (strpos($this->templateCode, $unusedFilename)) {
                return $unusedFilename . ' is not used anymore!';
            }
        }
        
        $restrictedStuff = [
            'name="offer"',
            "name='offer'",
            'name=offer',
            'Muse.Redirect',
            '$siteToken',
            'fbevents.js',
            'metrika/watch.js',
            'mail.ru/js/code.js',
            'analytics.js',
            'price_field_s',
        ];
        
        foreach ($restrictedStuff as $word) {
            if (strpos($this->templateCode, $word)) {
                return sprintf('"%s" is not allowed; remove it from template', htmlentities($word));
            }
        }
        
        $neededStuff = [
            '</body>',
            '</head>',
        ];
        
        foreach ($neededStuff as $word) {
            if (!strpos($this->templateCode, $word)) {
                return sprintf('"%s" is absent; check template code', htmlentities($word));
            }
        }

        if (!$this->debug) {
            return $content;
        }
        
        $dir = new RecursiveDirectoryIterator($cwd);
        $ite = new RecursiveIteratorIterator($dir);
        $files = new RegexIterator($ite, '#.+\.js$#', RegexIterator::GET_MATCH);
        
        foreach($files as $jsfiles) {
            $jsfile = array_pop($jsfiles);
            $jstext = file_get_contents($jsfile);
            
            foreach ($restrictedStuff as $word) {
                if (strpos($jstext, $word) !== false) {
                    return sprintf('"%s" is not allowed; remove it from %s', $word, $jsfile);
                }
            }
        }
        
        $t = microtime(true) - $t;
        header(sprintf('X-Check-Time: %.6f ', $t));
        
        return $content;
    }
    
    public function prepare() {}
    
}


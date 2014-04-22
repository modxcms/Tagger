<?php

class TaggerGateway {
    /** @var modX $modx */
    private $modx;

    private $scriptProperties;

    private $pieces;

    public function __construct(modX &$modx) {
        $this->modx =& $modx;
    }

    public function init($scriptProperties) {
        $this->scriptProperties = $scriptProperties;
    }

    public function handleRequest() {
        $this->pieces = explode('/', trim($_REQUEST[$this->modx->getOption('request_param_alias', null, 'q')], ' '));

        $pieces = array_flip($this->pieces);
        $tagKey = $this->modx->getOption('tagger.tag_key', null, 'tags');
        if (!isset($pieces[$tagKey])) return false;

        if ($this->pieces[count($this->pieces) - 1] != '') {
            $this->modx->sendRedirect(MODX_SITE_URL . implode('/', $this->pieces) . '/', array('responseCode' => 'HTTP/1.1 301 Moved Permanently'));
        }

        if (count($this->pieces) == 0 || (count($this->pieces) == 1 && $this->pieces[0] == '')) return;

        $this->processRequest();
    }

    private function processRequest() {
        $pieces = array_flip($this->pieces);
        $tagKey = $this->modx->getOption('tagger.tag_key', null, 'tags');
        if (!isset($pieces[$tagKey])) return false;

        $tags = array_slice($this->pieces, $pieces[$tagKey] + 1);
        $_GET[$tagKey] = implode(',', $tags);

        $this->pieces = array_slice($this->pieces, 0, $pieces[$tagKey]);

        $q = implode('/', $this->pieces);

        if ($q != '') {
            $q .= '/';
        } else {
            $siteStart = $this->modx->getObject('modResource', $this->modx->getOption('site_start'));
            $q = $siteStart->alias;
        }

        $_REQUEST[$this->modx->getOption('request_param_alias', null, 'q')] = $q;

        return true;
    }
}
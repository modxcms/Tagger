<?php

class TaggerGateway {
    /** @var modX $modx */
    private $modx;

    private $scriptProperties;

    private $pieces;

    private $groups;
    private $tags = array();

    public function __construct(modX &$modx) {
        $this->modx =& $modx;
    }

    public function init($scriptProperties) {
        $this->scriptProperties = $scriptProperties;
    }

    public function handleRequest() {
        $requestParamAlias = $this->modx->getOption('request_param_alias', null, 'q');
        if (!isset($_REQUEST[$requestParamAlias])) return true;

        $this->pieces = explode('/', trim($_REQUEST[$requestParamAlias], ' '));
        $pieces = array_flip($this->pieces);

        $c = $this->modx->newQuery('TaggerGroup');
        $c->select($this->modx->getSelectColumns('TaggerGroup', '', '', array('alias')));
        $c->prepare();
        $c->stmt->execute();
        $this->groups = $c->stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        foreach ($this->groups as $group) {
            if (isset($pieces[$group])) {
                $this->tags[$group] = $pieces[$group];
            }
        }

        if (count($this->tags) == 0) return false;

        asort($this->tags);

        if ($this->pieces[count($this->pieces) - 1] != '') {
            $this->modx->sendRedirect(MODX_SITE_URL . implode('/', $this->pieces) . '/', array('responseCode' => 'HTTP/1.1 301 Moved Permanently'));
        }

        if (count($this->pieces) == 0 || (count($this->pieces) == 1 && $this->pieces[0] == '')) return false;

        $this->processRequest();

        return true;
    }

    private function processRequest() {
        $prev = array('group' => '', 'id' => -1);
        $pieces = array();
        foreach ($this->tags as $group => $id) {
            if ($prev['id'] == -1) {
                $pieces = array_slice($this->pieces, 0, $id);
                $prev['id'] = $id;
                $prev['group'] = $group;
                continue;
            }

            $_GET[$prev['group']] = $this->modx->tagger->cleanAndImplode(array_slice($this->pieces, $prev['id'] + 1, $id - $prev['id'] - 1));
            $prev['id'] = $id;
            $prev['group'] = $group;
        }

        $_GET[$prev['group']] = $this->modx->tagger->cleanAndImplode(array_slice($this->pieces, $prev['id'] + 1));

        $q = implode('/', $pieces);
        if ($q == '') {
            $siteStart = $this->modx->getObject('modResource', $this->modx->getOption('site_start'));
            $q = $siteStart->alias;
        }

        $_REQUEST[$this->modx->getOption('request_param_alias', null, 'q')] = $q;

        return true;
    }
}
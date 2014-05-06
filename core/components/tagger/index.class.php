<?php
require_once dirname(__FILE__) . '/model/tagger/tagger.class.php';
/**
 * @package tagger
 */

abstract class TaggerBaseManagerController extends modExtraManagerController {
    /** @var Tagger $tagger */
    public $tagger;
    public function initialize() {
        $this->tagger = new Tagger($this->modx);

        $this->addCss($this->tagger->getOption('cssUrl').'mgr.css');
        $this->addJavascript($this->tagger->getOption('jsUrl').'mgr/tagger.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            Tagger.config = '.$this->modx->toJSON($this->tagger->options).';
            Tagger.config.connector_url = "'.$this->tagger->getOption('connectorUrl').'";
        });
        </script>');
        return parent::initialize();
    }
    public function getLanguageTopics() {
        return array('tagger:default');
    }
    public function checkPermissions() { return true;}
}

class IndexManagerController extends TaggerBaseManagerController {
    public static function getDefaultController() { return 'home'; }
}
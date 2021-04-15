<?php

use MODX\Revolution\modExtraManagerController;
use Tagger\Tagger;

/**
 * @package tagger
 */
abstract class TaggerBaseManagerController extends modExtraManagerController
{

    /** @var Tagger $tagger */
    public $tagger;

    public function initialize()
    {
        $this->tagger = $this->modx->services->get('tagger');

        $this->addCss($this->tagger->getOption('cssUrl') . 'mgr.css');
        $this->addJavascript($this->tagger->getOption('jsUrl') . 'mgr/tagger.js');
        $this->addHtml('
            <script type="text/javascript">
                Ext.onReady(function() {
                    tagger.config = ' . $this->modx->toJSON($this->tagger->options) . ';
                });
            </script>
        ');

        parent::initialize();
    }

    public function getLanguageTopics()
    {
        return ['tagger:default'];
    }

    public function checkPermissions()
    {
        return true;
    }

}

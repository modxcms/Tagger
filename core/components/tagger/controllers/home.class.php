<?php
/**
 * Loads the home page.
 *
 * @package tagger
 * @subpackage controllers
 */
class TaggerHomeManagerController extends TaggerBaseManagerController {
    public function process(array $scriptProperties = array()) {

    }
    public function getPageTitle() { return $this->modx->lexicon('tagger'); }
    public function loadCustomCssJs() {

        $this->addJavascript($this->tagger->getOption('jsUrl').'mgr/extras/tagger.combo.js');

        $this->addJavascript($this->tagger->getOption('jsUrl').'mgr/widgets/tag/tag.grid.js');
        $this->addJavascript($this->tagger->getOption('jsUrl').'mgr/widgets/tag/tag.window.js');

        $this->addJavascript($this->tagger->getOption('jsUrl').'mgr/widgets/group/group.grid.js');
        $this->addJavascript($this->tagger->getOption('jsUrl').'mgr/widgets/group/group.window.js');
        $this->addJavascript($this->tagger->getOption('jsUrl').'mgr/widgets/home.panel.js');
        $this->addLastJavascript($this->tagger->getOption('jsUrl').'mgr/sections/home.js');
    
    }

    public function getTemplateFile() { return $this->tagger->getOption('templatesPath').'home.tpl'; }
}
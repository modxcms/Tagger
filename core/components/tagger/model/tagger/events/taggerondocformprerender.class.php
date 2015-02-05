<?php

class TaggerOnDocFormPrerender extends TaggerPlugin {
    public function run()
    {
        $mode = $this->modx->getOption('mode', $this->scriptProperties, 'upd');

        $this->modx->controller->addLexiconTopic('tagger:default');

        if ($this->modx->version['major_version'] < 3) {
            $this->modx->regClientCSS($this->tagger->getOption('cssUrl') . 'tagfield_under_2_3.css');
        } else {
            $this->modx->regClientCSS($this->tagger->getOption('cssUrl') . 'tagfield.css');
        }

        $this->modx->regClientStartupScript($this->tagger->getOption('jsUrl').'mgr/tagger.js');
        $this->modx->regClientStartupScript($this->tagger->getOption('jsUrl').'mgr/extras/tagger.tagfield.js');
        $this->modx->regClientStartupScript($this->tagger->getOption('jsUrl').'mgr/extras/tagger.combo.js');

        $c = $this->modx->newQuery('TaggerGroup');
        $c->sortby('position');

        /** @var TaggerGroup[] $groups */
        $groups = $this->modx->getIterator('TaggerGroup', $c);
        $groupsArray = array();
        foreach ($groups as $group) {
            $showForTemplates = $group->show_for_templates;
            $showForTemplates = $this->tagger->explodeAndClean($showForTemplates);
            $groupsArray[] = array_merge($group->toArray(), array('show_for_templates' => $showForTemplates));
        }

        $tagsArray = array();

        if ($mode == 'upd') {
            $c = $this->modx->newQuery('TaggerTagResource');
            $c->where(array('resource' => intval($_GET['id'])));

            /** @var TaggerTagResource[] $relatedTags */
            $relatedTags = $this->modx->getIterator('TaggerTagResource', $c);

            foreach ($relatedTags as $relatedTag) {
                if (!isset($tagsArray['tagger-' . $relatedTag->Tag->group])) {
                    $tagsArray['tagger-' . $relatedTag->Tag->group] = $relatedTag->Tag->tag;
                } else {
                    $tagsArray['tagger-' . $relatedTag->Tag->group] .= ',' . $relatedTag->Tag->tag;
                }
            }
        }

        $this->modx->regClientStartupHTMLBlock('<script type="text/javascript">
            Tagger.config = '.$this->modx->toJSON($this->tagger->options).';
            Tagger.config.connector_url = "'.$this->tagger->getOption('connectorUrl').'";
            Tagger.groups = ' . $this->modx->toJSON($groupsArray) . ';
            Tagger.tags = ' . $this->modx->toJSON($tagsArray) . ';
        </script>');

        $this->modx->regClientStartupScript($this->tagger->getOption('jsUrl').'mgr/inject/tab.js');
    }

}
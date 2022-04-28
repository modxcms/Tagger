<?php

namespace Tagger\Events;

use Tagger\Model\TaggerGroup;
use Tagger\Model\TaggerTag;
use Tagger\Model\TaggerTagResource;

class OnDocFormPreRender extends Event
{

    public function run()
    {
        $mode = $this->modx->getOption('mode', $this->scriptProperties, 'upd');

        $this->modx->controller->addLexiconTopic('tagger:default');
        $this->modx->regClientCSS($this->tagger->getOption('cssUrl') . 'tagfield.css');

        $this->modx->regClientStartupScript($this->tagger->getOption('jsUrl') . 'mgr/tagger.js');
        $this->modx->regClientStartupScript($this->tagger->getOption('jsUrl') . 'mgr/extras/tagger.tagfield.js');
        $this->modx->regClientStartupScript($this->tagger->getOption('jsUrl') . 'mgr/extras/tagger.combo.js');

        $c = $this->modx->newQuery(TaggerGroup::class);
        $c->sortby('position');

        /** @var TaggerGroup[] $groups */
        $groups = $this->modx->getIterator(TaggerGroup::class, $c);
        $groupsArray = [];
        foreach ($groups as $group) {
            $showForTemplates = $group->show_for_templates;
            $showForTemplates = \Tagger\Utils::explodeAndClean($showForTemplates, ',', true);

            $showForContexts = $group->show_for_contexts;
            $showForContexts = \Tagger\Utils::explodeAndClean($showForContexts);

            $groupsArray[] = array_merge(
                $group->toArray(),
                [
                    'show_for_templates' => array_values($showForTemplates),
                    'show_for_contexts'  => array_values($showForContexts),
                ]
            );
        }

        $tagsArray = [];

        if ($mode == 'upd') {
            $c = $this->modx->newQuery(TaggerTagResource::class);
            $c->leftJoin(TaggerTag::class, 'Tag');
            $c->where(['resource' => intval($_GET['id'])]);
            $c->sortby('Tag.alias', 'ASC');
            $c->select($this->modx->getSelectColumns(TaggerTagResource::class, 'TaggerTagResource', '', ['resource']));
            $c->select($this->modx->getSelectColumns(TaggerTag::class, 'Tag', '', ['tag', 'group']));

            $c->prepare();
            $c->stmt->execute();
            while ($relatedTag = $c->stmt->fetch(\PDO::FETCH_ASSOC)) {
                if (!isset($tagsArray['tagger-' . $relatedTag['group']])) {
                    $tagsArray['tagger-' . $relatedTag['group']] = $relatedTag['tag'];
                } else {
                    $tagsArray['tagger-' . $relatedTag['group']] .= ',' . $relatedTag['tag'];
                }
            }
        }

        $this->modx->regClientStartupHTMLBlock('
        <script type="text/javascript">
            tagger.config = ' . $this->modx->toJSON($this->tagger->options) . ';
            tagger.groups = ' . $this->modx->toJSON($groupsArray) . ';
            tagger.tags = ' . $this->modx->toJSON($tagsArray) . ';
        </script>
        ');

        $this->modx->regClientStartupScript($this->tagger->getOption('jsUrl') . 'mgr/inject/tab.js');
    }

}

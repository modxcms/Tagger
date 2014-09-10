<?php

/**
 * The main Tagger service class.
 *
 * @package tagger
 */
class Tagger {
    public $modx = null;
    public $namespace = 'tagger';
    public $cache = null;
    public $options = array();

    public function __construct(modX &$modx, array $options = array()) {
        $this->modx =& $modx;
        $this->namespace = $this->getOption('namespace', $options, 'tagger');

        $corePath = $this->getOption('core_path', $options, $this->modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/tagger/');
        $assetsPath = $this->getOption('assets_path', $options, $this->modx->getOption('assets_path', null, MODX_ASSETS_PATH) . 'components/tagger/');
        $assetsUrl = $this->getOption('assets_url', $options, $this->modx->getOption('assets_url', null, MODX_ASSETS_URL) . 'components/tagger/');

        /* loads some default paths for easier management */
        $this->options = array_merge(array(
            'namespace' => $this->namespace,
            'corePath' => $corePath,
            'modelPath' => $corePath . 'model/',
            'chunksPath' => $corePath . 'elements/chunks/',
            'snippetsPath' => $corePath . 'elements/snippets/',
            'templatesPath' => $corePath . 'templates/',
            'assetsPath' => $assetsPath,
            'assetsUrl' => $assetsUrl,
            'jsUrl' => $assetsUrl . 'js/',
            'cssUrl' => $assetsUrl . 'css/',
            'connectorUrl' => $assetsUrl . 'connector.php'
        ), $options);

        $this->modx->addPackage('tagger', $this->getOption('modelPath'));
        $this->modx->lexicon->load('tagger:default');
        $this->modx->lexicon->load('tagger:custom');
    }

    /**
     * Get a local configuration option or a namespaced system setting by key.
     *
     * @param string $key The option key to search for.
     * @param array $options An array of options that override local options.
     * @param mixed $default The default value returned if the option is not found locally or as a
     * namespaced system setting; by default this value is null.
     * @return mixed The option value or the default value specified.
     */
    public function getOption($key, $options = array(), $default = null) {
        $option = $default;
        if (!empty($key) && is_string($key)) {
            if ($options != null && array_key_exists($key, $options)) {
                $option = $options[$key];
            } elseif (array_key_exists($key, $this->options)) {
                $option = $this->options[$key];
            } elseif (array_key_exists("{$this->namespace}.{$key}", $this->modx->config)) {
                $option = $this->modx->getOption("{$this->namespace}.{$key}");
            }
        }
        return $option;
    }

    public function explodeAndClean($array, $delimiter = ',') {
        $array = explode($delimiter, $array);            // Explode fields to array
        $array = array_map('trim', $array);       // Trim array's values
        $array = array_keys(array_flip($array));  // Remove duplicate fields
        $array = array_filter($array);            // Remove empty values from array

        return $array;
    }

    public function cleanAndImplode($array, $delimiter = ',') {
        $array = array_map('trim', $array);       // Trim array's values
        $array = array_keys(array_flip($array));  // Remove duplicate fields
        $array = array_filter($array);            // Remove empty values from array
        $array = implode($delimiter, $array);

        return $array;
    }

    public function onDocFormPrerender($scriptProperties) {
        $mode = $this->modx->getOption('mode', $scriptProperties, 'upd');

        $this->modx->controller->addLexiconTopic('tagger:default');

        if ($this->modx->version['major_version'] < 3) {
            $this->modx->regClientCSS($this->getOption('cssUrl') . 'tagfield_under_2_3.css');
        } else {
            $this->modx->regClientCSS($this->getOption('cssUrl') . 'tagfield.css');
        }

        $this->modx->regClientStartupScript($this->getOption('jsUrl').'mgr/tagger.js');
        $this->modx->regClientStartupScript($this->getOption('jsUrl').'mgr/extras/tagger.tagfield.js');
        $this->modx->regClientStartupScript($this->getOption('jsUrl').'mgr/extras/tagger.combo.js');

        $c = $this->modx->newQuery('TaggerGroup');
        $c->sortby('position');

        $groups = $this->modx->getIterator('TaggerGroup', $c);
        $groupsArray = array();
        foreach ($groups as $group) {
            $showForTemplates = $group->show_for_templates;
            $showForTemplates = $this->explodeAndClean($showForTemplates);
            $groupsArray[] = array_merge($group->toArray(), array('show_for_templates' => $showForTemplates));
        }

        $tagsArray = array();

        if ($mode == 'upd') {
            $c = $this->modx->newQuery('TaggerTagResource');
            $c->where(array('resource' => intval($_GET['id'])));
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
        //Ext.onReady(function() {
            Tagger.config = '.$this->modx->toJSON($this->options).';
            Tagger.config.connector_url = "'.$this->getOption('connectorUrl').'";
            Tagger.groups = ' . $this->modx->toJSON($groupsArray) . ';
            Tagger.tags = ' . $this->modx->toJSON($tagsArray) . ';
        //});
        </script>');

        $this->modx->regClientStartupScript($this->getOption('jsUrl').'mgr/inject/tab.js');
    }

    public function onDocFormSave($scriptProperties) {
        $resource = $this->modx->getOption('resource', $scriptProperties, '');

        $groups = $this->modx->getIterator('TaggerGroup');

        foreach ($groups as $group) {
            $showForTemplates = $group->show_for_templates;
            $showForTemplates = $this->explodeAndClean($showForTemplates);
            $showForTemplates = array_flip($showForTemplates);

            if (!isset($showForTemplates[$resource->template])) {
                continue;
            }

            $oldTagsQuery = $this->modx->newQuery('TaggerTagResource');
            $oldTagsQuery->leftJoin('TaggerTag', 'Tag');
            $oldTagsQuery->where(array('resource' => $resource->id, 'Tag.group' => $group->id));
            $oldTagsQuery->select($this->modx->getSelectColumns('TaggerTagResource', 'TaggerTagResource', '', array('tag')));

            $oldTagsQuery->prepare();
            $oldTagsQuery->stmt->execute();
            $oldTags = $oldTagsQuery->stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            $oldTags = array_flip($oldTags);

            $tags = $resource->get('tagger-' . $group->id);
            if ($tags === null) {
                continue;
            }

            if (isset($tags)) {
                $tags = $this->explodeAndClean($tags);

                foreach ($tags as $tag) {
                    /** @var TaggerTag $tagObject */
                    $tagObject = $this->modx->getObject('TaggerTag', array('tag' => $tag, 'group' => $group->id));
                    if ($tagObject) {
                        $existsRelation = $this->modx->getObject('TaggerTagResource', array('tag' => $tagObject->id, 'resource' => $resource->id));
                        if ($existsRelation) {
                            if (isset($oldTags[$existsRelation->tag])) {
                                unset($oldTags[$existsRelation->tag]);
                            }

                            continue;
                        }
                    }

                    if (!$tagObject) {
                        if (!$group->allow_new) {
                            continue;
                        }

                        $tagObject = $this->modx->newObject('TaggerTag');
                        $tagObject->set('tag', $tag);
                        $tagObject->addOne($group, 'Group');
                        $tagObject->save();
                    }

                    /** @var TaggerTagResource $relationObject */
                    $relationObject = $this->modx->newObject('TaggerTagResource');
                    $relationObject->set('tag', $tagObject->id);
                    $relationObject->set('resource', $resource->id);
                    $relationObject->save();
                }
            }

            if (count($oldTags) > 0) {
                $oldTags = array_keys($oldTags);
                $this->modx->removeCollection('TaggerTagResource', array(
                    'tag:IN' => $oldTags,
                    'AND:resource:=' => $resource->id
                ));
            }

            if ($group->remove_unused) {
                $c = $this->modx->newQuery('TaggerTagResource');
                $c->select($this->modx->getSelectColumns('TaggerTagResource', 'TaggerTagResource', '', array('tag')));
                $c->prepare();
                $c->stmt->execute();
                $IDs = $c->stmt->fetchAll(PDO::FETCH_COLUMN, 0);

                $IDs = array_keys(array_flip($IDs));

                if (count($IDs) > 0) {
                    $this->modx->removeCollection('TaggerTag', array('id:NOT IN' => $IDs, 'group' => $group->id));
                }

            }
        }
    }

    public function onHandleRequest($scriptProperties) {
        if ($this->modx->context->get('key') == 'mgr') {
            return;
        }

        $friendlyURL = $this->modx->getOption('friendly_urls', null, 0);
        if ($friendlyURL == 0) {
            return;
        }

        if (!class_exists('TaggerGateway')) {
            require_once dirname(__FILE__) . '/taggergateway.class.php';
        }

        $gateway = new TaggerGateway($this->modx);
        $gateway->init($scriptProperties);
        $gateway->handleRequest();
    }

    public function onResourceDuplicate($scriptProperties) {
        /** @var modResource $oldResource */
        $oldResource = $scriptProperties['oldResource'];

        /** @var modResource $newResource */
        $newResource = $scriptProperties['newResource'];

        $oldRelations = $this->modx->getIterator('TaggerTagResource', array('resource' => $oldResource->id));
        /** @var TaggerTagResource $oldRelation */
        foreach ($oldRelations as $oldRelation) {
            $newRelation = $this->modx->newObject('TaggerTagResource');
            $newRelation->set('resource', $newResource->id);
            $newRelation->set('tag', $oldRelation->tag);
            $newRelation->save();
        }

        $this->duplicateChildren($oldResource->Children, $newResource->Children);
    }

    private function duplicateChildren($oldChildren, $newChildren) {
        if (empty($oldChildren) || empty($newChildren)) return;

        if (count($oldChildren) != count($newChildren)) return;

        $oldNew = array_combine(array_keys($oldChildren), array_keys($newChildren));

        foreach ($oldChildren as $key => $oldChild) {
            $oldRelations = $this->modx->getIterator('TaggerTagResource', array('resource' => $oldChild->id));

            /** @var TaggerTagResource $oldRelation */
            foreach ($oldRelations as $oldRelation) {
                $newRelation = $this->modx->newObject('TaggerTagResource');
                $newRelation->set('resource', $newChildren[$oldNew[$key]]->id);
                $newRelation->set('tag', $oldRelation->tag);
                $newRelation->save();
            }

            $this->duplicateChildren($oldChild->Children, $newChildren[$oldNew[$key]]->Children);
        }
    }
}
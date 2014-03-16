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

    public function onDocFormPrerender($scriptProperties) {
        $this->modx->controller->addLexiconTopic('tagger:default');

        $this->modx->regClientCSS($this->getOption('cssUrl') . 'tagfield.css');

        $this->modx->regClientStartupScript($this->getOption('jsUrl').'mgr/tagger.js');
        $this->modx->regClientStartupScript($this->getOption('jsUrl').'mgr/extras/tagger.tagfield.js');

        $groups = $this->modx->getIterator('TaggerGroup');
        $groupsArray = [];
        foreach ($groups as $group) {
            $groupsArray[] = $group->toArray();
        }

        $this->modx->regClientStartupHTMLBlock('<script type="text/javascript">
        //Ext.onReady(function() {
            Tagger.config = '.$this->modx->toJSON($this->options).';
            Tagger.config.connector_url = "'.$this->getOption('connectorUrl').'";
            Tagger.groups = ' . $this->modx->toJSON($groupsArray) . ';
        //});
        </script>');

        $this->modx->regClientStartupScript($this->getOption('jsUrl').'mgr/inject/tab.js');
    }

    public function onDocFormSave($scriptProperties) {
        $resource = $this->modx->getOption('resource', $scriptProperties, '');

        $groups = $this->modx->getIterator('TaggerGroup');

        foreach ($groups as $group) {
            $oldTagsQuery = $this->modx->newQuery('TaggerTagResource');
            $oldTagsQuery->leftJoin('TaggerTag', 'Tag');
            $oldTagsQuery->where(array('resource' => $resource->id, 'Tag.group' => $group->id));
            $oldTagsQuery->select($this->modx->getSelectColumns('TaggerTagResource', 'TaggerTagResource', '', array('id')));

            $oldTagsQuery->prepare();
            $oldTagsQuery->stmt->execute();
            $oldTags = $oldTagsQuery->stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            $oldTags = array_flip($oldTags);

            $tags = $resource->get('tagger-' . $group->id);
            if (isset($tags)) {
                $tags = $this->explodeAndClean($tags);

                foreach ($tags as $tag) {
                    /** @var TaggerTag $tagObject */
                    $tagObject = $this->modx->getObject('TaggerTag', array('tag' => $tag, 'group' => $group->id));
                    if ($tagObject) {
                        $existsRelation = $this->modx->getObject('TaggerTagResource', array('tag' => $tagObject->id));
                        if ($existsRelation) {
                            if (isset($oldTags[$existsRelation->id])) {
                                unset($oldTags[$existsRelation->id]);
                            }

                            continue;
                        }
                    }

                    if (!$tagObject) {
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

            $oldTags = array_keys($oldTags);
            $this->modx->removeObject('TaggerTagResource', array('id:IN' => $oldTags));

            $tagsToRemoveQuery = $this->modx->newQuery('TaggerTag');
            $tagsToRemoveQuery->where(array(
                'group' => $group->id,
                "NOT EXISTS (SELECT 1 FROM {$this->modx->getTableName('TaggerTagResource')} r WHERE r.tag = TaggerTag.id)"
            ));

            $tagsToRemove = $this->modx->getIterator('TaggerTag', $tagsToRemoveQuery);
            foreach ($tagsToRemove as $tag) {
                /** @var TaggerTag $tag */
                $tag->remove();
            }
        }
    }
}
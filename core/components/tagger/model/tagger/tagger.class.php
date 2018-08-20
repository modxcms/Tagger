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

    public function explodeAndClean($array, $delimiter = ',', $keepZero = false) {
        $array = explode($delimiter, $array);            // Explode fields to array
        $array = array_map('trim', $array);       // Trim array's values
        $array = array_keys(array_flip($array));  // Remove duplicate fields
        
        if ($keepZero === false) {
            $array = array_filter($array);            // Remove empty values from array
        } else {
            $array = array_filter($array, function($value) { return $value !== ''; });
        }

        return $array;
    }

    public function cleanAndImplode($array, $delimiter = ',') {
        $array = array_map('trim', $array);       // Trim array's values
        $array = array_keys(array_flip($array));  // Remove duplicate fields
        $array = array_filter($array);            // Remove empty values from array
        $array = implode($delimiter, $array);

        return $array;
    }

    public function getChunk($tpl, $phs = array()) {
        if (strpos($tpl, '@INLINE ') !== false) {
            $content = str_replace('@INLINE', '', $tpl);
            /** @var modChunk $chunk */
            $chunk = $this->modx->newObject('modChunk', array('name' => 'inline-' . uniqid()));
            $chunk->setCacheable(false);

            return $chunk->process($phs, $content);
        }

        return $this->modx->getChunk($tpl, $phs);
    }

    public function getCurrentTags()
    {
        $currentTags = array();
        
        /** @var TaggerGroup[] $groups */
        $groups = $this->modx->getIterator('TaggerGroup');
        foreach ($groups as $group) {
            if (isset($_GET[$group->alias])) {
                $groupTags = $this->explodeAndClean($_GET[$group->alias]);
                if (!empty($groupTags)) {
                    $tags = array();
                    foreach ($groupTags as $groupTag) {
                        /** @var TaggerTag $tag */
                        $tag = $this->modx->getObject('TaggerTag', array(array('id' => $groupTag,'OR:alias:=' => $groupTag), 'group' => $group->id));
                        if ($tag) {
                            $tags[$tag->alias] = array(
                                'tag' => $tag->tag,
                                'label' => $tag->label,
                                'alias' => $tag->alias
                            );
                        } else {
                            $tags[$groupTag] = array(
                                'tag' => $groupTag,
                                'alias' => $groupTag
                            );
                        }
                    }
                    
                    $currentTags[$group->alias] = array(
                        'group' => $group->name,
                        'alias' => $group->alias,
                        'tags' => $tags
                    );
                }
            }
        }
        
        return $currentTags;
    }

    public function getTags($scriptProperties)
    {
        $resources = $this->modx->getOption('resources', $scriptProperties, '');
        $parents = $this->modx->getOption('parents', $scriptProperties, '');
        $groups = $this->modx->getOption('groups', $scriptProperties, '');
        $showUnused = (int) $this->modx->getOption('showUnused', $scriptProperties, '0');
        $showUnpublished = (int) $this->modx->getOption('showUnpublished', $scriptProperties, '0');
        $showDeleted = (int) $this->modx->getOption('showDeleted', $scriptProperties, '0');
        $contexts = $this->modx->getOption('contexts', $scriptProperties, '');
        $limit = intval($this->modx->getOption('limit', $scriptProperties, 0));
        $offset = intval($this->modx->getOption('offset', $scriptProperties, 0));

        $sort = $this->modx->getOption('sort', $scriptProperties, '{}');
        $sort = $this->modx->fromJSON($sort);
        if ($sort === null || $sort == '' || count($sort) == 0) {
            $sort = array(
                'tag' => 'ASC'
            );
        }

        $resources = $this->explodeAndClean($resources);
        $parents = $this->explodeAndClean($parents);
        $groups = $this->explodeAndClean($groups);
        $contexts = $this->explodeAndClean($contexts);

        $c = $this->modx->newQuery('TaggerTag');

        $c->leftJoin('TaggerTagResource', 'Resources');
        $c->leftJoin('TaggerGroup', 'Group');
        $c->leftJoin('modResource', 'Resource', array('Resources.resource = Resource.id'));

        if (!empty($parents)) {
            $c->where(array(
                'Resource.parent:IN' => $parents,
            ));
        }

        if (!empty($contexts)) {
            $c->where(array(
                'Resource.context_key:IN' => $contexts,
            ));
        }

        if ($showUnpublished == 0) {
            $c->where(array(
                'Resource.published' => 1,
                'OR:Resource.published:IN' => null,
            ));
        }

        if ($showDeleted == 0) {
            $c->where(array(
                'Resource.deleted' => 0,
                'OR:Resource.deleted:IS' => null,
            ));
        }

        if ($showUnused == 0) {
            $c->having(array(
                'cnt > 0',
            ));
        }

        if (!empty($resources)) {
            $c->where(array(
                'Resources.resource:IN' => $resources
            ));
        }

        if ($groups) {
            $c->where(array(
                'Group.id:IN' => $groups,
                'OR:Group.name:IN' => $groups,
                'OR:Group.alias:IN' => $groups,
            ));
        }
        $c->select($this->modx->getSelectColumns('TaggerTag', 'TaggerTag'));
        $c->select($this->modx->getSelectColumns('TaggerGroup', 'Group', 'group_'));
        $c->select(array('cnt' => 'COUNT(Resources.tag)'));
        $c->groupby($this->modx->getSelectColumns('TaggerTag', 'TaggerTag') . ',' . $this->modx->getSelectColumns('TaggerGroup', 'Group'));

        $c->prepare();

        $countQuery = new xPDOCriteria($this->modx, "SELECT COUNT(*) as total, MAX(cnt) as max_cnt FROM ({$c->toSQL(false)}) cq", $c->bindings, $c->cacheFlag);
        $stmt = $countQuery->prepare();

        $result = new TaggerResult();

        if ($stmt && $stmt->execute()) {
            $fetchedData = $stmt->fetch(PDO::FETCH_ASSOC);
            $result->total = intval($fetchedData['total']);
            $result->maxCnt = intval($fetchedData['max_cnt']);
        }


        foreach ($sort as $field => $dir) {
            $dir = (strtolower($dir) == 'asc') ? 'asc' : 'desc';
            $c->sortby($field, $dir);
        }

        $c->limit($limit, $offset);

        $result->tags = $this->modx->getIterator('TaggerTag', $c);
        return $result;
    }
}
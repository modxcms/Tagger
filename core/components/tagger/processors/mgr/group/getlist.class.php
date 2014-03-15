<?php
/**
 * Get list Groups
 *
 * @package tagger
 * @subpackage processors
 */
class TaggerGroupGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'TaggerGroup';
    public $languageTopics = array('tagger:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'tagger.group';

    public function initialize() {
        $initialized = parent::initialize();

        $this->setDefaultProperties(array(
            'addNone' => false,
        ));

        return $initialized;
    }

    public function beforeIteration(array $list) {
        if ($this->getProperty('addNone',false)) {
            $list[] = array('id' => 0, 'name' => $this->modx->lexicon('tagger.group.all'));
        }
        return $list;
    }

    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $query = $this->getProperty('query');

        if (!empty($query)) {
            $c->where(array(
                    'name:LIKE' => '%'.$query.'%'
            ));
        }
        return $c;
    }
}
return 'TaggerGroupGetListProcessor';
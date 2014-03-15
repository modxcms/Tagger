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
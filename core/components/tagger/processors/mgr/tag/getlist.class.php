<?php
/**
 * Get list Tags
 *
 * @package tagger
 * @subpackage processors
 */
class TaggerTagGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'TaggerTag';
    public $languageTopics = array('tagger:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'tagger.tag';

    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $query = $this->getProperty('query');

        if (!empty($query)) {
            $c->where(array(
                    'name:LIKE' => '%'.$query.'%'
            ));
        }

        $group = intval($this->getProperty('group'));

        if (!empty($group)) {
            $c->where(array(
                'group' => $group
            ));
        }

        return $c;
    }
}
return 'TaggerTagGetListProcessor';
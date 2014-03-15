<?php
/**
 * Get list Items
 *
 * @package tagger
 * @subpackage processors
 */
class TaggerItemGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'TaggerItem';
    public $languageTopics = array('tagger:default');
    public $defaultSortField = 'position';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'tagger.item';

    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $query = $this->getProperty('query');
        if (!empty($query)) {
            $c->where(array(
                    'name:LIKE' => '%'.$query.'%',
                    'OR:description:LIKE' => '%'.$query.'%',
                ));
        }
        return $c;
    }
}
return 'TaggerItemGetListProcessor';
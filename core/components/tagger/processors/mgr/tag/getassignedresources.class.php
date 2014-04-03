<?php
/**
 * Get list of Assigned Resources
 *
 * @package tagger
 * @subpackage processors
 */
class TaggerAssignedResourcesGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'modResource';
    public $languageTopics = array('tagger:default');
    public $defaultSortField = 'pagetitle';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'modResource';

    public function beforeQuery() {

        $tagId = (int) $this->getProperty('tagId');

        if (empty($tagId) || $tagId == 0) {
            return $this->modx->lexicon('tagger.err.tag_assigned_resources_tag_ns');
        }

        return parent::beforeQuery();
    }

    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $query = $this->getProperty('query');
        $tagId = $this->getProperty('tagId');

        $c->leftJoin('TaggerTagResource', 'TagResource', array('modResource.id = TagResource.resource'));
        $c->where(array(
            'TagResource.tag' => $tagId
        ));

        if (!empty($query)) {
            $c->where(array(
                    'pagetitle:LIKE' => '%'.$query.'%'
            ));
        }

        return $c;
    }

}
return 'TaggerAssignedResourcesGetListProcessor';
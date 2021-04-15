<?php

namespace Tagger\Processors\Tag;

use MODX\Revolution\modResource;
use MODX\Revolution\Processors\Model\GetListProcessor;
use Tagger\Model\TaggerTagResource;
use xPDO\Om\xPDOQuery;

/**
 * Get list of Assigned Resources
 *
 * @package tagger
 * @subpackage processors
 */
class GetAssignedResources extends GetListProcessor
{

    public $classKey = modResource::class;

    public $languageTopics = ['tagger:default'];

    public $defaultSortField = 'pagetitle';

    public $defaultSortDirection = 'ASC';

    public $objectType = 'modResource';

    public function beforeQuery()
    {
        $tagId = (int)$this->getProperty('tagId');

        if (empty($tagId) || $tagId == 0) {
            return $this->modx->lexicon('tagger.err.tag_assigned_resources_tag_ns');
        }

        return parent::beforeQuery();
    }

    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $query = $this->getProperty('query');
        $tagId = $this->getProperty('tagId');

        $c->leftJoin(TaggerTagResource::class, 'TagResource', ['modResource.id = TagResource.resource']);
        $c->where(
            [
                'TagResource.tag' => $tagId,
            ]
        );

        if (!empty($query)) {
            $c->where(
                [
                    'pagetitle:LIKE' => '%' . $query . '%',
                ]
            );
        }

        return $c;
    }

}

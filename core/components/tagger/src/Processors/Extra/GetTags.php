<?php

namespace Tagger\Processors\Extra;

use MODX\Revolution\Processors\Model\GetListProcessor;
use Tagger\Model\TaggerTag;

/**
 * Get list Tags
 *
 * @package tagger
 * @subpackage processors
 */
class GetTags extends GetListProcessor
{

    public $checkListPermission = true;


    public function process()
    {
        $group = $this->getProperty('group');
        $limit = $this->getProperty('limit', 20);
        $start = $this->getProperty('start', 0);
        $sortField = $this->getProperty('sort_field', 'alias');
        $sortDir = $this->getProperty('sort_dir', 'asc');

        $c = $this->modx->newQuery(TaggerTag::class);
        $c->where(['group' => $group]);

        $query = $this->getProperty('query');

        if (!empty($query)) {
            $c->where(
                [
                    'tag:LIKE' => '%' . $query . '%',
                ]
            );
        }

        $cnt = $this->modx->getCount(TaggerTag::class, $c);

        $c->select($this->modx->getSelectColumns(TaggerTag::class, 'TaggerTag', '', ['tag']));
        $c->limit($limit, $start);
        $c->sortby($sortField, $sortDir);

        $c->prepare();
        $c->stmt->execute();

        $returnArray = [];

        while ($tag = $c->stmt->fetch(\PDO::FETCH_ASSOC)) {
            $returnArray[] = ['tag' => $tag['tag']];
        }

        return $this->outputArray($returnArray, $cnt);
    }

}

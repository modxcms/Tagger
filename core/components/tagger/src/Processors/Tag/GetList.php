<?php

namespace Tagger\Processors\Tag;

use MODX\Revolution\Processors\Model\GetListProcessor;
use Tagger\Model\TaggerTag;
use xPDO\Om\xPDOQuery;

/**
 * Get list Tags
 *
 * @package tagger
 * @subpackage processors
 */
class GetList extends GetListProcessor
{

    public $classKey = TaggerTag::class;

    public $languageTopics = ['tagger:default'];

    public $defaultSortField = 'tag';

    public $defaultSortDirection = 'ASC';

    public $objectType = 'tagger.tag';

    public function initialize()
    {
        $initialized = parent::initialize();

        $this->setDefaultProperties(
            [
                'forTagfield' => false,
            ]
        );

        return $initialized;
    }

    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        $query = $this->getProperty('query');

        if (!empty($query)) {
            $c->where(
                [
                    'tag:LIKE' => '%' . $query . '%',
                ]
            );
        }

        $group = intval($this->getProperty('group'));

        if (!empty($group)) {
            $c->where(
                [
                    'group' => $group,
                ]
            );
        }

        return $c;
    }

    public function outputArray(array $array, $count = false)
    {
        if ($count === false) {
            $count = count($array);
        }

        $forTagfield = $this->getProperty('forTagfield', false);

        if ($forTagfield == true) {
            return '{"success": true, "total":"' . $count . '","results":' . $this->modx->toJSON($array) . '}';
        }

        return '{"success": true, "total":"' . $count . '","results":' . $this->modx->toJSON($array) . '}';
    }

}

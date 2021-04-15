<?php

namespace Tagger\Processors\Extra;

use MODX\Revolution\modTemplateVar;
use MODX\Revolution\Processors\Model\GetListProcessor;

/**
 * Get list of Template Variables
 *
 * @package tagger
 * @subpackage processors
 */
class GetTVs extends GetListProcessor
{

    public $classKey = modTemplateVar::class;

    public $languageTopics = ['tagger:default'];

    public $defaultSortField = 'name';

    public $defaultSortDirection = 'ASC';

    public $objectType = 'modTemplateVar';

}

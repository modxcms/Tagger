<?php
/**
 * Get list of Template Variables
 *
 * @package tagger
 * @subpackage processors
 */
class TaggerTVGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'modTemplateVar';
    public $languageTopics = array('tagger:default');
    public $defaultSortField = 'name';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'modTemplateVar';

}
return 'TaggerTVGetListProcessor';
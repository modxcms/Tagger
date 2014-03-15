<?php
/**
 * Remove a Group.
 * 
 * @package tagger
 * @subpackage processors
 */
class TaggerGroupRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'TaggerGroup';
    public $languageTopics = array('tagger:default');
    public $objectType = 'tagger.group';
}
return 'TaggerGroupRemoveProcessor';
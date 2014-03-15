<?php
/**
 * Remove a Tag.
 * 
 * @package tagger
 * @subpackage processors
 */
class TaggerTagRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'TaggerTag';
    public $languageTopics = array('tagger:default');
    public $objectType = 'tagger.tag';
}
return 'TaggerTagRemoveProcessor';
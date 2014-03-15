<?php
/**
 * Remove an Item.
 * 
 * @package tagger
 * @subpackage processors
 */
class TaggerItemRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'BxrExtraItem';
    public $languageTopics = array('tagger:default');
    public $objectType = 'tagger.item';
}
return 'TaggerItemRemoveProcessor';
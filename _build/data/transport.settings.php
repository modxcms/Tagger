<?php
/**
 * Loads system settings into build
 *
 * @package tagger
 * @subpackage build
 */
$settings = array();

$settings['tagger.tag_key'] = $modx->newObject('modSystemSetting');
$settings['tagger.tag_key']->set('key', 'tagger.tag_key');
$settings['tagger.tag_key']->fromArray(array(
    'value' => 'tags',
    'xtype' => 'textfield',
    'namespace' => 'tagger',
));

return $settings;
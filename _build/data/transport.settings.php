<?php
/**
 * Loads system settings into build
 *
 * @package tagger
 * @subpackage build
 */
$settings = array();

$settings['tagger.place_above_content_header'] = $modx->newObject('modSystemSetting');
$settings['tagger.place_above_content_header']->set('key', 'tagger.place_above_content_header');
$settings['tagger.place_above_content_header']->fromArray(array(
    'value' => 1,
    'xtype' => 'combo-boolean',
    'namespace' => 'tagger',
    'area' => 'places'
));

$settings['tagger.place_below_content_header'] = $modx->newObject('modSystemSetting');
$settings['tagger.place_below_content_header']->set('key', 'tagger.place_below_content_header');
$settings['tagger.place_below_content_header']->fromArray(array(
    'value' => 1,
    'xtype' => 'combo-boolean',
    'namespace' => 'tagger',
    'area' => 'places'
));

$settings['tagger.place_bottom_page_header'] = $modx->newObject('modSystemSetting');
$settings['tagger.place_bottom_page_header']->set('key', 'tagger.place_bottom_page_header');
$settings['tagger.place_bottom_page_header']->fromArray(array(
    'value' => 1,
    'xtype' => 'combo-boolean',
    'namespace' => 'tagger',
    'area' => 'places'
));

$settings['tagger.extend_classes'] = $modx->newObject('modSystemSetting');
$settings['tagger.extend_classes']->set('key', 'tagger.extend_classes');
$settings['tagger.extend_classes']->fromArray(array(
    'value' => '{"GridClassKey":["Container"],"miniShop2":["UpdateCategory","CreateCategory"]}',
    'xtype' => 'textfield',
    'namespace' => 'tagger',
    'area' => 'settings'
));

$settings['tagger.template_tab_name'] = $modx->newObject('modSystemSetting');
$settings['tagger.template_tab_name']->set('key', 'tagger.template_tab_name');
$settings['tagger.template_tab_name']->fromArray(array(
    'value' => '',
    'xtype' => 'textfield',
    'namespace' => 'tagger',
    'area' => 'settings'
));

return $settings;
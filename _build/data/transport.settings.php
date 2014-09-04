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

$settings['tagger.place_in_tab_label'] = $modx->newObject('modSystemSetting');
$settings['tagger.place_in_tab_label']->set('key', 'tagger.place_in_tab_label');
$settings['tagger.place_in_tab_label']->fromArray(array(
    'value' => 'tagger.tab.label',
    'xtype' => 'textfield',
    'namespace' => 'tagger',
    'area' => 'places'
));

$settings['tagger.place_tvs_tab_label'] = $modx->newObject('modSystemSetting');
$settings['tagger.place_tvs_tab_label']->set('key', 'tagger.place_tvs_tab_label');
$settings['tagger.place_tvs_tab_label']->fromArray(array(
    'value' => 'tagger.tab.label',
    'xtype' => 'textfield',
    'namespace' => 'tagger',
    'area' => 'places'
));

$settings['tagger.place_above_content_label'] = $modx->newObject('modSystemSetting');
$settings['tagger.place_above_content_label']->set('key', 'tagger.place_above_content_label');
$settings['tagger.place_above_content_label']->fromArray(array(
    'value' => 'tagger.tab.label',
    'xtype' => 'textfield',
    'namespace' => 'tagger',
    'area' => 'places'
));

$settings['tagger.place_below_content_label'] = $modx->newObject('modSystemSetting');
$settings['tagger.place_below_content_label']->set('key', 'tagger.place_below_content_label');
$settings['tagger.place_below_content_label']->fromArray(array(
    'value' => 'tagger.tab.label',
    'xtype' => 'textfield',
    'namespace' => 'tagger',
    'area' => 'places'
));

$settings['tagger.place_bottom_page_label'] = $modx->newObject('modSystemSetting');
$settings['tagger.place_bottom_page_label']->set('key', 'tagger.place_bottom_page_label');
$settings['tagger.place_bottom_page_label']->fromArray(array(
    'value' => 'tagger.tab.label',
    'xtype' => 'textfield',
    'namespace' => 'tagger',
    'area' => 'places'
));

return $settings;
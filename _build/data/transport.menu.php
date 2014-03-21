<?php
/**
 * Adds modActions and modMenus into package
 *
 * @package tagger
 * @subpackage build
 */

$menu = array();

$action = $modx->newObject('modAction');
$action->fromArray(array(
    'id' => 1,
    'namespace' => 'tagger',
    'parent' => 0,
    'controller' => 'index',
    'haslayout' => true,
    'lang_topics' => 'tagger:default',
    'assets' => '',
), '', true, true);

$menu[0]= $modx->newObject('modMenu');
$menu[0]->fromArray(array(
    'text' => 'tagger.menu.tagger',
    'parent' => 'components',
    'action' => 0,
    'description' => 'tagger.menu.tagger_desc',
    'icon' => '',
    'params' => '',
    'handler' => '',
    'permissions' => '',
), '', true, true);
$menu[0]->addOne($action);

return $menu;
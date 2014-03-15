<?php
/**
 * @package tagger
 */
$xpdo_meta_map['TaggerGroup']= array (
  'package' => 'tagger',
  'version' => NULL,
  'table' => 'tagger_groups',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'name' => NULL,
  ),
  'fieldMeta' => 
  array (
    'name' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
    ),
  ),
  'composites' => 
  array (
    'Tags' => 
    array (
      'class' => 'TaggerTag',
      'local' => 'id',
      'foreign' => 'group',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
);

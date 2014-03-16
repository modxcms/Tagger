<?php
/**
 * @package tagger
 */
$xpdo_meta_map['TaggerTag']= array (
  'package' => 'tagger',
  'version' => NULL,
  'table' => 'tagger_tags',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'tag' => NULL,
    'group' => NULL,
  ),
  'fieldMeta' => 
  array (
    'tag' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
    ),
    'group' => 
    array (
      'dbtype' => 'integer',
      'precision' => '10',
      'phptype' => 'int',
      'null' => false,
    ),
  ),
  'composites' => 
  array (
    'Resources' => 
    array (
      'class' => 'TaggerTagResource',
      'local' => 'id',
      'foreign' => 'tag',
      'cardinality' => 'many',
      'owner' => 'local',
    ),
  ),
  'aggregates' => 
  array (
    'Group' => 
    array (
      'class' => 'TaggerGroup',
      'local' => 'group',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);

<?php
/**
 * @package tagger
 */
$xpdo_meta_map['TaggerTagResource']= array (
  'package' => 'tagger',
  'version' => NULL,
  'table' => 'tagger_tag_resources',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'tag' => NULL,
    'resource' => NULL,
  ),
  'fieldMeta' => 
  array (
    'tag' => 
    array (
      'dbtype' => 'integer',
      'precision' => '10',
      'phptype' => 'int',
      'null' => false,
    ),
    'resource' => 
    array (
      'dbtype' => 'integer',
      'precision' => '10',
      'phptype' => 'int',
      'null' => false,
    ),
  ),
  'aggregates' => 
  array (
    'Tag' => 
    array (
      'class' => 'TaggerTag',
      'local' => 'tag',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
    'Resource' => 
    array (
      'class' => 'modResource',
      'local' => 'resource',
      'foreign' => 'id',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);

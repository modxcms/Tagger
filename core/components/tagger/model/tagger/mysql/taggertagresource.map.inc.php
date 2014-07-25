<?php
/**
 * @package tagger
 */
$xpdo_meta_map['TaggerTagResource']= array (
  'package' => 'tagger',
  'version' => '1.1',
  'table' => 'tagger_tag_resources',
  'extends' => 'xPDOObject',
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
      'attributes' => 'unsigned',
      'precision' => '10',
      'phptype' => 'int',
      'null' => false,
      'index' => 'pk',
    ),
    'resource' => 
    array (
      'dbtype' => 'integer',
      'attributes' => 'unsigned',
      'precision' => '10',
      'phptype' => 'int',
      'null' => false,
      'index' => 'pk',
    ),
  ),
  'indexes' => 
  array (
    'PRIMARY' => 
    array (
      'alias' => 'PRIMARY',
      'primary' => true,
      'unique' => true,
      'type' => 'BTREE',
      'columns' => 
      array (
        'tag' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
        'resource' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
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

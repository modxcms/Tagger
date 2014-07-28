<?php
/**
 * @package tagger
 */
$xpdo_meta_map['TaggerTag']= array (
  'package' => 'tagger',
  'version' => '1.1',
  'table' => 'tagger_tags',
  'extends' => 'xPDOSimpleObject',
  'fields' => 
  array (
    'tag' => NULL,
    'alias' => NULL,
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
    'alias' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
    ),
    'group' => 
    array (
      'dbtype' => 'integer',
      'attributes' => 'unsigned',
      'precision' => '10',
      'phptype' => 'int',
      'null' => false,
    ),
  ),
  'indexes' => 
  array (
    'iTagGroup' => 
    array (
      'alias' => 'iTagGroup',
      'primary' => false,
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
        'group' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'iTag' => 
    array (
      'alias' => 'iTag',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'tag' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'iAlias' => 
    array (
      'alias' => 'iAlias',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'alias' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
    ),
    'iGroup' => 
    array (
      'alias' => 'iGroup',
      'primary' => false,
      'unique' => false,
      'type' => 'BTREE',
      'columns' => 
      array (
        'group' => 
        array (
          'length' => '',
          'collation' => 'A',
          'null' => false,
        ),
      ),
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

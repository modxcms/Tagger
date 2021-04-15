<?php
namespace Tagger\Model\mysql;

use xPDO\xPDO;

class TaggerTag extends \Tagger\Model\TaggerTag
{

    public static $metaMap = array (
        'package' => 'Tagger\\Model\\',
        'version' => '3.0',
        'table' => 'tagger_tags',
        'tableMeta' => 
        array (
            'engine' => 'InnoDB',
        ),
        'fields' => 
        array (
            'tag' => NULL,
            'label' => '',
            'alias' => NULL,
            'group' => NULL,
            'rank' => 0,
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
            'label' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '100',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
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
            'rank' => 
            array (
                'dbtype' => 'integer',
                'attributes' => 'unsigned',
                'precision' => '10',
                'phptype' => 'int',
                'null' => false,
                'default' => 0,
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
                'class' => 'Tagger\\Model\\TaggerTagResource',
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
                'class' => 'Tagger\\Model\\TaggerGroup',
                'local' => 'group',
                'foreign' => 'id',
                'cardinality' => 'one',
                'owner' => 'foreign',
            ),
        ),
    );

}

<?php
namespace Tagger\Model\mysql;

use xPDO\xPDO;

class TaggerTagResource extends \Tagger\Model\TaggerTagResource
{

    public static $metaMap = array (
        'package' => 'Tagger\\Model\\',
        'version' => '3.0',
        'table' => 'tagger_tag_resources',
        'extends' => 'xPDO\\Om\\xPDOObject',
        'tableMeta' => 
        array (
            'engine' => 'InnoDB',
        ),
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
                'class' => 'Tagger\\Model\\TaggerTag',
                'local' => 'tag',
                'foreign' => 'id',
                'cardinality' => 'one',
                'owner' => 'foreign',
            ),
            'Resource' => 
            array (
                'class' => 'MODX\\Revolution\\modResource',
                'local' => 'resource',
                'foreign' => 'id',
                'cardinality' => 'one',
                'owner' => 'foreign',
            ),
        ),
    );

}

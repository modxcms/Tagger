<?php
namespace Tagger\Model\mysql;

use xPDO\xPDO;

class TaggerGroup extends \Tagger\Model\TaggerGroup
{

    public static $metaMap = array (
        'package' => 'Tagger\\Model\\',
        'version' => '3.0',
        'table' => 'tagger_groups',
        'tableMeta' => 
        array (
            'engine' => 'InnoDB',
        ),
        'fields' => 
        array (
            'name' => NULL,
            'alias' => NULL,
            'field_type' => NULL,
            'allow_new' => 0,
            'remove_unused' => 0,
            'allow_blank' => 0,
            'allow_type' => 0,
            'show_autotag' => 0,
            'hide_input' => 0,
            'tag_limit' => 0,
            'show_for_templates' => '',
            'place' => 'in-tab',
            'position' => 0,
            'description' => '',
            'in_tvs_position' => 9999,
            'as_radio' => 0,
            'sort_field' => 'alias',
            'sort_dir' => 'asc',
            'show_for_contexts' => '',
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
            'alias' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '100',
                'phptype' => 'string',
                'null' => false,
            ),
            'field_type' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '100',
                'phptype' => 'string',
                'null' => false,
            ),
            'allow_new' => 
            array (
                'dbtype' => 'tinyint',
                'attributes' => 'unsigned',
                'precision' => '1',
                'phptype' => 'boolean',
                'null' => false,
                'default' => 0,
            ),
            'remove_unused' => 
            array (
                'dbtype' => 'tinyint',
                'attributes' => 'unsigned',
                'precision' => '1',
                'phptype' => 'boolean',
                'null' => false,
                'default' => 0,
            ),
            'allow_blank' => 
            array (
                'dbtype' => 'tinyint',
                'attributes' => 'unsigned',
                'precision' => '1',
                'phptype' => 'boolean',
                'null' => false,
                'default' => 0,
            ),
            'allow_type' => 
            array (
                'dbtype' => 'tinyint',
                'attributes' => 'unsigned',
                'precision' => '1',
                'phptype' => 'boolean',
                'null' => false,
                'default' => 0,
            ),
            'show_autotag' => 
            array (
                'dbtype' => 'tinyint',
                'attributes' => 'unsigned',
                'precision' => '1',
                'phptype' => 'boolean',
                'null' => false,
                'default' => 0,
            ),
            'hide_input' => 
            array (
                'dbtype' => 'tinyint',
                'attributes' => 'unsigned',
                'precision' => '1',
                'phptype' => 'boolean',
                'null' => false,
                'default' => 0,
            ),
            'tag_limit' => 
            array (
                'dbtype' => 'int',
                'attributes' => 'unsigned',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => false,
                'default' => 0,
            ),
            'show_for_templates' => 
            array (
                'dbtype' => 'text',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ),
            'place' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '100',
                'phptype' => 'string',
                'null' => false,
                'default' => 'in-tab',
            ),
            'position' => 
            array (
                'dbtype' => 'int',
                'attributes' => 'unsigned',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => false,
                'default' => 0,
            ),
            'description' => 
            array (
                'dbtype' => 'text',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ),
            'in_tvs_position' => 
            array (
                'dbtype' => 'int',
                'attributes' => 'unsigned',
                'precision' => '10',
                'phptype' => 'integer',
                'null' => false,
                'default' => 9999,
            ),
            'as_radio' => 
            array (
                'dbtype' => 'tinyint',
                'attributes' => 'unsigned',
                'precision' => '1',
                'phptype' => 'boolean',
                'null' => false,
                'default' => 0,
            ),
            'sort_field' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '255',
                'phptype' => 'string',
                'null' => false,
                'default' => 'alias',
            ),
            'sort_dir' => 
            array (
                'dbtype' => 'varchar',
                'precision' => '255',
                'phptype' => 'string',
                'null' => false,
                'default' => 'asc',
            ),
            'show_for_contexts' => 
            array (
                'dbtype' => 'text',
                'phptype' => 'string',
                'null' => false,
                'default' => '',
            ),
        ),
        'composites' => 
        array (
            'Tags' => 
            array (
                'class' => 'Tagger\\Model\\TaggerTag',
                'local' => 'id',
                'foreign' => 'group',
                'cardinality' => 'many',
                'owner' => 'local',
            ),
        ),
    );

}

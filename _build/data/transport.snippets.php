<?php
/**
 * Loads snippets into build
 *
 * @package tagger
 * @subpackage build
 */

$snippets = array();

$snippets[0]= $modx->newObject('modSnippet');
$snippets[0]->fromArray(array(
    'id' => 0,
    'name' => 'TaggerGetTags',
    'description' => 'This Snippet allows you to list tags for resource(s), group(s) and all tags',
    'snippet' => getSnippetContent($sources['snippets'].'/taggergettags.snippet.php'),
),'',true,true);

$properties = array(
    array(
        'name' => 'resources',
        'desc' => 'tagger.gettags.resources_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'tagger:properties',
    ),
    array(
        'name' => 'groups',
        'desc' => 'tagger.gettags.groups_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'tagger:properties',
    ),
    array(
        'name' => 'rowTpl',
        'desc' => 'tagger.gettags.rowTpl_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'tagger:properties',
    ),
    array(
        'name' => 'outTpl',
        'desc' => 'tagger.gettags.outTpl_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'tagger:properties',
    ),
    array(
        'name' => 'separator',
        'desc' => 'tagger.gettags.separator_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'tagger:properties',
    ),
    array(
        'name' => 'target',
        'desc' => 'tagger.gettags.target_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'tagger:properties',
    ),
    array(
        'name' => 'showUnused',
        'desc' => 'tagger.gettags.showUnused_desc',
        'type' => 'numberfield',
        'options' => '',
        'value' => '0',
        'lexicon' => 'tagger:properties',
    ),
    array(
        'name' => 'showUnpublished',
        'desc' => 'tagger.gettags.showUnpublished_desc',
        'type' => 'numberfield',
        'options' => '',
        'value' => '0',
        'lexicon' => 'tagger:properties',
    ),
    array(
        'name' => 'showDeleted',
        'desc' => 'tagger.gettags.showDeleted_desc',
        'type' => 'numberfield',
        'options' => '',
        'value' => '0',
        'lexicon' => 'tagger:properties',
    ),
    array(
        'name' => 'contexts',
        'desc' => 'tagger.gettags.contexts_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'tagger:properties',
    ),
    array(
        'name' => 'toPlaceholder',
        'desc' => 'tagger.gettags.toPlaceholder_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'tagger:properties',
    ),
    array(
        'name' => 'limit',
        'desc' => 'tagger.gettags.limit_desc',
        'type' => 'numberfield',
        'options' => '',
        'value' => '0',
        'lexicon' => 'tagger:properties',
    ),
    array(
        'name' => 'offset',
        'desc' => 'tagger.gettags.offset_desc',
        'type' => 'numberfield',
        'options' => '',
        'value' => '0',
        'lexicon' => 'tagger:properties',
    ),
    array(
        'name' => 'totalPh',
        'desc' => 'tagger.gettags.totalPh_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => 'tags_total',
        'lexicon' => 'tagger:properties',
    ),

);
$snippets[0]->setProperties($properties);
unset($properties);

$snippets[1]= $modx->newObject('modSnippet');
$snippets[1]->fromArray(array(
    'id' => 1,
    'name' => 'TaggerGetResourcesWhere',
    'description' => 'This snippet generate SQL Query that can be used in WHERE condition in getResources snippet',
    'snippet' => getSnippetContent($sources['snippets'].'/taggergetresourceswhere.snippet.php'),
),'',true,true);

$properties = array(
    array(
        'name' => 'tags',
        'desc' => 'tagger.getresourceswhere.tags_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'tagger:properties',
    ),
    array(
        'name' => 'groups',
        'desc' => 'tagger.getresourceswhere.groups_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'tagger:properties',
    ),
    array(
        'name' => 'where',
        'desc' => 'tagger.getresourceswhere.where_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '',
        'lexicon' => 'tagger:properties',
    ),
    array(
        'name' => 'likeComparison',
        'desc' => 'tagger.getresourceswhere.likeComparison_desc',
        'type' => 'textfield',
        'options' => '',
        'value' => '0',
        'lexicon' => 'tagger:properties',
    ),

);
$snippets[1]->setProperties($properties);
unset($properties);

return $snippets;
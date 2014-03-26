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

//$properties = include $sources['data'].'properties.profiler.php';
//$snippets[0]->setProperties($properties);
//unset($properties);

$snippets[1]= $modx->newObject('modSnippet');
$snippets[1]->fromArray(array(
    'id' => 1,
    'name' => 'TaggerGetResources',
    'description' => 'This snippet allows you to list IDs of resources for specific tags',
    'snippet' => getSnippetContent($sources['snippets'].'/taggergetresources.snippet.php'),
),'',true,true);

//$properties = include $sources['data'].'properties.profiler.php';
//$snippets[0]->setProperties($properties);
//unset($properties);

return $snippets;
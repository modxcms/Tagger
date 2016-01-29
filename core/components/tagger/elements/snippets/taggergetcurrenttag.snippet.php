<?php
/**
 * TaggerGetCurrentTag
 *
 * DESCRIPTION
 *
 *
 * PROPERTIES:
 * 
 * &tagTpl          string  optional    Name of a chunk that will be used for each Tag. If no chunk is given, array with available placeholders will be rendered
 * &groupTpl        string  optional    Name of a chunk that will be used for each Tag. If no chunk is given, array with available placeholders will be rendered
 * &tagSeparator    string  optional    String separator, that will be used for separating Tags
 * &groupSeparator  string  optional    String separator, that will be used for separating Groups
 *
 * USAGE:
 *
 * [[!TaggerGetCurrentTag? &groupTpl=`currentGroup` &tagTpl=`@INLINE [[+tag]]` &tagSeparator=`, ` ]]
 *
 *
 * @package tagger
 */

/** @var Tagger $tagger */
$tagger = $modx->getService('tagger', 'Tagger', $modx->getOption('tagger.core_path', null, $modx->getOption('core_path') . 'components/tagger/') . 'model/tagger/', $scriptProperties);
if (!($tagger instanceof Tagger))
    return '';

$tagTpl = $modx->getOption('tagTpl', $scriptProperties, '');
$groupTpl = $modx->getOption('groupTpl', $scriptProperties, '');
$tagSeparator = $modx->getOption('tagSeparator', $scriptProperties, '');
$groupSeparator = $modx->getOption('groupSeparator', $scriptProperties, '');

$currentTags = $tagger->getCurrentTags();

$output = array();

foreach ($currentTags as $currentTag) {
    if (!isset($currentTag['tags'])) continue;

    $tags = array();
    foreach ($currentTag['tags'] as $tag) {
        $phs = array (
            'tag' => $tag['tag'],
            'alias' => $tag['alias'],
            'group_name' => $currentTag['group'],
            'group_alias' => $currentTag['alias'],
        );

        if (empty($tagTpl)) {
            $tags[] = '<pre>' . print_r($phs, true) . '</pre>';
        } else {
            $tags[] = $tagger->getChunk($tagTpl, $phs);
        }
    }
    
    $groupPhs = array(
        'name' => $currentTag['group'],
        'alias' => $currentTag['alias'],
        'multipleTags' => intval(count($tags) > 1),
        'tags' => implode($tagSeparator, $tags)
    );

    if (empty($groupTpl)) {
        $output[] = '<pre>' . print_r($groupPhs, true) . '</pre>';
    } else {
        $output[] = $tagger->getChunk($groupTpl, $groupPhs);
    }
}

return implode($groupSeparator, $output);

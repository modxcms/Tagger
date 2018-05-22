<?php
/**
 * TaggerGetCurrentTag
 *
 * DESCRIPTION
 *
 *
 * PROPERTIES:
 *
 * &tagTpl          string      optional    Name of a chunk that will be used for each Tag. If no chunk is given, array with available placeholders will be rendered
 * &groupTpl        string      optional    Name of a chunk that will be used for each Group. If no chunk is given, array with available placeholders will be rendered
 * &outTpl          string      optional    Name of a chunk that will be used for wrapping all groups. If no chunk is given, tags will be rendered without a wrapper
 * &tagSeparator    string      optional    String separator, that will be used for separating Tags
 * &groupSeparator  string      optional    String separator, that will be used for separating Groups
 * &target          int         optional    An ID of a resource that will be used for generating URI for a Tag. If no ID is given, current Resource ID will be used
 * &friendlyURL     int         optional    If set, will be used instead of friendly_urls system setting to generate URL
 * &linkTagScheme   int|string  optional    Strategy to generate URLs, available values: -1, 0, 1, full, abs, http, https; Default: link_tag_scheme system setting
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

$target = (int) $modx->getOption('target', $scriptProperties, $modx->resource->id, true);
$tagTpl = $modx->getOption('tagTpl', $scriptProperties, '');
$groupTpl = $modx->getOption('groupTpl', $scriptProperties, '');
$outTpl = $modx->getOption('outTpl', $scriptProperties, '');
$tagSeparator = $modx->getOption('tagSeparator', $scriptProperties, '');
$groupSeparator = $modx->getOption('groupSeparator', $scriptProperties, '');

$friendlyURL = (int) $modx->getOption('friendlyURL', $scriptProperties, $modx->getOption('friendly_urls', null, 0));
$linkTagScheme = $modx->getOption('linkTagScheme', $scriptProperties, $modx->getOption('link_tag_scheme', null, -1));

$currentTags = $tagger->getCurrentTags();
$currentTagsLink = array();

foreach($currentTags as $currentTag) {
    $currentTagsLink[$currentTag['alias']] = array_keys($currentTag['tags']);
}

$output = array();

foreach ($currentTags as $currentTag) {
    if (!isset($currentTag['tags'])) continue;

    $tags = array();

    foreach ($currentTag['tags'] as $tag) {
        $linkData = $currentTags;
        unset($linkData[$currentTag['alias']]['tags'][$tag['alias']]);
        if (count($linkData[$currentTag['alias']]['tags']) === 0) {
            unset($linkData[$currentTag['alias']]);    
        }

        if ($friendlyURL === 1) {
            $linkPath = array_reduce(array_keys($linkData), function($carry, $item) use ($linkData) {
                return $carry . $item . '/' . implode('/', array_unique(array_keys($linkData[$item]['tags']))) . '/';
            }, '');
    
            $uri = rtrim($modx->makeUrl($target, '', '', $linkTagScheme), '/') . '/' . $linkPath;
        } else {
            $args = [];
            foreach ($linkData as $group) {
                $args[$group['alias']] = implode(',', array_keys($group['tags']));  
            }

            $uri = $modx->makeUrl($target, '', $args, $linkTagScheme);
        }
        
        $phs = array (
            'tag' => $tag['tag'],
            'label' => $tag['label'],
            'alias' => $tag['alias'],
            'uri' => $uri,
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

if (!empty($outTpl) && !empty($output)) {
    return $tagger->getChunk($outTpl, array(
        'groups' => implode($groupSeparator, $output)
    ));
}

return implode($groupSeparator, $output);
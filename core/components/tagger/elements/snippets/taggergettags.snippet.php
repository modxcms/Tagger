<?php
/**
 * TaggerGetTags
 *
 * DESCRIPTION
 *
 * This Snippet allows you to list tags for resource(s), group(s) and all tags
 *
 * PROPERTIES:
 *
 * &resources   string  optional    Comma separated list of resources for which will be listed Tags
 * &groups      string  optional    Comma separated list of Tagger Groups for which will be listed Tags
 * &rowTpl      string  optional    Name of a chunk that will be used for each Tag. If no chunk is given, array with available placeholders will be rendered
 * &outTpl      string  optional    Name of a chunk that will be used for wrapping all tags. If no chunk is given, tags will be rendered without a wrapper
 * &separator   string  optional    String separator, that will be used for separating Tags
 * &target      int     optional    An ID of a resource that will be used for generating URI for a Tag. If no ID is given, current Resource ID will be used
 * &showUnused  int     optional    If 1 is set, Tags that are not assigned to any Resource will be included to the output as well
 *
 * USAGE:
 *
 * [[!TaggerGetTags? &showUnused=`1`]]
 *
 *
 * @package tagger
 */

$tagger = $modx->getService('tagger','Tagger',$modx->getOption('tagger.core_path',null,$modx->getOption('core_path').'components/tagger/').'model/tagger/',$scriptProperties);
if (!($tagger instanceof Tagger)) return '';

$resources = $modx->getOption('resources', $scriptProperties, '');
$groups = $modx->getOption('groups', $scriptProperties, '');
$target = (int) $modx->getOption('target', $scriptProperties, $modx->resource->id);
$showUnused = (int) $modx->getOption('showUnused', $scriptProperties, '0');

$rowTpl = $modx->getOption('rowTpl', $scriptProperties, '');
$outTpl = $modx->getOption('outTpl', $scriptProperties, '');
$separator = $modx->getOption('separator', $scriptProperties, '');

$resources = $tagger->explodeAndClean($resources);
$groups = $tagger->explodeAndClean($groups);

$c = $modx->newQuery('TaggerTag');

$c->select($modx->getSelectColumns('TaggerTag', 'TaggerTag'));
$c->select($modx->getSelectColumns('TaggerGroup', 'Group', 'group_'));

$c->leftJoin('TaggerTagResource', 'Resources');
$c->leftJoin('TaggerGroup', 'Group');

if ($resources) {
    $c->where(array(
        'Resources.resource:IN' => $resources
    ));
}

if ($groups) {
    $c->where(array(
        'Group.id' => $groups
    ));
}

$c->groupby('TaggerTag.id');
$c->prepare();
$tags = $modx->getIterator('TaggerTag', $c);

$out = [];

$friendlyURL = $modx->getOption('friendly_urls', null, 0);
$tagKey = $modx->getOption('tagger.tag_key', null, 'tags');

foreach ($tags as $tag) {
    $phs = $tag->toArray();
    $phs['cnt'] = $modx->getCount('TaggerTagResource', array('tag' => $tag->id));

    if (($showUnused == 0) && ($phs['cnt'] == 0)) {
        continue;
    }

    if ($friendlyURL == 1) {
        $uri = $modx->makeUrl($target, '', '') . '/' . $tagKey . '/' . $tag->tag;
        $uri = str_replace('//', '/', $uri);
    } else {
        $uri = $modx->makeUrl($target, '', 'tags=' . $tag->tag);
    }

    $phs['uri'] = $uri;

    if ($rowTpl == '') {
        $out[] = '<pre>' . print_r($phs, true) . '</pre>';
    } else {
        $out[] = $modx->getChunk($rowTpl, $phs);
    }
}

$out = implode($separator, $out);

if ($outTpl != '') {
    $out = $modx->getChunk($outTpl, ['tags' => $out]);
}

return $out;

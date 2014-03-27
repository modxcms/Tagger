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
 * &resources string optional
 * &groups string optional
 * &rowTpl string optional
 * &outTpl string optional
 * &separator string optional
 * &target int optional
 *
 * USAGE:
 *
 * [[!TaggerGetTags]]
 *
 *
 * @package tagger
 */

$tagger = $modx->getService('tagger','Tagger',$modx->getOption('tagger.core_path',null,$modx->getOption('core_path').'components/tagger/').'model/tagger/',$scriptProperties);
if (!($tagger instanceof Tagger)) return '';

$resources = $modx->getOption('resources', $scriptProperties, '');
$groups = $modx->getOption('groups', $scriptProperties, '');
$target = (int) $modx->getOption('target', $scriptProperties, $modx->resource->id);

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
    if ($friendlyURL == 1) {
        $uri = $modx->makeUrl($target, '', '') . '/' . $tagKey . '/' . $tag->tag;
        $uri = str_replace('//', '/', $uri);
    } else {
        $uri = $modx->makeUrl($target, '', 'tags=' . $tag->tag);
    }

    $phs = $tag->toArray();
    $phs['uri'] = $uri;
    $phs['cnt'] = $modx->getCount('TaggerTagResource', array('tag' => $tag->id));

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

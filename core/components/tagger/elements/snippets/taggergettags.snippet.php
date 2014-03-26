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
 *
 * USAGE:
 *
 * [[!TaggerGetTags? ]]
 *
 *
 * @package tagger
 */

$tagger = $modx->getService('tagger','Tagger',$modx->getOption('tagger.core_path',null,$modx->getOption('core_path').'components/tagger/').'model/tagger/',$scriptProperties);
if (!($tagger instanceof Tagger)) return '';

$resources = $modx->getOption('resources', $scriptProperties, '');
$groups = $modx->getOption('groups', $scriptProperties, '');

$rowTpl = $modx->getOption('rowTpl', $scriptProperties, '');
$outTpl = $modx->getOption('outTpl', $scriptProperties, '');
$separator = $modx->getOption('separator', $scriptProperties, '');

$resources = $tagger->explodeAndClean($resources);
$groups = $tagger->explodeAndClean($groups);

$c = $modx->newQuery('TaggerTag');

$c->select($modx->getSelectColumns('TaggerTag', 'TaggerTag'));
$c->select($modx->getSelectColumns('TaggerGroup', 'Group', 'group_'));
$c->select(array(
    'cnt' => 'count(TaggerTag.id)'
));

$c->leftJoin('TaggerTagResource', 'Resources');
$c->leftJoin('TaggerGroup', 'Group');

if ($resources) {
    $c->where(array(
        'Resource.resource:IN' => $resources
    ));
}

if ($groups) {
    $c->where(array(
        'Group.id' => $groups
    ));
}

$c->groupby('TaggerTag.id');

$tags = $modx->getIterator('TaggerTag', $c);

$out = [];

foreach ($tags as $tag) {
    if ($rowTpl == '') {
        $out[] = print_r($tag->toArray(), true);
    } else {
        $out[] = $modx->getChunk($rowTpl, $tag->toArray());
    }
}

$out = implode($separator, $out);

if ($outTpl != '') {
    $out = $modx->getChunk($outTpl, ['tags' => $out]);
}

return $out;

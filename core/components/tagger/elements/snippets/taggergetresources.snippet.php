<?php
/**
 * TaggerGetResources
 *
 * DESCRIPTION
 *
 * This snippet allows you to list IDs of resources for specific tags
 *
 * PROPERTIES:
 *
 * &prefix string optional
 * &suffix string optional
 * &separator string optional
 *
 * USAGE:
 *
 * [[!TaggerGetResources]]
 *
 */

$tagger = $modx->getService('tagger','Tagger',$modx->getOption('tagger.core_path',null,$modx->getOption('core_path').'components/tagger/').'model/tagger/',$scriptProperties);
if (!($tagger instanceof Tagger)) return '';

$prefix = $modx->getOption('prefix', $scriptProperties, '');
$suffix = $modx->getOption('suffix', $scriptProperties, '');
$separator = $modx->getOption('separator', $scriptProperties, ',');

$tags = $modx->getOption('tags', $scriptProperties, '');

$tags = $tagger->explodeAndClean($tags);

$c = $modx->newQuery('TaggerTag');
$c->select($modx->getSelectColumns('TaggerTag', 'TaggerTag', '', array('id')));
$c->where(array(
    'tag:IN' => $tags
));

$c->prepare();
$c->stmt->execute();

$tagIDs = $c->stmt->fetchAll(PDO::FETCH_COLUMN, 0);

$c = $modx->newQuery('TaggerTagResource');
$c->select($modx->getSelectColumns('TaggerTagResource', 'TaggerTagResource', '', array('resource')));
$c->where(array(
    'tag:IN' => $tagIDs
));

$c->prepare();
$c->stmt->execute();
$out = [];

while($resourceId = $c->stmt->fetch(PDO::FETCH_COLUMN, 0)) {
    $out[] = $prefix . $resourceId . $suffix;
}

$out = array_keys(array_flip($out));

return implode($separator, $out);

 
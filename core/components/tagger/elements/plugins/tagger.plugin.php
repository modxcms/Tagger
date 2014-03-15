<?php
/**
 * Tagger
 *
 * DESCRIPTION
 *
 * This plugin inject JS to add Tab with tag groups into Resource panel
 */

$corePath = $modx->getOption('tagger.core_path', null, $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/tagger/');
/** @var Tagger $tagger */
$tagger = $modx->getService(
    'tagger',
    'Tagger',
    $corePath . 'model/tagger/',
    array(
        'core_path' => $corePath
    )
);

$eventName = $modx->event->name;
switch($eventName) {
    case 'OnDocFormPrerender':
        $tagger->onDocFormPrerender();

        break;

    case 'OnDocFormSave':

        break;
}
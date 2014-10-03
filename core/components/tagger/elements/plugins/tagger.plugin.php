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
if (method_exists($tagger, $eventName)) {
    $eventName[0] = strtolower($eventName[0]);
    $tagger->$eventName($scriptProperties);
}

return;
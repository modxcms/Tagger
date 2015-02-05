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

$className = 'Tagger' . $modx->event->name;
$modx->loadClass('TaggerPlugin', $tagger->getOption('modelPath') . 'tagger/events/', true, true);
$modx->loadClass($className, $tagger->getOption('modelPath') . 'tagger/events/', true, true);

if (class_exists($className)) {
    /** @var TaggerPlugin $handler */
    $handler = new $className($modx, $scriptProperties);
    $handler->run();
}

return;
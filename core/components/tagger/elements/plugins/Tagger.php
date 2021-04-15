<?php
/**
 * Tagger
 *
 * DESCRIPTION
 *
 * This plugin inject JS to add Tab with tag groups into Resource panel
 */

$className = '\\Tagger\\Events\\' . $modx->event->name;

if (class_exists($className)) {
    /** @var \Tagger\Events\Event $handler */
    $handler = new $className($modx, $scriptProperties);
    $handler->run();
}

return;

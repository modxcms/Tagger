<?php
/**
 * Loads plugins into build
 *
 * @package tagger
 * @subpackage build
 */
$plugins = array();

/* create the plugin object */
$plugins[0] = $modx->newObject('modPlugin');
$plugins[0]->set('id',1);
$plugins[0]->set('name','Tagger');
$plugins[0]->set('description','This plugin inject Tagger tab into Resource panel and handles saving of tags.');
$plugins[0]->set('plugincode', getSnippetContent($sources['plugins'] . 'tagger.plugin.php'));
$plugins[0]->set('category', 0);

$events = array();

$e = array(
    'OnDocFormSave',
    'OnDocFormPrerender',
    'OnHandleRequest',
    'OnResourceDuplicate',
);

foreach ($e as $ev) {
    $events[$ev] = $modx->newObject('modPluginEvent');
    $events[$ev]->fromArray(array(
        'event' => $ev,
        'priority' => 0,
        'propertyset' => 0
    ),'',true,true);
}

if (is_array($events) && !empty($events)) {
    $plugins[0]->addMany($events);
    $modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in '.count($events).' Plugin Events for Tagger.'); flush();
} else {
    $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not find plugin events for Tagger!');
}
unset($events);

return $plugins;
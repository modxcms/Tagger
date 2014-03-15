<?php
/**
 * Tagger Connector
 *
 * @package tagger
 */
require_once dirname(dirname(dirname(dirname(__FILE__)))).'/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$corePath = $modx->getOption('tagger.core_path', null, $modx->getOption('core_path', null, MODX_CORE_PATH) . 'components/tagger/');
$tagger = $modx->getService(
    'tagger',
    'Tagger',
    $corePath . 'model/tagger/',
    array(
        'core_path' => $corePath
    )
);

/* handle request */
$modx->request->handleRequest(
    array(
        'processors_path' => $tagger->getOption('processorsPath', null, $corePath . 'processors/'),
        'location' => '',
    )
);
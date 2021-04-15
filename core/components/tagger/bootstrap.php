<?php
/**
 * @var \MODX\Revolution\modX $modx
 * @var array $namespace
 */

$modx->addPackage('Tagger\Model', $namespace['path'] . 'src/', null, 'Tagger\\');

$modx->services->add('tagger', function($c) use ($modx) {
    return new Tagger\Tagger($modx);
});

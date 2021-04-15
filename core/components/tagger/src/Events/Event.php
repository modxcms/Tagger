<?php
namespace Tagger\Events;

use MODX\Revolution\modX;
use Tagger\Tagger;

abstract class Event
{
    /** @var modX $modx */
    protected $modx;

    /** @var Tagger $tagger */
    protected $tagger;

    /** @var array $scriptProperties */
    protected $scriptProperties;

    public function __construct(modX $modx, &$scriptProperties) {
        $this->scriptProperties =& $scriptProperties;
        $this->modx = $modx;
        $this->tagger = $this->modx->services->get('tagger');
    }

    abstract public function run();
}

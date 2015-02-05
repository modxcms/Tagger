<?php
abstract class TaggerPlugin {
    /** @var modX $modx */
    protected $modx;
    /** @var Tagger $tagger */
    protected $tagger;
    /** @var array $scriptProperties */
    protected $scriptProperties;

    public function __construct($modx, &$scriptProperties) {
        $this->scriptProperties =& $scriptProperties;
        $this->modx = $modx;
        $this->tagger = $this->modx->tagger;
    }

    abstract public function run();
}
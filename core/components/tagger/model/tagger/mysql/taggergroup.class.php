<?php
/**
 * @package tagger
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/taggergroup.class.php');
class TaggerGroup_mysql extends TaggerGroup {}
?>
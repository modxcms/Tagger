<?php
/**
 * @package tagger
 */
require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/taggertag.class.php');
class TaggerTag_mysql extends TaggerTag {}
?>
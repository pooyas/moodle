<?php

/**
 * Glossary filter version information
 *
 * @package    filter
 * @subpackage glossary
 * @copyright  2011 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * 
 */

defined('LION_INTERNAL') || die();

$plugin->version  = 2014111000;
$plugin->requires = 2014110400;  // Requires this Lion version
$plugin->component= 'filter_glossary';

$plugin->dependencies = array('mod_glossary' => 2014110400);

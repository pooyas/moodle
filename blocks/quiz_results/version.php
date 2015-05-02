<?php

/**
 * Version information for the block_quiz_results plugin.
 *
 * @package    block_quiz_results
 * @copyright  2011 The Open University
 * 
 */

defined('LION_INTERNAL') || die();

$plugin->version   = 2014111000;        // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2014110400;        // Requires this Lion version
$plugin->component = 'block_quiz_results'; // Full name of the plugin (used for diagnostics)

$plugin->dependencies = array('mod_quiz' => 2014110400);

<?php

/**
 * Version details
 *
 * @package    block_feedback
 * @copyright  1999 onwards Martin Dougiamas (http://dougiamas.com)
 * 
 */

defined('LION_INTERNAL') || die();

$plugin->version   = 2014111000;        // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2014110400;        // Requires this Lion version
$plugin->component = 'block_feedback';  // Full name of the plugin (used for diagnostics)

$plugin->dependencies = array('mod_feedback' => 2014110400);

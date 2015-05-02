<?php

/**
 * Version details
 *
 * @package    gradeimport_direct
 * @copyright  2014 Adrian Greeve <adrian@lion.com>
 * 
 */

defined('LION_INTERNAL') || die();

$plugin->version   = 2014111000;        // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2014110400;        // Requires this Lion version
$plugin->component = 'gradeimport_direct'; // Full name of the plugin (used for diagnostics).
$plugin->dependencies = array('gradeimport_csv' => 2014110400); // Grade import csv is required for this plugin.
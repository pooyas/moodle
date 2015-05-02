<?php

/**
 * Feedback version information
 *
 * @package mod_feedback
 * @author     Andreas Grabs
 * 
 */

defined('LION_INTERNAL') || die();

$plugin->version   = 2014111000;       // The current module version (Date: YYYYMMDDXX)
$plugin->requires  = 2014110400;    // Requires this Lion version
$plugin->component = 'mod_feedback';   // Full name of the plugin (used for diagnostics)
$plugin->cron      = 0;

$feedback_version_intern = 1; //this version is used for restore older backups

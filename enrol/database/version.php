<?php

/**
 * Database enrolment plugin version specification.
 *
 * @package    enrol_database
 * @copyright  2010 Petr Skoda {@link http://skodak.org}
 * 
 */

defined('LION_INTERNAL') || die();

$plugin->version   = 2014111000;        // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2014110400;        // Requires this Lion version
$plugin->component = 'enrol_database';  // Full name of the plugin (used for diagnostics)
//TODO: should we add cron sync?

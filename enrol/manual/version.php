<?php

/**
 * Manual enrolment plugin version specification.
 *
 * @package    enrol_manual
 * @copyright  2010 Petr Skoda {@link http://skodak.org}
 * 
 */

defined('LION_INTERNAL') || die();

$plugin->version   = 2015021200;        // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2014110400;        // Requires this Lion version
$plugin->component = 'enrol_manual';    // Full name of the plugin (used for diagnostics)
$plugin->cron      = 600;

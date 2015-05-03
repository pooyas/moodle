<?php

/**
 * Version details
 *
 * @package    block_recent_activity
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$plugin->version   = 2014111000;        // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2014110400;        // Requires this Lion version
$plugin->component = 'block_recent_activity'; // Full name of the plugin (used for diagnostics)
$plugin->cron      = 24*3600;           // Cron interval 1 day.
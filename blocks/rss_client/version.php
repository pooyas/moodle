<?php


/**
 * Version details
 *
 * @package    blocks
 * @subpackage rss_client
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$plugin->version   = 2014111000;        // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2014110400;        // Requires this Lion version
$plugin->component = 'block_rss_client'; // Full name of the plugin (used for diagnostics)
$plugin->cron      = 300;               // Set min time between cron executions to 300 secs (5 mins)

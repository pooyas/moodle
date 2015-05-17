<?php


/**
 * Code fragment to define the version of wiki
 * This fragment is called by lion_needs_upgrading() and /admin/index.php
 *
 *
 *
 * @package    mod
 * @subpackage wiki
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$plugin->version   = 2014111000;       // The current module version (Date: YYYYMMDDXX)
$plugin->requires  = 2014110400;    // Requires this Lion version
$plugin->component = 'mod_wiki';       // Full name of the plugin (used for diagnostics)
$plugin->cron      = 0;

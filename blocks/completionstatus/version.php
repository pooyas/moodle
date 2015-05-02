<?php

/**
 * Version info
 *
 * @package    block_completionstatus
 * @copyright  2009 Catalyst IT Ltd
 * @author     Aaron Barnes <aaronb@catalyst.net.nz>
 * 
 */

defined('LION_INTERNAL') || die();

$plugin->version      = 2014111000; // The current plugin version (Date: YYYYMMDDXX).
$plugin->requires     = 2014110400; // Requires this Lion version.
$plugin->component    = 'block_completionstatus';
$plugin->dependencies = array('report_completion' => 2014110400);

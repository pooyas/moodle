<?php



/**
 * Defines the version of workshop accumulative grading strategy subplugin
 *
 * This code fragment is called by lion_needs_upgrading() and
 * /admin/index.php
 *
 * @package    mod
 * @subpackage workshop
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$plugin->version  = 2014111000;
$plugin->requires = 2014110400;  // Requires this Lion version
$plugin->component = 'workshopform_accumulative';

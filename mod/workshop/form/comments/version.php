<?php


/**
 * Defines the version of workshop comments grading strategy subplugin
 *
 * This code fragment is called by lion_needs_upgrading() and
 * /admin/index.php
 *
 * @package    workshopform_comments
 * @copyright  2009 David Mudrak <david.mudrak@gmail.com>
 * 
 */

defined('LION_INTERNAL') || die();

$plugin->version  = 2014111000;
$plugin->requires = 2014110400;  // Requires this Lion version
$plugin->component = 'workshopform_comments';

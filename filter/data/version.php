<?php

/**
 * Data activity filter version information
 *
 * @package    filter
 * @subpackage data
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$plugin->version  = 2014111000;
$plugin->requires = 2014110400;  // Requires this Lion version
$plugin->component= 'filter_data';

$plugin->dependencies = array('mod_data' => 2014110400);

<?php

/**
 * Allows the admin to manage assignment plugins
 *
 * @package    mod
 * @subpackage assign
 * @copyright 2015 Pooya Saeedi 
 * 
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot.'/mod/assign/adminlib.php');

// Create the class for this controller.
$pluginmanager = new assign_plugin_manager(required_param('subtype', PARAM_PLUGIN));

$PAGE->set_context(context_system::instance());

// Execute the controller.
$pluginmanager->execute(optional_param('action', null, PARAM_PLUGIN),
                        optional_param('plugin', null, PARAM_PLUGIN));

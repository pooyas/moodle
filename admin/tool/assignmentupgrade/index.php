<?php

/**
 * This tool can upgrade old assignment activities to the new assignment activity type
 *
 * The upgrade can be done on any old assignment instance providing it is using one of the core
 * assignment subtypes (online text, single upload, etc).
 * The new assignment module was introduced in Lion 2.3 and although it completely reproduces
 * the features of the existing assignment type it wasn't designed to replace it entirely as there
 * are many custom assignment types people use and it wouldn't be practical to try to convert them.
 * Instead the existing assignment type will be left in core and people will be encouraged to
 * use the new assignment type.
 *
 * This screen is the main entry-point to the plugin, it gives the admin a list
 * of options available to them.
 *
 * @package    tool
 * @subpackage assignmentupgrade
 * @copyright  2015 Pooya Saeedi
 * 
 */

require_once(dirname(__FILE__) . '/../../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/'.$CFG->admin.'/tool/assignmentupgrade/locallib.php');

// This calls require_login and checks lion/site:config.
admin_externalpage_setup('assignmentupgrade');

$renderer = $PAGE->get_renderer('tool_assignmentupgrade');

$actions = array();

$header = get_string('pluginname', 'tool_assignmentupgrade');
$actions[] = tool_assignmentupgrade_action::make('listnotupgraded');

echo $renderer->index_page($header, $actions);

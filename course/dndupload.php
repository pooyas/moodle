<?php

/**
 * Starting point for drag and drop course uploads
 *
 * @package    core
 * @subpackage lib
 * @copyright  2012 Davo smith
 * 
 */

define('AJAX_SCRIPT', true);

require_once(dirname(dirname(__FILE__)).'/config.php');
require_once($CFG->dirroot.'/course/dnduploadlib.php');

$courseid = required_param('course', PARAM_INT);
$section = required_param('section', PARAM_INT);
$type = required_param('type', PARAM_TEXT);
$modulename = required_param('module', PARAM_PLUGIN);
$displayname = optional_param('displayname', null, PARAM_TEXT);
$contents = optional_param('contents', null, PARAM_RAW); // It will be up to each plugin to clean this data, before saving it.

$PAGE->set_url('/course/dndupload.php');

$dndproc = new dndupload_ajax_processor($courseid, $section, $type, $modulename);
$dndproc->process($displayname, $contents);

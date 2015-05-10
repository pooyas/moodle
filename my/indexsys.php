<?php


/**
 * My Lion -- a user's personal dashboard
 *
 * - each user can currently have their own page (cloned from system and then customised)
 * - only the user can see their own dashboard
 * - users can add any blocks they want
 * - the administrators can define a default site dashboard for users who have
 *   not created their own dashboard
 *
 * This script implements the user's view of the dashboard, and allows editing
 * of the dashboard.
 *
 * @package    core
 * @subpackage my
 * @copyright  2015 Pooya Saeedi
 */

require_once(dirname(__FILE__) . '/../config.php');
require_once($CFG->dirroot . '/my/lib.php');
require_once($CFG->libdir.'/adminlib.php');

$edit   = optional_param('edit', null, PARAM_BOOL);    // Turn editing on and off

require_login();

$header = "$SITE->shortname: ".get_string('myhome')." (".get_string('mypage', 'admin').")";

$PAGE->set_blocks_editing_capability('lion/my:configsyspages');
admin_externalpage_setup('mypage', '', null, '', array('pagelayout' => 'mydashboard'));

// Override pagetype to show blocks properly.
$PAGE->set_pagetype('my-index');

$PAGE->set_title($header);
$PAGE->set_heading($header);
$PAGE->blocks->add_region('content');

// Get the My Lion page info.  Should always return something unless the database is broken.
if (!$currentpage = my_get_page(null, MY_PAGE_PRIVATE)) {
    print_error('mylionsetup');
}
$PAGE->set_subpage($currentpage->id);

echo $OUTPUT->header();

echo $OUTPUT->custom_block_region('content');

echo $OUTPUT->footer();

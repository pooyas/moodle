<?php


/**
 * System Public Profile.
 *
 * This script allows the site administrator to edit the default site
 * profile.
 *
 * @package    core
 * @subpackage user
 * @copyright  2015 Pooya Saeedi
 */

require_once(dirname(__FILE__) . '/../config.php');
require_once($CFG->dirroot . '/my/lib.php');
require_once($CFG->libdir.'/adminlib.php');

$edit   = optional_param('edit', null, PARAM_BOOL);    // Turn editing on and off.

require_login();

$header = "$SITE->shortname: ".get_string('publicprofile')." (".get_string('myprofile', 'admin').")";

$PAGE->set_blocks_editing_capability('lion/my:configsyspages');
admin_externalpage_setup('profilepage', '', null, '', array('pagelayout' => 'mypublic'));

// Override pagetype to show blocks properly.
$PAGE->set_pagetype('user-profile');

$PAGE->set_title($header);
$PAGE->set_heading($header);
$PAGE->blocks->add_region('content');

// Get the Public Profile page info.  Should always return something unless the database is broken.
if (!$currentpage = my_get_page(null, MY_PAGE_PUBLIC)) {
    print_error('publicprofilesetup');
}
$PAGE->set_subpage($currentpage->id);


echo $OUTPUT->header();

echo $OUTPUT->custom_block_region('content');

echo $OUTPUT->footer();

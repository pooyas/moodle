<?php

/**
 * This script triggers a full purging of system caches,
 * this is useful mostly for developers who did not disable the caching.
 *
 * @package    core
 * @copyright  2010 Petr Skoda {@link http://skodak.org}
 * 
 */

require_once('../config.php');
require_once($CFG->libdir.'/adminlib.php');

$confirm = optional_param('confirm', 0, PARAM_BOOL);
$returnurl = optional_param('returnurl', null, PARAM_LOCALURL);

// If we have got here as a confirmed aciton, do it.
if ($confirm && isloggedin() && confirm_sesskey()) {
    require_capability('lion/site:config', context_system::instance());

    // Valid request. Purge, and redirect the user back to where they came from.
    purge_all_caches();

    if ($returnurl) {
        $returnurl = $CFG->wwwroot . $returnurl;
    } else {
        $returnurl = new lion_url('/admin/purgecaches.php');
    }
    redirect($returnurl, get_string('purgecachesfinished', 'admin'));
}

// Otherwise, show a button to actually purge the caches.
admin_externalpage_setup('purgecaches');

$actionurl = new lion_url('/admin/purgecaches.php', array('sesskey'=>sesskey(), 'confirm'=>1));
if ($returnurl) {
    $actionurl->param('returnurl', $returnurl);
}

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('purgecaches', 'admin'));

echo $OUTPUT->box_start('generalbox', 'notice');
echo html_writer::tag('p', get_string('purgecachesconfirm', 'admin'));
echo $OUTPUT->single_button($actionurl, get_string('purgecaches', 'admin'), 'post');
echo $OUTPUT->box_end();

echo $OUTPUT->footer();

<?php

/**
 * First step page for creating a new badge
 *
 * @package    core
 * @subpackage badges
 * @copyright  2015 Pooya Saeedi
 * 
 * @author     Yuliya Bozhko <yuliya.bozhko@totaralms.com>
 */

require_once(dirname(dirname(__FILE__)) . '/config.php');
require_once($CFG->libdir . '/badgeslib.php');
require_once($CFG->dirroot . '/badges/edit_form.php');

$type = required_param('type', PARAM_INT);
$courseid = optional_param('id', 0, PARAM_INT);

require_login();

if (empty($CFG->enablebadges)) {
    print_error('badgesdisabled', 'badges');
}

if (empty($CFG->badges_allowcoursebadges) && ($type == BADGE_TYPE_COURSE)) {
    print_error('coursebadgesdisabled', 'badges');
}

$title = get_string('create', 'badges');

if (($type == BADGE_TYPE_COURSE) && ($course = $DB->get_record('course', array('id' => $courseid)))) {
    require_login($course);
    $coursecontext = context_course::instance($course->id);
    $PAGE->set_context($coursecontext);
    $PAGE->set_pagelayout('incourse');
    $PAGE->set_url('/badges/newbadge.php', array('type' => $type, 'id' => $course->id));
    $heading = format_string($course->fullname, true, array('context' => $coursecontext)) . ": " . $title;
    $PAGE->set_heading($heading);
    $PAGE->set_title($heading);
} else {
    $PAGE->set_context(context_system::instance());
    $PAGE->set_pagelayout('admin');
    $PAGE->set_url('/badges/newbadge.php', array('type' => $type));
    $PAGE->set_heading($title);
    $PAGE->set_title($title);
}

require_capability('lion/badges:createbadge', $PAGE->context);

$PAGE->requires->js('/badges/backpack.js');
$PAGE->requires->js_init_call('check_site_access', null, false);

$fordb = new stdClass();
$fordb->id = null;

$form = new edit_details_form($PAGE->url, array('action' => 'new'));

if ($form->is_cancelled()) {
    redirect(new lion_url('/badges/index.php', array('type' => $type, 'id' => $courseid)));
} else if ($data = $form->get_data()) {
    // Creating new badge here.
    $now = time();

    $fordb->name = $data->name;
    $fordb->description = $data->description;
    $fordb->timecreated = $now;
    $fordb->timemodified = $now;
    $fordb->usercreated = $USER->id;
    $fordb->usermodified = $USER->id;
    $fordb->issuername = $data->issuername;
    $fordb->issuerurl = $data->issuerurl;
    $fordb->issuercontact = $data->issuercontact;
    $fordb->expiredate = ($data->expiry == 1) ? $data->expiredate : null;
    $fordb->expireperiod = ($data->expiry == 2) ? $data->expireperiod : null;
    $fordb->type = $type;
    $fordb->courseid = ($type == BADGE_TYPE_COURSE) ? $courseid : null;
    $fordb->messagesubject = get_string('messagesubject', 'badges');
    $fordb->message = get_string('messagebody', 'badges',
            html_writer::link($CFG->wwwroot . '/badges/mybadges.php', get_string('mybadges', 'badges')));
    $fordb->attachment = 1;
    $fordb->notification = BADGE_MESSAGE_NEVER;
    $fordb->status = BADGE_STATUS_INACTIVE;

    $newid = $DB->insert_record('badge', $fordb, true);

    $newbadge = new badge($newid);
    badges_process_badge_image($newbadge, $form->save_temp_file('image'));
    // If a user can configure badge criteria, they will be redirected to the criteria page.
    if (has_capability('lion/badges:configurecriteria', $PAGE->context)) {
        redirect(new lion_url('/badges/criteria.php', array('id' => $newid)));
    }
    redirect(new lion_url('/badges/overview.php', array('id' => $newid)));
}

echo $OUTPUT->header();
echo $OUTPUT->box('', 'notifyproblem hide', 'check_connection');

$form->display();

echo $OUTPUT->footer();
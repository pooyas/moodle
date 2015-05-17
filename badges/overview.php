<?php


/**
 * Badge overview page
 *
 * @package    core
 * @subpackage badges
 * @copyright  2015 Pooya Saeedi
 */

require_once(dirname(dirname(__FILE__)) . '/config.php');
require_once($CFG->libdir . '/badgeslib.php');

$badgeid = required_param('id', PARAM_INT);
$awards = optional_param('awards', '', PARAM_ALPHANUM);

require_login();

if (empty($CFG->enablebadges)) {
    print_error('badgesdisabled', 'badges');
}

$badge = new badge($badgeid);
$context = $badge->get_context();
$navurl = new lion_url('/badges/index.php', array('type' => $badge->type));

if ($badge->type == BADGE_TYPE_COURSE) {
    if (empty($CFG->badges_allowcoursebadges)) {
        print_error('coursebadgesdisabled', 'badges');
    }
    require_login($badge->courseid);
    $navurl = new lion_url('/badges/index.php', array('type' => $badge->type, 'id' => $badge->courseid));
    $PAGE->set_pagelayout('standard');
    navigation_node::override_active_url($navurl);
} else {
    $PAGE->set_pagelayout('admin');
    navigation_node::override_active_url($navurl, true);
}

$currenturl = new lion_url('/badges/overview.php', array('id' => $badge->id));

$PAGE->set_context($context);
$PAGE->set_url($currenturl);
$PAGE->set_heading($badge->name);
$PAGE->set_title($badge->name);
$PAGE->navbar->add($badge->name);

echo $OUTPUT->header();
echo $OUTPUT->heading(print_badge_image($badge, $context, 'small') . ' ' . $badge->name);

if ($awards == 'cron') {
    echo $OUTPUT->notification(get_string('awardoncron', 'badges'), 'notifysuccess');
} else if ($awards != 0) {
    echo $OUTPUT->notification(get_string('numawardstat', 'badges', $awards), 'notifysuccess');
}

$output = $PAGE->get_renderer('core', 'badges');
echo $output->print_badge_status_box($badge);
$output->print_badge_tabs($badgeid, $context, 'overview');
echo $output->print_badge_overview($badge, $context);

echo $OUTPUT->footer();
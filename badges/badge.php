<?php


/**
 * Display details of an issued badge with criteria and evidence
 *
 * @package    core
 * @subpackage badges
 * @copyright  2015 Pooya Saeedi
 */

require_once(dirname(dirname(__FILE__)) . '/config.php');
require_once($CFG->libdir . '/badgeslib.php');
require_once($CFG->libdir . '/filelib.php');

$id = required_param('hash', PARAM_ALPHANUM);
$bake = optional_param('bake', 0, PARAM_BOOL);

$PAGE->set_context(context_system::instance());
$output = $PAGE->get_renderer('core', 'badges');

$badge = new issued_badge($id);

if ($bake && ($badge->recipient->id == $USER->id)) {
    $name = str_replace(' ', '_', $badge->badgeclass['name']) . '.png';
    $filehash = badges_bake($id, $badge->badgeid, $USER->id, true);
    $fs = get_file_storage();
    $file = $fs->get_file_by_hash($filehash);
    send_stored_file($file, 0, 0, true, array('filename' => $name));
}

$PAGE->set_url('/badges/badge.php', array('hash' => $id));
$PAGE->set_pagelayout('base');
$PAGE->set_title(get_string('issuedbadge', 'badges'));

if (isloggedin()) {
    $PAGE->set_heading($badge->badgeclass['name']);
    $PAGE->navbar->add($badge->badgeclass['name']);
    if ($badge->recipient->id == $USER->id) {
        $url = new lion_url('/badges/mybadges.php');
    } else {
        $url = new lion_url($CFG->wwwroot);
    }
    navigation_node::override_active_url($url);
} else {
    $PAGE->set_heading($badge->badgeclass['name']);
    $PAGE->navbar->add($badge->badgeclass['name']);
    $url = new lion_url($CFG->wwwroot);
    navigation_node::override_active_url($url);
}

// Include JS files for backpack support.
badges_setup_backpack_js();

echo $OUTPUT->header();

echo $output->render($badge);

echo $OUTPUT->footer();

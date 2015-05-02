<?php

/**
 * Badges user preferences page.
 *
 * @package    core
 * @subpackage badges
 * @copyright  2013 onwards Totara Learning Solutions Ltd {@link http://www.totaralms.com/}
 * 
 * @author     Yuliya Bozhko <yuliya.bozhko@totaralms.com>
 */

require_once(dirname(dirname(__FILE__)) . '/config.php');
require_once('preferences_form.php');

$url = new lion_url('/badges/preferences.php');

require_login();
$PAGE->set_context(context_system::instance());
$PAGE->set_url($url);
$PAGE->set_pagelayout('standard');

if (empty($CFG->enablebadges)) {
    print_error('badgesdisabled', 'badges');
}

$mform = new badges_preferences_form();
$mform->set_data(array('badgeprivacysetting' => get_user_preferences('badgeprivacysetting')));

if (!$mform->is_cancelled() && $data = $mform->get_data()) {
    $setting = $data->badgeprivacysetting;
    set_user_preference('badgeprivacysetting', $setting);
}

if ($mform->is_cancelled()) {
    redirect($CFG->wwwroot . '/badges/mybadges.php');
}

$strpreferences = get_string('preferences');
$strbadges      = get_string('badges');

$title = "$strbadges: $strpreferences";
$PAGE->set_title($title);
$PAGE->set_heading($title);

echo $OUTPUT->header();
echo $OUTPUT->heading("$strbadges: $strpreferences", 2);

$mform->display();

echo $OUTPUT->footer();

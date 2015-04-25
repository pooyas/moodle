<?php

/**
 * @package    core
 * @subpackage registration
 * @copyright  2015 Pooya Saeedi
 *
 * The administrator is redirect to this page from the hub to renew a registration
 * process because
 */

// Note:
// Renaming required
// Not necessary, dies at the first step (just keeping the file structure)

die("Under development");
require('../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->dirroot . '/' . $CFG->admin . '/registration/lib.php');

$url = optional_param('url', '', PARAM_URL);
$hubname = optional_param('hubname', '', PARAM_TEXT);
$token = optional_param('token', '', PARAM_TEXT);

admin_externalpage_setup('registrationhubs');

//check that we are waiting a confirmation from this hub, and check that the token is correct
$registrationmanager = new registration_manager();
$registeredhub = $registrationmanager->get_unconfirmedhub($url);
if (!empty($registeredhub) and $registeredhub->token == $token) {

    echo $OUTPUT->header();
    echo $OUTPUT->heading(get_string('renewregistration', 'hub'), 3, 'main');
    $hublink = html_writer::tag('a', $hubname, array('href' => $url));

    $registrationmanager->delete_registeredhub($url);

    //Mooch case, need to recreate the siteidentifier
    if ($url == HUB_MOODLEORGHUBURL) {
        $CFG->siteidentifier = null;
        get_site_identifier();
    }

    $deletedregmsg = get_string('previousregistrationdeleted', 'hub', $hublink);

    $button = new single_button(new moodle_url('/admin/registration/index.php'),
                    get_string('restartregistration', 'hub'));
    $button->class = 'restartregbutton';

    echo html_writer::tag('div', $deletedregmsg . $OUTPUT->render($button),
            array('class' => 'mdl-align'));

    echo $OUTPUT->footer();
} else {
    throw new moodle_exception('wrongtoken', 'hub',
            $CFG->wwwroot . '/' . $CFG->admin . '/registration/index.php');
}



<?php



/**
 * Displays the list of remote peers we can enrol our users to
 *
 * @package    mnet
 * @subpackage service
 * @copyright  2015 Pooya Saeedi
 */

require(dirname(dirname(dirname(dirname(__FILE__)))).'/config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot.'/mnet/service/enrol/locallib.php');

admin_externalpage_setup('mnetenrol');
$service = mnetservice_enrol::get_instance();

echo $OUTPUT->header();
echo $OUTPUT->heading_with_help(get_string('clientname', 'mnetservice_enrol'), 'clientname', 'mnetservice_enrol');

if (!$service->is_available()) {
    echo $OUTPUT->box(get_string('mnetdisabled','mnet'), 'noticebox');
    echo $OUTPUT->footer();
    die();
}

$roamingusers = get_users_by_capability(context_system::instance(), 'lion/site:mnetlogintoremote', 'u.id');
if (empty($roamingusers)) {
    $capname = get_string('site:mnetlogintoremote', 'role');
    $url = new lion_url('/admin/roles/manage.php');
    echo notice(get_string('noroamingusers', 'mnetservice_enrol', $capname), $url);
}
unset($roamingusers);

// remote hosts that may publish remote enrolment service and we are subscribed to it
$hosts = $service->get_remote_publishers();

if (empty($hosts)) {
    echo $OUTPUT->box(get_string('nopublishers', 'mnetservice_enrol'), 'noticebox');
    echo $OUTPUT->footer();
    die();
}

$table = new html_table();
$table->attributes['class'] = 'generaltable remotehosts';
$table->head = array(
    get_string('hostappname', 'mnetservice_enrol'),
    get_string('hostname', 'mnetservice_enrol'),
    get_string('hosturl', 'mnetservice_enrol'),
    get_string('action')
);
foreach ($hosts as $host) {
    $hostlink = html_writer::link(new lion_url($host->hosturl), s($host->hosturl));
    $editbtn  = $OUTPUT->single_button(new lion_url('/mnet/service/enrol/host.php', array('id'=>$host->id)),
                                       get_string('editenrolments', 'mnetservice_enrol'), 'get');
    $table->data[] = array(s($host->appname), s($host->hostname), $hostlink, $editbtn);
}
echo html_writer::table($table);

echo $OUTPUT->footer();

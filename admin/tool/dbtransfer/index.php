<?php


/**
 * Transfer tool
 *
 * @package    admin_tool
 * @subpackage dbtransfer
 * @copyright  2015 Pooya Saeedi
 */

define('NO_OUTPUT_BUFFERING', true);

require('../../../config.php');
require_once('locallib.php');
require_once('database_transfer_form.php');

require_login();
admin_externalpage_setup('tooldbtransfer');

// Create the form.
$form = new database_transfer_form();
$problem = '';

// If we have valid input.
if ($data = $form->get_data()) {
    // Connect to the other database.
    list($dbtype, $dblibrary) = explode('/', $data->driver);
    $targetdb = lion_database::get_driver_instance($dbtype, $dblibrary);
    $dboptions = array();
    if ($data->dbport) {
        $dboptions['dbport'] = $data->dbport;
    }
    if ($data->dbsocket) {
        $dboptions['dbsocket'] = $data->dbsocket;
    }
    try {
        $targetdb->connect($data->dbhost, $data->dbuser, $data->dbpass, $data->dbname, $data->prefix, $dboptions);
        if ($targetdb->get_tables()) {
            $problem .= get_string('targetdatabasenotempty', 'tool_dbtransfer');
        }
    } catch (lion_exception $e) {
        $problem .= get_string('notargetconectexception', 'tool_dbtransfer').'<br />'.$e->debuginfo;
    }

    if ($problem === '') {
        // Scroll down to the bottom when finished.
        $PAGE->requires->js_init_code("window.scrollTo(0, 5000000);");

        // Enable CLI maintenance mode if requested.
        if ($data->enablemaintenance) {
            $PAGE->set_pagelayout('maintenance');
            tool_dbtransfer_create_maintenance_file();
        }

        // Start output.
        echo $OUTPUT->header();
        $data->dbtype = $dbtype;
        $data->dbtypefrom = $CFG->dbtype;
        echo $OUTPUT->heading(get_string('transferringdbto', 'tool_dbtransfer', $data));

        // Do the transfer.
        $CFG->tool_dbransfer_migration_running = true;
        try {
            $feedback = new html_list_progress_trace();
            tool_dbtransfer_transfer_database($DB, $targetdb, $feedback);
            $feedback->finished();
        } catch (Exception $e) {
            if ($data->enablemaintenance) {
                tool_dbtransfer_maintenance_callback();
            }
            unset($CFG->tool_dbransfer_migration_running);
            throw $e;
        }
        unset($CFG->tool_dbransfer_migration_running);

        // Finish up.
        echo $OUTPUT->notification(get_string('success'), 'notifysuccess');
        echo $OUTPUT->continue_button("$CFG->wwwroot/$CFG->admin/");
        echo $OUTPUT->footer();
        die;
    }
}

// Otherwise display the settings form.
echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('transferdbtoserver', 'tool_dbtransfer'));

$info = format_text(get_string('transferdbintro', 'tool_dbtransfer'), FORMAT_MARKDOWN);
echo $OUTPUT->box($info);

$form->display();
if ($problem !== '') {
    echo $OUTPUT->box($problem, 'generalbox error');
}
echo $OUTPUT->footer();

<?php

/**
 * InnoDB conversion tool.
 *
 * @package    tool
 * @subpackage innodb
 * @copyright  2015 Pooya Saeedi
 * 
 */

define('NO_OUTPUT_BUFFERING', true);

require_once('../../../config.php');
require_once($CFG->libdir.'/adminlib.php');

admin_externalpage_setup('toolinnodb');

$confirm = optional_param('confirm', 0, PARAM_BOOL);

require_login();
require_capability('lion/site:config', context_system::instance());

echo $OUTPUT->header();
echo $OUTPUT->heading('Convert all MySQL tables from MYISAM to InnoDB');

if ($DB->get_dbfamily() != 'mysql') {
    notice('This function is for MySQL databases only!', new lion_url('/admin/'));
}

$prefix = str_replace('_', '\\_', $DB->get_prefix()).'%';
$sql = "SHOW TABLE STATUS WHERE Name LIKE ? AND Engine <> 'InnoDB'";
$rs = $DB->get_recordset_sql($sql, array($prefix));
if (!$rs->valid()) {
    $rs->close();
    echo $OUTPUT->box('<p>All tables are already using InnoDB database engine.</p>');
    echo $OUTPUT->continue_button('/admin/');
    echo $OUTPUT->footer();
    die;
}

if (data_submitted() and $confirm and confirm_sesskey()) {

    echo $OUTPUT->notification('Please be patient and wait for this to complete...', 'notifysuccess');

    core_php_time_limit::raise();

    foreach ($rs as $table) {
        $DB->set_debug(true);
        $fulltable = $table->name;
        try {
            $DB->change_database_structure("ALTER TABLE $fulltable ENGINE=INNODB");
        } catch (lion_exception $e) {
            echo $OUTPUT->notification(s($e->getMessage()).'<br />'.s($e->debuginfo));
        }
        $DB->set_debug(false);
    }
    $rs->close();
    echo $OUTPUT->notification('... done.', 'notifysuccess');
    echo $OUTPUT->continue_button(new lion_url('/admin/'));
    echo $OUTPUT->footer();

} else {
    $rs->close();
    $optionsyes = array('confirm'=>'1', 'sesskey'=>sesskey());
    $formcontinue = new single_button(new lion_url('/admin/tool/innodb/index.php', $optionsyes), get_string('yes'));
    $formcancel = new single_button(new lion_url('/admin/'), get_string('no'), 'get');
    echo $OUTPUT->confirm('Are you sure you want convert all your tables to the InnoDB format?', $formcontinue, $formcancel);
    echo $OUTPUT->footer();
}



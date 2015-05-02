<?php

/**
 * Export
 *
 * @package    tool_dbtransfer
 * @copyright  2008 Petr Skoda {@link http://skodak.org/}
 * 
 */

define('NO_OUTPUT_BUFFERING', true);

require('../../../config.php');
require_once('locallib.php');
require_once('database_export_form.php');

require_login();
admin_externalpage_setup('tooldbexport');

// Create form.
$form = new database_export_form();

if ($data = $form->get_data()) {
    tool_dbtransfer_export_xml_database($data->description, $DB);
    die;
}

echo $OUTPUT->header();
// TODO: add some more info here.
$form->display();
echo $OUTPUT->footer();

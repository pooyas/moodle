<?php

/**
 * Web services API documentation
 *
 * @package   webservice
 * @copyright 2015 Pooya Saeedi
 */

// Note:
// Let's ignore this for now. I may revive it later

die("Under development");
require_once('../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require($CFG->dirroot . '/webservice/lib.php');

admin_externalpage_setup('webservicedocumentation');

// get all the function descriptions
$functions = $DB->get_records('external_functions', array(), 'name');
$functiondescs = array();
foreach ($functions as $function) {
    $functiondescs[$function->name] = external_function_info($function);
}

//display the documentation for all documented protocols,
//regardless if they are activated or not
$protocols = array();
$protocols['rest'] = true;
$protocols['xmlrpc'] = true;

/// Check if we are in printable mode
$printableformat = optional_param('print', false, PARAM_BOOL);

/// OUTPUT
echo $OUTPUT->header();

$renderer = $PAGE->get_renderer('core', 'webservice');
echo $renderer->documentation_html($functiondescs,
        $printableformat, $protocols, array(), $PAGE->url);

/// trigger browser print operation
if (!empty($printableformat)) {
    $PAGE->requires->js_function_call('window.print', array());
}

echo $OUTPUT->footer();


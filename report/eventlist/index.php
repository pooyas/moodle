<?php

/**
 * Event documentation.
 *
 * @package   report_eventlist
 * @copyright 2014 Adrian Greeve <adrian@lion.com>
 * 
 */
require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');

admin_externalpage_setup('reporteventlists');

// Retrieve all events in a list.
$completelist = report_eventlist_list_generator::get_all_events_list();

$tabledata = array();
$components = array('0' => get_string('all', 'report_eventlist'));
$edulevel = array('0' => get_string('all', 'report_eventlist'));
$crud = array('0' => get_string('all', 'report_eventlist'));
foreach ($completelist as $value) {
    $components[] = $value['component'];
    $edulevel[] = $value['edulevel'];
    $crud[] = $value['crud'];
    $tabledata[] = (object)$value;
}
$components = array_unique($components);
$edulevel = array_unique($edulevel);
$crud = array_unique($crud);

// Create the filter form for the table.
$filtersection = new report_eventlist_filter_form(null, array('components' => $components, 'edulevel' => $edulevel,
        'crud' => $crud));

// Output.
$renderer = $PAGE->get_renderer('report_eventlist');
echo $renderer->render_event_list($filtersection, $tabledata);


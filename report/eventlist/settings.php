<?php

/**
 * Adds the event list link to the admin tree
 *
 * @package    report_eventlist
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

if ($hassiteconfig) {
    $url = $CFG->wwwroot . '/report/eventlist/index.php';
    $ADMIN->add('reports', new admin_externalpage('reporteventlists', get_string('pluginname', 'report_eventlist'), $url));

    // No report settings.
    $settings = null;
}

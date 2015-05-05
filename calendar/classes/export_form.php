<?php

/**
 * The mform for exporting calendar events
 *
 * @package    core
 * @subpackage calendar
 * @copyright  2015 Pooya Saeedi
 * 
 */

// Always include formslib.
if (!defined('LION_INTERNAL')) {
    die('Direct access to this script is forbidden.');    // It must be included from a Lion page.
}

require_once($CFG->dirroot.'/lib/formslib.php');

/**
 * The mform class for creating and editing a calendar
 *
 */
class core_calendar_export_form extends lionform {

    /**
     * The export form definition
     * @throws coding_exception
     */
    public function definition() {
        global $CFG;
        $mform = $this->_form;

        $export = array();
        $export[] = $mform->createElement('radio', 'exportevents', '', get_string('eventsall', 'calendar'), 'all');
        $export[] = $mform->createElement('radio', 'exportevents', '', get_string('eventsrelatedtocourses', 'calendar'), 'courses');

        $mform->addGroup($export, 'events', get_string('export', 'calendar'), '<br/>');
        $mform->addGroupRule('events', get_string('required'), 'required');
        $mform->setDefault('events', 'all');

        $range = array();
        if ($this->_customdata['allowthisweek']) {
            $range[] = $mform->createElement('radio', 'timeperiod', '', get_string('weekthis', 'calendar'), 'weeknow');
        }
        if ($this->_customdata['allownextweek']) {
            $range[] = $mform->createElement('radio', 'timeperiod', '', get_string('weeknext', 'calendar'), 'weeknext');
        }
        $range[] = $mform->createElement('radio', 'timeperiod', '', get_string('monththis', 'calendar'), 'monthnow');
        if ($this->_customdata['allownextmonth']) {
            $range[] = $mform->createElement('radio', 'timeperiod', '', get_string('monthnext', 'calendar'), 'monthnext');
        }
        $range[] = $mform->createElement('radio', 'timeperiod', '', get_string('recentupcoming', 'calendar'), 'recentupcoming');

        if ($CFG->calendar_customexport) {
            $a = new stdClass();
            $now = time();
            $time = $now - $CFG->calendar_exportlookback * DAYSECS;
            $a->timestart = userdate($time, get_string('strftimedatefullshort', 'langconfig'));
            $time = $now + $CFG->calendar_exportlookahead * DAYSECS;
            $a->timeend = userdate($time, get_string('strftimedatefullshort', 'langconfig'));

            $range[] = $mform->createElement('radio', 'timeperiod', '', get_string('customexport', 'calendar', $a), 'custom');
        }

        $mform->addGroup($range, 'period', get_string('for', 'calendar'), '<br/>');
        $mform->addGroupRule('period', get_string('required'), 'required');
        $mform->setDefault('period', 'recentupcoming');

        $buttons = array();
        $buttons[] = $mform->createElement('submit', 'generateurl', get_string('generateurlbutton', 'calendar'));
        $buttons[] = $mform->createElement('submit', 'export', get_string('exportbutton', 'calendar'));
        $mform->addGroup($buttons);
    }
}
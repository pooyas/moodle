<?php

/**
 * Overview report viewed event.
 *
 * @package    gradereport_overview
 * @copyright  2014 Adrian Greeve <adrian@lion.com>
 * 
 */

namespace gradereport_overview\event;

defined('LION_INTERNAL') || die();

/**
 * Overview report viewed event class.
 *
 * @package    gradereport_overview
 * @since      Lion 2.8
 * @copyright  2014 Adrian Greeve <adrian@lion.com>
 * 
 */
class grade_report_viewed extends \core\event\grade_report_viewed {

    /**
     * Initialise the event data.
     * @return void
     */
    protected function init() {
        parent::init();
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventgradereportviewed', 'gradereport_overview');
    }

    /**
     * Custom validation.
     *
     * Throw \coding_exception notice in case of any problems.
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' value must be set.');
        }
    }
}

<?php

/**
 * User report viewed event.
 *
 * @package    gradereport_user
 * @copyright  2014 Adrian Greeve <adrian@lion.com>
 * 
 */

namespace gradereport_user\event;

defined('LION_INTERNAL') || die();

/**
 * User report viewed event class.
 *
 * @package    gradereport_user
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
        return get_string('eventgradereportviewed', 'gradereport_user');
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

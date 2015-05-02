<?php

/**
 * Outcomes report viewed event.
 *
 * @package    gradereport_outcomes
 * @copyright  2014 Adrian Greeve <adrian@lion.com>
 * 
 */

namespace gradereport_outcomes\event;

defined('LION_INTERNAL') || die();

/**
 * Outcomes report viewed event class.
 *
 * @package    gradereport_outcomes
 * @since      Lion 2.8
 * @copyright  2014 Adrian Greeve <adrian@lion.com>
 * 
 */
class grade_report_viewed extends \core\event\grade_report_viewed {

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventgradereportviewed', 'gradereport_outcomes');
    }
}

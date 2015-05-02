<?php

/**
 * Grader report viewed event.
 *
 * @package    gradereport_grader
 * @copyright  2014 Adrian Greeve <adrian@lion.com>
 * 
 */

namespace gradereport_grader\event;

defined('LION_INTERNAL') || die();

/**
 * Grader report viewed event class.
 *
 * @package    gradereport_grader
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
        return get_string('eventgradereportviewed', 'gradereport_grader');
    }
}

<?php

/**
 * Grader report viewed event.
 *
 * @package    gradereport
 * @subpackage grader
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace gradereport_grader\event;

defined('LION_INTERNAL') || die();

/**
 * Grader report viewed event class.
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

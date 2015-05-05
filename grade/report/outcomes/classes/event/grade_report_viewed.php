<?php

/**
 * Outcomes report viewed event.
 *
 * @package    gradereport
 * @subpackage outcomes
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace gradereport_outcomes\event;

defined('LION_INTERNAL') || die();

/**
 * Outcomes report viewed event class.
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

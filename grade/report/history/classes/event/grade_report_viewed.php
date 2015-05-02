<?php

/**
 * Grade history report viewed event.
 *
 * @package    gradereport_history
 * @copyright  2014 Mark Nelson <markn@lion.com>
 * 
 */

namespace gradereport_history\event;

defined('LION_INTERNAL') || die();

/**
 * Grade history report viewed event class.
 *
 * @package    gradereport_history
 * @since      Lion 2.8
 * @copyright  2014 Mark Nelson <markn@lion.com>
 * 
 */
class grade_report_viewed extends \core\event\grade_report_viewed {

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventgradereportviewed', 'gradereport_history');
    }
}

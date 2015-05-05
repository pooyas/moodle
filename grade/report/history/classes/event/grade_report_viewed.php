<?php

/**
 * Grade history report viewed event.
 *
 * @package    gradereport
 * @subpackage history
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace gradereport_history\event;

defined('LION_INTERNAL') || die();

/**
 * Grade history report viewed event class.
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

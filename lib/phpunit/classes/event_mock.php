<?php

/**
 * Event mock.
 *
 * @package    core
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 * 
 */

require_once(__DIR__ . '/../../classes/event/base.php');

/**
 * Event mock class.
 *
 * @package    core
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 * 
 */
abstract class phpunit_event_mock extends \core\event\base {

    /**
     * Returns the log data of the event.
     *
     * @param \core\event\base $event event to get legacy eventdata from.
     * @return array
     */
    public static function testable_get_legacy_eventdata($event) {
        return $event->get_legacy_eventdata();
    }

    /**
     * Returns the log data of the event.
     *
     * @param \core\event\base $event event to get legacy logdata from.
     * @return array
     */
    public static function testable_get_legacy_logdata($event) {
        return $event->get_legacy_logdata();
    }

    /**
     * Returns event context.
     *
     * @param \core\event\base $event event to get context for.
     * @return context event context
     */
    public static function testable_get_event_context($event) {
        return $event->context;
    }

    /**
     * Sets event context.
     *
     * @param \core\event\base $event event to set context for.
     * @param context $context context to set.
     */
    public static function testable_set_event_context($event, $context) {
        $event->context = $context;
    }
}

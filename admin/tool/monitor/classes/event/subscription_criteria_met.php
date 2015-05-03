<?php

/**
 * The tool_monitor subscription criteria met event.
 *
 * @package    tool
 * @subpackage monitor
 * @copyright  2015 Pooya Saeedi 
 * 
 */

namespace tool_monitor\event;

defined('LION_INTERNAL') || die();

/**
 * The tool_monitor subscription criteria met event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string subscriptionid: id of the subscription.
 * }
 *
 */
class subscription_criteria_met extends \core\event\base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventsubcriteriamet', 'tool_monitor');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The criteria for the subscription with id '{$this->other['subscriptionid']}' was met.";
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['subscriptionid'])) {
            throw new \coding_exception('The \'subscriptionid\' value must be set in other.');
        }
    }
}

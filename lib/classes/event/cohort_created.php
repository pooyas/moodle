<?php


/**
 * Cohort updated event.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\event;
defined('LION_INTERNAL') || die();

/**
 * Cohort created event class.
 *
 */
class cohort_created extends base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'cohort';
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcohortcreated', 'core_cohort');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' created the cohort with id '$this->objectid'.";
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/cohort/index.php', array('contextid' => $this->contextid));
    }

    /**
     * Return legacy event name.
     *
     * @return string legacy event name
     */
    public static function get_legacy_eventname() {
        return 'cohort_added';
    }

    /**
     * Return legacy event data.
     *
     * @return \stdClass
     */
    protected function get_legacy_eventdata() {
        return $this->get_record_snapshot('cohort', $this->objectid);
    }
}

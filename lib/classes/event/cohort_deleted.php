<?php

/**
 * Cohort deleted event.
 *
 * @package    core
 * @copyright  2013 Dan Poltawski <dan@lion.com>
 * 
 */

namespace core\event;
defined('LION_INTERNAL') || die();

/**
 * Cohort deleted event class.
 *
 * @package    core
 * @since      Lion 2.6
 * @copyright  2013 Dan Poltawski <dan@lion.com>
 * 
 */
class cohort_deleted extends base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'cohort';
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcohortdeleted', 'core_cohort');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' deleted the cohort with id '$this->objectid'.";
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
     * @return null|string legacy event name
     */
    public static function get_legacy_eventname() {
        return 'cohort_deleted';
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

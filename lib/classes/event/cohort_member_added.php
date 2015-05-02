<?php

/**
 * User added to a cohort event.
 *
 * @package    core
 * @copyright  2013 Dan Poltawski <dan@lion.com>
 * 
 */

namespace core\event;
defined('LION_INTERNAL') || die();

/**
 * User added to a cohort event class.
 *
 * @package    core
 * @since      Lion 2.6
 * @copyright  2013 Dan Poltawski <dan@lion.com>
 * 
 */
class cohort_member_added extends base {

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
        return get_string('eventcohortmemberadded', 'core_cohort');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' added the user with id '$this->relateduserid' to the cohort with " .
            "id '$this->objectid'.";
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/cohort/assign.php', array('id' => $this->objectid));
    }

    /**
     * Return legacy event name.
     *
     * @return string legacy event name.
     */
    public static function get_legacy_eventname() {
        return 'cohort_member_added';
    }

    /**
     * Return legacy event data.
     *
     * @return \stdClass
     */
    protected function get_legacy_eventdata() {
        $data = new \stdClass();
        $data->cohortid = $this->objectid;
        $data->userid = $this->relateduserid;
        return $data;
    }

    /**
     * Custom validations.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }
    }
}

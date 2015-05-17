<?php


/**
 * The mod_assign submission unlocked event.
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_assign\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_assign submission unlocked event class.
 *
 */
class submission_unlocked extends base {
    /**
     * Flag for prevention of direct create() call.
     * @var bool
     */
    protected static $preventcreatecall = true;

    /**
     * Create instance of event.
     *
     *
     * @param \assign $assign
     * @param \stdClass $user
     * @return submission_unlocked
     */
    public static function create_from_user(\assign $assign, \stdClass $user) {
        $data = array(
            'context' => $assign->get_context(),
            'objectid' => $assign->get_instance()->id,
            'relateduserid' => $user->id,
        );
        self::$preventcreatecall = false;
        /** @var submission_unlocked $event */
        $event = self::create($data);
        self::$preventcreatecall = true;
        $event->set_assign($assign);
        $event->add_record_snapshot('user', $user);
        return $event;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' locked the submission for the user with id '$this->relateduserid' " .
            "for the assignment with course module id '$this->contextinstanceid'.";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventsubmissionunlocked', 'mod_assign');
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
        $this->data['objecttable'] = 'assign';
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        $user = $this->get_record_snapshot('user', $this->relateduserid);
        $logmessage = get_string('unlocksubmissionforstudent', 'assign', array('id' => $user->id, 'fullname' => fullname($user)));
        $this->set_legacy_logdata('unlock submission', $logmessage);
        return parent::get_legacy_logdata();
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     */
    protected function validate_data() {
        if (self::$preventcreatecall) {
            throw new \coding_exception('cannot call submission_unlocked::create() directly, use submission_unlocked::create_from_user() instead.');
        }

        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }
    }
}

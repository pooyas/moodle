<?php

/**
 * mod_assign workflow state updated event.
 *
 * @package    mod_assign
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_assign\event;

defined('LION_INTERNAL') || die();

/**
 * mod_assign workflow state updated event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string newstate: state of submission.
 * }
 *
 * @package    mod_assign
 * @since      Lion 2.6
 * @copyright  2015 Pooya Saeedi
 * 
 */
class workflow_state_updated extends base {
    /**
     * Flag for prevention of direct create() call.
     * @var bool
     */
    protected static $preventcreatecall = true;

    /**
     * Create instance of event.
     *
     * @since Lion 2.7
     *
     * @param \assign $assign
     * @param \stdClass $user
     * @param string $state
     * @return workflow_state_updated
     */
    public static function create_from_user(\assign $assign, \stdClass $user, $state) {
        $data = array(
            'context' => $assign->get_context(),
            'objectid' => $assign->get_instance()->id,
            'relateduserid' => $user->id,
            'other' => array(
                'newstate' => $state,
            ),
        );
        self::$preventcreatecall = false;
        /** @var workflow_state_updated $event */
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
        return "The user with id '$this->userid' has set the workflow state of the user with id '$this->relateduserid' " .
            "to the state '{$this->other['newstate']}' for the assignment with course module id '$this->contextinstanceid'.";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventworkflowstateupdated', 'mod_assign');
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
        $a = array('id' => $user->id, 'fullname' => fullname($user), 'state' => $this->other['newstate']);
        $logmessage = get_string('setmarkingworkflowstateforlog', 'assign', $a);
        $this->set_legacy_logdata('set marking workflow state', $logmessage);
        return parent::get_legacy_logdata();
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     */
    protected function validate_data() {
        if (self::$preventcreatecall) {
            throw new \coding_exception('cannot call workflow_state_updated::create() directly, use workflow_state_updated::create_from_user() instead.');
        }

        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }

        if (!isset($this->other['newstate'])) {
            throw new \coding_exception('The \'newstate\' value must be set in other.');
        }
    }
}

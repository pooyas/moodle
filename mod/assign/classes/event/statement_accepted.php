<?php

/**
 * The mod_assign statement accepted event.
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_assign\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_assign statement accepted event class.
 *
 */
class statement_accepted extends base {
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
     * @param \stdClass $submission
     * @return statement_accepted
     */
    public static function create_from_submission(\assign $assign, \stdClass $submission) {
        $data = array(
            'context' => $assign->get_context(),
            'objectid' => $submission->id
        );
        self::$preventcreatecall = false;
        /** @var statement_accepted $event */
        $event = self::create($data);
        self::$preventcreatecall = true;
        $event->set_assign($assign);
        $event->add_record_snapshot('assign_submission', $submission);
        return $event;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has accepted the statement of the submission with id '$this->objectid' " .
            "for the assignment with course module id '$this->contextinstanceid'.";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventstatementaccepted', 'mod_assign');
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'assign_submission';
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        global $USER;
        $logmessage = get_string('submissionstatementacceptedlog', 'mod_assign', fullname($USER)); // Nasty hack.
        $this->set_legacy_logdata('submission statement accepted', $logmessage);
        return parent::get_legacy_logdata();
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        if (self::$preventcreatecall) {
            throw new \coding_exception('cannot call statement_accepted::create() directly, use statement_accepted::create_from_submission() instead.');
        }

        parent::validate_data();
    }
}

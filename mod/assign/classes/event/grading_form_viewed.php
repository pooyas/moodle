<?php


/**
 * The mod_assign grading form viewed event.
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_assign\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_assign grading form viewed event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int assignid: the id of the assignment.
 * }
 *
 */
class grading_form_viewed extends base {
    /**
     * Flag for prevention of direct create() call.
     * @var bool
     */
    protected static $preventcreatecall = true;

    /**
     * Create instance of event.
     *
     * @param \assign $assign
     * @param \stdClass $user
     * @return grading_form_viewed
     */
    public static function create_from_user(\assign $assign, \stdClass $user) {
        $data = array(
            'relateduserid' => $user->id,
            'context' => $assign->get_context(),
            'other' => array(
                'assignid' => $assign->get_instance()->id,
            ),
        );
        self::$preventcreatecall = false;
        /** @var grading_form_viewed $event */
        $event = self::create($data);
        self::$preventcreatecall = true;
        $event->set_assign($assign);
        $event->add_record_snapshot('user', $user);
        return $event;
    }

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventgradingformviewed', 'mod_assign');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the grading form for the user with id '$this->relateduserid' " .
            "for the assignment with course module id '$this->contextinstanceid'.";
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        $user = $this->get_record_snapshot('user', $this->relateduserid);
        $msg = get_string('viewgradingformforstudent', 'assign',
            array('id' => $user->id, 'fullname' => fullname($user)));
        $this->set_legacy_logdata('view grading form', $msg);
        return parent::get_legacy_logdata();
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     */
    protected function validate_data() {
        if (self::$preventcreatecall) {
            throw new \coding_exception('cannot call grading_form_viewed::create() directly, use grading_form_viewed::create_from_user() instead.');
        }

        parent::validate_data();

        if (!isset($this->relateduserid)) {
            throw new \coding_exception('The \'relateduserid\' must be set.');
        }

        if (!isset($this->other['assignid'])) {
            throw new \coding_exception('The \'assignid\' value must be set in other.');
        }
    }
}

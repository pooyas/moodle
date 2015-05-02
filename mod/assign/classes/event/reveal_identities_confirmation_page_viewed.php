<?php

/**
 * The mod_assign reveal identities confirmation page viewed event.
 *
 * @package    mod_assign
 * @copyright  2014 Mark Nelson <markn@lion.com>
 * 
 */

namespace mod_assign\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_assign reveal identities confirmation page viewed event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int assignid: the id of the assignment.
 * }
 *
 * @package    mod_assign
 * @since      Lion 2.7
 * @copyright  2014 Mark Nelson <markn@lion.com>
 * 
 */
class reveal_identities_confirmation_page_viewed extends base {
    /**
     * Flag for prevention of direct create() call.
     * @var bool
     */
    protected static $preventcreatecall = true;

    /**
     * Create instance of event.
     *
     * @param \assign $assign
     * @return reveal_identities_confirmation_page_viewed
     */
    public static function create_from_assign(\assign $assign) {
        $data = array(
            'context' => $assign->get_context(),
            'other' => array(
                'assignid' => $assign->get_instance()->id,
            ),
        );
        self::$preventcreatecall = false;
        /** @var reveal_identities_confirmation_page_viewed $event */
        $event = self::create($data);
        self::$preventcreatecall = true;
        $event->set_assign($assign);
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
        return get_string('eventrevealidentitiesconfirmationpageviewed', 'mod_assign');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the confirmation page for revealing identities for the " .
            "assignment with course module id '$this->contextinstanceid'.";
    }


    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        $this->set_legacy_logdata('view', get_string('viewrevealidentitiesconfirm', 'assign'));
        return parent::get_legacy_logdata();
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     */
    protected function validate_data() {
        if (self::$preventcreatecall) {
            throw new \coding_exception('cannot call reveal_identities_confirmation_page_viewed::create() directly, use reveal_identities_confirmation_page_viewed::create_from_grade() instead.');
        }

        parent::validate_data();

        if (!isset($this->other['assignid'])) {
            throw new \coding_exception('The \'assignid\' value must be set in other.');
        }
    }
}

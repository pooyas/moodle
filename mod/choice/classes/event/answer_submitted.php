<?php

/**
 * The mod_choice answer submitted event.
 *
 * @package    mod
 * @subpackage choice
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_choice\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_choice answer submitted event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int choiceid: id of choice.
 *      - int optionid: (optional) id of option.
 * }
 *
 */
class answer_submitted extends \core\event\base {

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' made the choice with id '$this->objectid' in the choice activity
            with course module id '$this->contextinstanceid'.";
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        $legacylogdata = array($this->courseid,
            'choice',
            'choose',
            'view.php?id=' . $this->contextinstanceid,
            $this->other['choiceid'],
            $this->contextinstanceid);

        return $legacylogdata;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventanswercreated', 'mod_choice');
    }

    /**
     * Get URL related to the action
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/choice/view.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'c';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'choice';
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['choiceid'])) {
            throw new \coding_exception('The \'choiceid\' value must be set in other.');
        }
    }
}

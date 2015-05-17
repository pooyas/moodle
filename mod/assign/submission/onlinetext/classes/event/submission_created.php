<?php


/**
 * The assignsubmission_onlinetext submission_created event.
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 */

namespace assignsubmission_onlinetext\event;

defined('LION_INTERNAL') || die();

/**
 * The assignsubmission_onlinetext submission_created event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - int onlinetextwordcount: Word count of the online text submission.
 * }
 *
 */
class submission_created extends \mod_assign\event\submission_created {

    /**
     * Init method.
     */
    protected function init() {
        parent::init();
        $this->data['objecttable'] = 'assignsubmission_file';
    }

    /**
     * Returns non-localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        $descriptionstring = "The user with id '$this->userid' created an online text submission with " .
            "'{$this->other['onlinetextwordcount']}' words in the assignment with course module id " .
            "'$this->contextinstanceid'";
        if (!empty($this->other['groupid'])) {
            $descriptionstring .= " for the group with id '{$this->other['groupid']}'.";
        } else {
            $descriptionstring .= ".";
        }

        return $descriptionstring;
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (!isset($this->other['onlinetextwordcount'])) {
            throw new \coding_exception('The \'onlinetextwordcount\' value must be set in other.');
        }
    }
}

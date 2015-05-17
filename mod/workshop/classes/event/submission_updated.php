<?php


/**
 * The mod_workshop submission updated event.
 *
 * @package    mod
 * @subpackage workshop
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_workshop\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_workshop submission updated event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - string submissiontitle: (optional) Submission title.
 * }
 *
 */
class submission_updated extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'workshop_submissions';
    }

    /**
     * Returns non-localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' updated the submission with id '$this->objectid' for the workshop " .
            "with course module id '$this->contextinstanceid'.";
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventsubmissionupdated', 'workshop');
    }

    /**
     * Returns relevant URL.
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/workshop/submission.php',
                array('cmid' => $this->contextinstanceid, 'id' => $this->objectid));
    }

    /**
     * replace add_to_log() statement.
     *
     * @return array of parameters to be passed to legacy add_to_log() function.
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'workshop', 'update submission',
            'submission.php?cmid=' . $this->contextinstanceid . '&id=' . $this->objectid,
            $this->objectid, $this->contextinstanceid);
    }
}

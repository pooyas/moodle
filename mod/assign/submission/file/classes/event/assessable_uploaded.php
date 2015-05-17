<?php


/**
 * The assignsubmission_file assessable uploaded event.
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 */

namespace assignsubmission_file\event;

defined('LION_INTERNAL') || die();

/**
 * The assignsubmission_file assessable uploaded event class.
 *
 */
class assessable_uploaded extends \core\event\assessable_uploaded {

    /**
     * Legacy event files.
     *
     * @var array
     */
    protected $legacyfiles = array();

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has uploaded a file to the submission with id '$this->objectid' " .
            "in the assignment activity with course module id '$this->contextinstanceid'.";
    }

    /**
     * Legacy event data if get_legacy_eventname() is not empty.
     *
     * @return \stdClass
     */
    protected function get_legacy_eventdata() {
        $eventdata = new \stdClass();
        $eventdata->modulename = 'assign';
        $eventdata->cmid = $this->contextinstanceid;
        $eventdata->itemid = $this->objectid;
        $eventdata->courseid = $this->courseid;
        $eventdata->userid = $this->userid;
        if (count($this->legacyfiles) > 1) {
            $eventdata->files = $this->legacyfiles;
        }
        $eventdata->file = $this->legacyfiles;
        $eventdata->pathnamehashes = array_keys($this->legacyfiles);
        return $eventdata;
    }

    /**
     * Return the legacy event name.
     *
     * @return string
     */
    public static function get_legacy_eventname() {
        return 'assessable_file_uploaded';
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventassessableuploaded', 'assignsubmission_file');
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/assign/view.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Sets the legacy event data.
     *
     * @param stdClass $legacyfiles legacy event data.
     * @return void
     */
    public function set_legacy_files($legacyfiles) {
        $this->legacyfiles = $legacyfiles;
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        parent::init();
        $this->data['objecttable'] = 'assign_submission';
    }

}

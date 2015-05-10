<?php

/**
 * The mod_workshop assessable uploaded event.
 *
 * @package    mod
 * @subpackage workshop
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_workshop\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_workshop assessable uploaded event class.
 *
 */
class assessable_uploaded extends \core\event\assessable_uploaded {

    /**
     * Legacy log data.
     *
     * @var array
     */
    protected $legacylogdata = null;

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has uploaded the submission with id '$this->objectid' " .
            "to the workshop activity with course module id '$this->contextinstanceid'.";
    }

    /**
     * Legacy event data if get_legacy_eventname() is not empty.
     *
     * @return \stdClass
     */
    protected function get_legacy_eventdata() {
        $eventdata = new \stdClass();
        $eventdata->modulename   = 'workshop';
        $eventdata->cmid         = $this->contextinstanceid;
        $eventdata->itemid       = $this->objectid;
        $eventdata->courseid     = $this->courseid;
        $eventdata->userid       = $this->userid;
        $eventdata->content      = $this->other['content'];
        if ($this->other['pathnamehashes']) {
            $eventdata->pathnamehashes = $this->other['pathnamehashes'];
        }
        return $eventdata;
    }

    /**
     * Return the legacy event name.
     *
     * @return string
     */
    public static function get_legacy_eventname() {
        return 'assessable_content_uploaded';
    }

    /**
     * Return the legacy log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return $this->legacylogdata;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventassessableuploaded', 'mod_workshop');
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/workshop/submission.php',
            array('cmid' => $this->contextinstanceid, 'id' => $this->objectid));
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        parent::init();
        $this->data['objecttable'] = 'workshop_submissions';
    }

    /**
     * Set the legacy log data.
     *
     * @param array $legacylogdata
     * @return void
     */
    public function set_legacy_logdata($legacylogdata) {
        $this->legacylogdata = $legacylogdata;
    }
}

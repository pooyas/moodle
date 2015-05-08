<?php

/**
 * The mod_scorm sco launched event.
 *
 * @package    mod_scorm
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_scorm\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_scorm sco launched event class.
 *
 * @property-read array $other {
 *      Extra information about event properties.
 *
 *      - string loadedcontent: A reference to the content loaded.
 *      - int instanceid: (optional) Instance id of the scorm activity.
 * }
 *
 * @package    mod_scorm
 * @since      Lion 2.7
 * @copyright  2015 Pooya Saeedi
 * 
 */
class sco_launched extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'scorm_scoes';
    }

    /**
     * Returns non-localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' launched the sco with id '$this->objectid' for the scorm with " .
            "course module id '$this->contextinstanceid'.";
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventscolaunched', 'mod_scorm');
    }

    /**
     * Get URL related to the action
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/scorm/player.php', array('id' => $this->contextinstanceid, 'scoid' => $this->objectid));
    }

    /**
     * Replace add_to_log() statement.
     *
     * @return array of parameters to be passed to legacy add_to_log() function.
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'scorm', 'launch', 'view.php?id=' . $this->contextinstanceid,
                $this->other['loadedcontent'], $this->contextinstanceid);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (empty($this->other['loadedcontent'])) {
            throw new \coding_exception('The \'loadedcontent\' value must be set in other.');
        }
    }
}

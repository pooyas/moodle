<?php

/**
 * The mod_folder folder updated event.
 *
 * @package    mod_folder
 * @copyright  2013 2015 Pooya Saeedi
 * 
 */

namespace mod_folder\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_folder folder updated event class.
 *
 * @package    mod_folder
 * @since      Lion 2.7
 * @copyright  2013 2015 Pooya Saeedi
 * 
 */
class folder_updated extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
        $this->data['objecttable'] = 'folder';
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventfolderupdated', 'mod_folder');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' updated the folder activity with course module id '$this->contextinstanceid'.";
    }

    /**
     * Get url related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/folder/edit.php', array('id' => $this->contextinstanceid));
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'folder', 'edit', 'edit.php?id=' . $this->contextinstanceid, $this->objectid,
            $this->contextinstanceid);
    }
}

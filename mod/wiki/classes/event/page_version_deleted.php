<?php

/**
 * The mod_wiki page version deleted event.
 *
 * @package    mod
 * @subpackage wiki
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_wiki\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_wiki page version deleted event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int pageid: id wiki page.
 * }
 *
 */
class page_version_deleted extends \core\event\base {
    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'd';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'wiki_versions';
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventpageversiondeleted', 'mod_wiki');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' deleted version '$this->objectid' for the page with id '{$this->other['pageid']}' " .
            "for the wiki with course module id '$this->contextinstanceid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return(array($this->courseid, 'wiki', 'admin', 'admin.php?pageid=' . $this->other['pageid'], $this->other['pageid'],
            $this->contextinstanceid));
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/wiki/admin.php', array('pageid' => $this->other['pageid']));
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (!isset($this->other['pageid'])) {
            throw new \coding_exception('The \'pageid\' value must be set in other.');
        }
    }
}

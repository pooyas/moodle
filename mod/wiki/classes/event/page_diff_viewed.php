<?php

/**
 * The mod_wiki diff viewed event.
 *
 * @package    mod_wiki
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
 * 
 */

namespace mod_wiki\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_wiki diff viewed event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int comparewith: version number to compare with.
 *      - int compare: version number to compare.
 * }
 *
 * @package    mod_wiki
 * @since      Lion 2.7
 * @copyright  2013 Rajesh Taneja <rajesh@lion.com>
 * 
 */
class page_diff_viewed extends \core\event\base {
    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'wiki_pages';
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventdiffviewed', 'mod_wiki');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the diff for the page with id '$this->objectid' for the wiki with " .
            "course module id '$this->contextinstanceid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return(array($this->courseid, 'wiki', 'diff', 'diff.php?pageid=' . $this->objectid . '&comparewith=' .
            $this->other['comparewith'] . '&compare=' .  $this->other['compare'], $this->objectid,
            $this->contextinstanceid));
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/wiki/diff.php', array(
            'pageid' => $this->objectid,
            'comparewith' => $this->other['comparewith'],
            'compare' => $this->other['compare']
            ));
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (!isset($this->other['comparewith'])) {
            throw new \coding_exception('The \'comparewith\' value must be set in other.');
        }
        if (!isset($this->other['compare'])) {
            throw new \coding_exception('The \'compare\' value must be set in other.');
        }
    }
}

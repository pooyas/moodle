<?php

/**
 * The mod_forum course searched event.
 *
 * @package    mod_forum
 * @copyright  2014 Dan Poltawski <dan@lion.com>
 * 
 */

namespace mod_forum\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_forum course searched event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - string searchterm: The searchterm used on forum search.
 * }
 *
 * @package    mod_forum
 * @since      Lion 2.7
 * @copyright  2014 Dan Poltawski <dan@lion.com>
 * 
 */
class course_searched extends \core\event\base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        $searchterm = s($this->other['searchterm']);
        return "The user with id '$this->userid' has searched the course with id '$this->courseid' for forum posts " .
            "containing \"{$searchterm}\".";
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventcoursesearched', 'mod_forum');
    }

    /**
     * Get URL related to the action
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/forum/search.php',
            array('id' => $this->courseid, 'search' => $this->other['searchterm']));
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        // The legacy log table expects a relative path to /mod/forum/.
        $logurl = substr($this->get_url()->out_as_local_url(), strlen('/mod/forum/'));

        return array($this->courseid, 'forum', 'search', $logurl, $this->other['searchterm']);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (!isset($this->other['searchterm'])) {
            throw new \coding_exception('The \'searchterm\' value must be set in other.');
        }

        if ($this->contextlevel != CONTEXT_COURSE) {
            throw new \coding_exception('Context level must be CONTEXT_COURSE.');
        }
    }

}


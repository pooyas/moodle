<?php

/**
 * For use in unit tests that require an info object which isn't really used.
 *
 * @package core
 * @subpackage availability
 * @copyright 2015 Pooya Saeedi
 * 
 * Note:
 * used in tests
 */

// Note:
// Renaming required

namespace core_availability;

defined('MOODLE_INTERNAL') || die();

/**
 * For use in unit tests that require an info object which isn't really used.
 *
 * @package core
 * @subpackage availability
 * @copyright 2015 Pooya Saeedi
 */

class mock_info extends info {
    /** @var int User id for modinfo */
    protected $userid;

    /**
     * Constructs with item details.
     *
     * @param \stdClass $course Optional course param (otherwise uses $SITE)
     * @param int $userid Userid for modinfo (if used)
     */
    public function __construct($course = null, $userid = 0) {
        global $SITE;
        if (!$course) {
            $course = $SITE;
        }
        parent::__construct($course, true, null);
        $this->userid = $userid;
    }

    protected function get_thing_name() {
        return 'Mock';
    }

    public function get_context() {
        return \context_course::instance($this->get_course()->id);
    }

    protected function get_view_hidden_capability() {
        return 'moodle/course:viewhiddensections';
    }

    protected function set_in_database($availability) {
    }

    public function get_modinfo() {
        // Allow modinfo usage outside is_available etc., so we can use this
        // to directly call into condition is_available.
        if (!$this->userid) {
            throw new \coding_exception('Need to set mock_info userid');
        }
        return get_fast_modinfo($this->course, $this->userid);
    }
}

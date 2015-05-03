<?php

namespace logstore_legacy\event;

defined('LION_INTERNAL') || die();

/**
 * Legacy log emulation event class.
 *
 * @package    tool
 * @subpackage log
 * @copyright  2015 Pooya Saeedi
 * 
 */
class legacy_logged extends \core\event\base {

    public function init() {
        throw new \coding_exception('legacy events cannot be triggered');
    }

    public static function get_name() {
        return get_string('eventlegacylogged', 'logstore_legacy');
    }

    public function get_description() {
        return $this->other['module'] . ' ' . $this->other['action'] . ' ' . $this->other['info'];
    }

    public function get_url() {
        global $CFG;
        require_once("$CFG->dirroot/course/lib.php");

        $url = \make_log_url($this->other['module'], $this->other['url']);
        if (!$url) {
            return null;
        }
        return new \lion_url($url);
    }
}

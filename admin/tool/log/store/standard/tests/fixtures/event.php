<?php

/**
 * Fixtures for standard log storage testing.
 *
 * @package    tool
 * @subpackage log
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace logstore_standard\event;

defined('LION_INTERNAL') || die();


class unittest_executed extends \core\event\base {
    public static function get_name() {
        return 'xxx';
    }

    public function get_description() {
        return 'yyy';
    }

    protected function init() {
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    public function get_url() {
        return new \lion_url('/somepath/somefile.php', array('id' => $this->data['other']['sample']));
    }
}

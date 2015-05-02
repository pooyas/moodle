<?php

/**
 * Fixtures for database log storage testing.
 *
 * @package    logstore_database
 * @copyright  2014 Petr Skoda
 * 
 */

namespace logstore_database\event;

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

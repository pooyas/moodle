<?php

/**
 * mod_assign unit test events.
 *
 * @package    mod
 * @subpackage assign
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_assign_unittests\event;

defined('LION_INTERNAL') || die();

/**
 * mod_assign submission_created unit test event class.
 *
 */
class submission_created extends \mod_assign\event\submission_created {
}

/**
 * mod_assign submission_updated unit test event class.
 *
 */
class submission_updated extends \mod_assign\event\submission_updated {
}

/**
 * mod_assign test class for event base.
 *
 */
class nothing_happened extends \mod_assign\event\base {
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    public static function get_name() {
        return 'Nothing happened';
    }
}

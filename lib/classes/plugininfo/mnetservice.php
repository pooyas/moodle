<?php

/**
 * Defines classes used for plugin info.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */
namespace core\plugininfo;

defined('LION_INTERNAL') || die();

/**
 * Class representing an MNet service
 */
class mnetservice extends base {

    public function is_enabled() {
        global $CFG;

        if (empty($CFG->mnet_dispatcher_mode) || $CFG->mnet_dispatcher_mode !== 'strict') {
            return false;
        } else {
            return parent::is_enabled();
        }
    }
}

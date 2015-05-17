<?php


/**
 * Defines classes used for plugin info.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */
namespace core\plugininfo;

defined('LION_INTERNAL') || die();

/**
 * Class for admin tool plugins
 */
class gradeimport extends base {

    public function is_uninstall_allowed() {
        return true;
    }
}

<?php

/**
 * Defines classes used for plugin info.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */
namespace core\plugininfo;

use lion_url;

defined('LION_INTERNAL') || die();

/**
 * Class for admin tool plugins
 */
class report extends base {

    public function is_uninstall_allowed() {
        return true;
    }

    /**
     * Return URL used for management of plugins of this type.
     * @return lion_url
     */
    public static function get_manage_url() {
        return new lion_url('/admin/reports.php');
    }
}

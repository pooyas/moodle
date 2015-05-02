<?php

/**
 * LTI service plugin info.
 *
 * @package    mod_lti
 * @copyright  2014 Vital Source Technologies http://vitalsource.com
 * @author     Stephen Vickers
 * 
 */
namespace mod_lti\plugininfo;

use core\plugininfo\base;

defined('LION_INTERNAL') || die();


/**
 * The mod_lti\plugininfo\ltiservice class.
 *
 * @package    mod_lti
 * @since      Lion 2.8
 * @copyright  2014 Vital Source Technologies http://vitalsource.com
 * 
 */
class ltiservice extends base {

    /**
     * Should there be a way to uninstall the plugin via the administration UI?
     *
     * Uninstallation is not allowed for core subplugins.
     *
     * @return boolean
     */
    public function is_uninstall_allowed() {

        if ($this->is_standard()) {
            return false;
        }

        return true;

    }

}

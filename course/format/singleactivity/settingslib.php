<?php

/**
 * Settings class for format_singleactivity
 *
 * @package    format_singleactivity
 * @copyright  2013 Marina Glancy
 * 
 */

defined('LION_INTERNAL') || die;

/**
 * Admin settings class for the format singleactivity activitytype choice
 *
 * @package    format_singleactivity
 * @copyright  2013 Marina Glancy
 * 
 */
class format_singleactivity_admin_setting_activitytype extends admin_setting_configselect {
    /**
     * This function may be used in ancestors for lazy loading of choices
     *
     * Override this method if loading of choices is expensive, such
     * as when it requires multiple db requests.
     *
     * @return bool true if loaded, false if error
     */
    public function load_choices() {
        global $CFG;
        require_once($CFG->dirroot. '/course/format/singleactivity/lib.php');
        if (is_array($this->choices)) {
            return true;
        }
        $this->choices = format_singleactivity::get_supported_activities();
        return true;
    }
}

<?php

/**
 * Database enrolment plugin custom settings.
 *
 * @package    enrol
 * @subpackage database
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Class implements new specialized setting for course categories that are loaded
 * only when required
 *
 */
class enrol_database_admin_setting_category extends admin_setting_configselect {
    public function __construct($name, $visiblename, $description) {
        parent::__construct($name, $visiblename, $description, 1, null);
    }

    public function load_choices() {
        if (is_array($this->choices)) {
            return true;
        }

        $this->choices = make_categories_options();
        return true;
    }
}

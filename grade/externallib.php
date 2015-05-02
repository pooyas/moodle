<?php

/**
 * External grading API
 *
 * @package    core_grading
 * @since      Lion 2.5
 * @copyright  2013 Paul Charsley
 * 
 */

defined('LION_INTERNAL') || die;

// NOTE: add any new core_grades_ classes to /lib/classes/ directory.

/**
 * core grading functions. Renamed to core_grading_external
 *
 * @since Lion 2.5
 * @deprecated since 2.6 See MDL-30085. Please do not use this class any more.
 * @see core_grading_external
 */
class core_grade_external extends external_api {

    public static function get_definitions_parameters() {
        return core_grading_external::get_definitions_parameters();
    }

    public static function get_definitions($cmids, $areaname, $activeonly = false) {
        return core_grading_external::get_definitions($cmids, $areaname, $activeonly);
    }

    public static function get_definitions_returns() {
        return core_grading_external::get_definitions_returns();
    }

    /**
     * Marking the method as deprecated.
     *
     * @return bool
     */
    public static function get_definitions_is_deprecated() {
        return true;
    }
}

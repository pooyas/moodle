<?php

namespace core_calendar;

/**
 * Class \core_calendar\type_factory.
 *
 * Factory class producing required subclasses of {@link \core_calendar\type_base}.
 *
 * @package    core
 * @subpackage calendar
 * @copyright  2015 Pooya Saeedi
 * 
 */
class type_factory {

    /**
     * Returns an instance of the currently used calendar type.
     *
     * @param string|null $type the calendar type to use, if none provided use logic to determine
     * @return calendartype_* the created calendar_type class
     * @throws coding_exception if the calendar type file could not be loaded
     */
    public static function get_calendar_instance($type = null) {
        if (is_null($type)) {
            $type = self::get_calendar_type();
        }

        $class = "\\calendartype_$type\\structure";

        // Ensure the calendar type exists. It may occur that a user has selected a calendar type, which was then
        // deleted. If this happens we want to fall back on the Gregorian calendar type.
        if (!class_exists($class)) {
            $class = "\\calendartype_gregorian\\structure";
        }

        return new $class();
    }

    /**
     * Returns a list of calendar typess available for use.
     *
     * @return array the list of calendar types
     */
    public static function get_list_of_calendar_types() {
        $calendars = array();
        $calendardirs = \core_component::get_plugin_list('calendartype');

        foreach ($calendardirs as $name => $location) {
            $calendars[$name] = get_string('name', "calendartype_{$name}");
        }

        return $calendars;
    }

    /**
     * Returns the current calendar type in use.
     *
     * @return string the current calendar type being used
     */
    public static function get_calendar_type() {
        global $CFG, $USER, $SESSION, $COURSE;

        // Course calendartype can override all other settings for this page.
        if (!empty($COURSE->id) and $COURSE->id != SITEID and !empty($COURSE->calendartype)) {
            $return = $COURSE->calendartype;
        } else if (!empty($SESSION->calendartype)) { // Session calendartype can override other settings.
            $return = $SESSION->calendartype;
        } else if (!empty($USER->calendartype)) {
            $return = $USER->calendartype;
        } else if (!empty($CFG->calendartype)) {
            $return = $CFG->calendartype;
        } else {
            $return = 'gregorian';
        }

        return $return;
    }
}

<?php

/**
 * Front-end class.
 *
 * @package    availability
 * @subpackage date
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace availability_date;

defined('LION_INTERNAL') || die();

/**
 * Front-end class.
 *
 */
class frontend extends \core_availability\frontend {
    /**
     * The date selector popup is not currently supported because the date
     * selector is in a messy state (about to be replaced with a new YUI3
     * implementation) and MDL-44814 was rejected. I have left the code in
     * place, but disabled. When the date selector situation is finalised,
     * then this constant should be removed (either applying MDL-44814 if old
     * selector is still in use, or modifying the JavaScript code to support the
     * new date selector if it has landed).
     *
     * @var bool
     */
    const DATE_SELECTOR_SUPPORTED = false;

    protected function get_javascript_strings() {
        return array('ajaxerror', 'direction_before', 'direction_from', 'direction_until',
                'direction_label');
    }

    /**
     * Given field values, obtains the corresponding timestamp.
     *
     * @param int $year Year
     * @param int $month Month
     * @param int $day Day
     * @param int $hour Hour
     * @param int $minute Minute
     * @return int Timestamp
     */
    public static function get_time_from_fields($year, $month, $day, $hour, $minute) {
        $calendartype = \core_calendar\type_factory::get_calendar_instance();
        $gregoriandate = $calendartype->convert_to_gregorian(
                $year, $month, $day, $hour, $minute);
        return make_timestamp($gregoriandate['year'], $gregoriandate['month'],
                $gregoriandate['day'], $gregoriandate['hour'], $gregoriandate['minute'], 0);
    }

    /**
     * Given a timestamp, obtains corresponding field values.
     *
     * @param int $time Timestamp
     * @return \stdClass Object with fields for year, month, day, hour, minute
     */
    public static function get_fields_from_time($time) {
        $calendartype = \core_calendar\type_factory::get_calendar_instance();
        $wrongfields = $calendartype->timestamp_to_date_array($time);
        return array('day' => $wrongfields['mday'],
                'month' => $wrongfields['mon'], 'year' => $wrongfields['year'],
                'hour' => $wrongfields['hours'], 'minute' => $wrongfields['minutes']);
    }

    protected function get_javascript_init_params($course, \cm_info $cm = null,
            \section_info $section = null) {
        global $CFG, $OUTPUT;
        require_once($CFG->libdir . '/formslib.php');

        // Support internationalised calendars.
        $calendartype = \core_calendar\type_factory::get_calendar_instance();

        // Get current date, but set time to 00:00 (to make it easier to
        // specify whole days) and change name of mday field to match below.
        $wrongfields = $calendartype->timestamp_to_date_array(time());
        $current = array('day' => $wrongfields['mday'],
                'month' => $wrongfields['mon'], 'year' => $wrongfields['year'],
                'hour' => 0, 'minute' => 0);

        // Time part is handled the same everywhere.
        $hours = array();
        for ($i = 0; $i <= 23; $i++) {
            $hours[$i] = sprintf("%02d", $i);
        }
        $minutes = array();
        for ($i = 0; $i < 60; $i += 5) {
            $minutes[$i] = sprintf("%02d", $i);
        }

        // List date fields.
        $fields = $calendartype->get_date_order(
                $calendartype->get_min_year(), $calendartype->get_max_year());

        // Add time fields - in RTL mode these are switched.
        $fields['split'] = '/';
        if (right_to_left()) {
            $fields['minute'] = $minutes;
            $fields['colon'] = ':';
            $fields['hour'] = $hours;
        } else {
            $fields['hour'] = $hours;
            $fields['colon'] = ':';
            $fields['minute'] = $minutes;
        }

        // Output all date fields.
        $html = '<span class="availability-group">';
        foreach ($fields as $field => $options) {
            if ($options === '/') {
                $html = rtrim($html);

                // In Gregorian calendar mode only, we support a date selector popup, reusing
                // code from form to ensure consistency.
                if ($calendartype->get_name() === 'gregorian' && self::DATE_SELECTOR_SUPPORTED) {
                    $image = $OUTPUT->pix_icon('i/calendar', get_string('calendar', 'calendar'), 'lion');
                    $html .= ' ' . \html_writer::link('#', $image, array('name' => 'x[calendar]'));
                    form_init_date_js();
                }

                $html .= '</span> <span class="availability-group">';
                continue;
            }
            if ($options === ':') {
                $html .= ': ';
                continue;
            }
            $html .= \html_writer::start_tag('label');
            $html .= \html_writer::span(get_string($field) . ' ', 'accesshide');
            // NOTE: The fields need to have these weird names in order that they
            // match the standard Lion form control, otherwise the date selector
            // won't find them.
            $html .= \html_writer::start_tag('select', array('name' => 'x[' . $field . ']'));
            foreach ($options as $key => $value) {
                $params = array('value' => $key);
                if ($current[$field] == $key) {
                    $params['selected'] = 'selected';
                }
                $html .= \html_writer::tag('option', s($value), $params);
            }
            $html .= \html_writer::end_tag('select');
            $html .= \html_writer::end_tag('label');
            $html .= ' ';
        }
        $html = rtrim($html) . '</span>';

        // Also get the time that corresponds to this default date.
        $time = self::get_time_from_fields($current['year'], $current['month'],
                $current['day'], $current['hour'], $current['minute']);

        return array($html, $time);
    }
}

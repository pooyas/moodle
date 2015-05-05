<?php

/**
 * Grade report viewed event.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Grade report viewed event class.
 *
 * @package    core
 * @since      Lion 2.8
 * @copyright  2015 Pooya Saeedi
 * 
 */
abstract class grade_report_viewed extends base {

    /** string $reporttype The report type being viewed. */
    protected $reporttype;

    /**
     * Initialise the event data.
     */
    protected function init() {
        $reporttype = explode('\\', $this->eventname);
        $shorttype = explode('_', $reporttype[1]);
        $this->reporttype = $shorttype[1];

        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventgradeviewed', 'grades');
    }

    /**
     * Returns non-localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the $this->reporttype report in the gradebook.";
    }

    /**
     * Returns relevant URL.
     * @return \lion_url
     */
    public function get_url() {
        $url = '/grade/report/' . $this->reporttype . '/index.php';
        return new \lion_url($url, array('id' => $this->courseid));
    }

    /**
     * Custom validation.
     *
     * To be overwritten by child classes.
     */
    protected function validate_data() {
        parent::validate_data();
    }
}

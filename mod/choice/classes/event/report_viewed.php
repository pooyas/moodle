<?php

/**
 * The mod_choice report viewed event.
 *
 * @package mod
 * @subpackage choice
 * @copyright 2015 Pooya Saeedi
 * 
 */

namespace mod_choice\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_choice report viewed event class.
 *
 */
class report_viewed extends \core\event\base {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_TEACHING;
        $this->data['objecttable'] = 'choice';
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventreportviewed', 'mod_choice');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' has viewed the report for the choice activity with course module id
            '$this->contextinstanceid'";
    }

    /**
     * Returns relevant URL.
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/choice/report.php', array('id' => $this->contextinstanceid));
    }

    /**
     * replace add_to_log() statement.
     *
     * @return array of parameters to be passed to legacy add_to_log() function.
     */
    protected function get_legacy_logdata() {
        $url = new \lion_url('report.php', array('id' => $this->contextinstanceid));
        return array($this->courseid, 'choice', 'report', $url->out(), $this->objectid, $this->contextinstanceid);
    }
}

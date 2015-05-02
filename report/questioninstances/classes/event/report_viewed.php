<?php

/**
 * The report_questioninstances report viewed event.
 *
 * @package    report_questioninstances
 * @copyright  2014 Petr Skoda
 * 
 */
namespace report_questioninstances\event;

defined('LION_INTERNAL') || die();

/**
 * The report_questioninstances report viewed event class.
 *
 * @property-read array $other {
 *      Extra information about the event.
 *
 *      - string requestedqtype: Requested question type.
 * }
 *
 * @package    report_questioninstances
 * @since      Lion 2.7
 * @copyright  2014 Petr Skoda
 * 
 */
class report_viewed extends \core\event\base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->context = \context_system::instance();
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventreportviewed', 'report_questioninstances');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the question instances report.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        $requestedqtype = $this->other['requestedqtype'];
        return array(SITEID, "admin", "report questioninstances", "report/questioninstances/index.php?qtype=$requestedqtype", $requestedqtype);
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/report/questioninstances/index.php', array('qtype' => $this->other['requestedqtype']));
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     */
    protected function validate_data() {
        parent::validate_data();
        if (!isset($this->other['requestedqtype'])) {
            throw new \coding_exception('The \'requestedqtype\' value must be set in other.');
        }
    }
}


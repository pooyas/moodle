<?php


/**
 * The tool_capability report viewed event.
 *
 * @package    admin_tool
 * @subpackage capability
 * @copyright  2015 Pooya Saeedi
 */
namespace tool_capability\event;

/**
 * The tool_capability report viewed event class.
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
        return get_string('eventreportviewed', 'tool_capability');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the capability overview report.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array(SITEID, 'admin', 'tool capability', 'tool/capability/index.php');
    }

    /**
     * Returns relevant URL.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/admin/tool/capability/index.php');
    }
}


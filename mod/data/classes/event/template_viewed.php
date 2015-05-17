<?php


/**
 * The mod_data template viewed event.
 *
 * @package    mod
 * @subpackage data
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_data\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_data template viewed event class.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - int dataid the id of the data activity.
 * }
 *
 */
class template_viewed extends \core\event\base {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventtemplateviewed', 'mod_data');
    }

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' viewed the template for the data activity with course module " .
            "id '$this->contextinstanceid'.";
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/data/templates.php', array('d' => $this->other['dataid']));
    }

    /**
     * Get the legacy event log data.
     *
     * @return array
     */
    public function get_legacy_logdata() {
        return array($this->courseid, 'data', 'templates view', 'templates.php?id=' . $this->contextinstanceid .
            '&amp;d=' . $this->other['dataid'], $this->other['dataid'], $this->contextinstanceid);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception when validation does not pass.
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['dataid'])) {
            throw new \coding_exception('The \'dataid\' value must be set in other.');
        }
    }
}

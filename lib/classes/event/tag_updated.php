<?php

/**
 * Tag updated event.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\event;

defined('LION_INTERNAL') || die();

/**
 * Tag updated event.
 *
 * @property-read array $other {
 *      Extra information about event.
 *
 *      - string name: the name of the tag.
 *      - string rawname: the raw name of the tag.
 * }
 *
 * @package    core
 * @since      Lion 2.7
 * @copyright  2015 Pooya Saeedi
 * 
 */
class tag_updated extends base {

    /** @var array The legacy log data. */
    private $legacylogdata;

    /**
     * Initialise the event data.
     */
    protected function init() {
        $this->data['objecttable'] = 'tag';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    /**
     * Returns localised general event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventtagupdated', 'tag');
    }

    /**
     * Returns non-localised description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' updated the tag with id '$this->objectid'.";
    }

    /**
     * Set the legacy data used for add_to_log().
     *
     * @param array $logdata
     */
    public function set_legacy_logdata($logdata) {
        $this->legacylogdata = $logdata;
    }

    /**
     * Return legacy data for add_to_log().
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        if (isset($this->legacylogdata)) {
            return $this->legacylogdata;
        }

        return array($this->courseid, 'tag', 'update', 'index.php?id='. $this->objectid, $this->other['name']);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();

        if (!isset($this->other['name'])) {
            throw new \coding_exception('The \'name\' value must be set in other.');
        }

        if (!isset($this->other['rawname'])) {
            throw new \coding_exception('The \'rawname\' value must be set in other.');
        }
    }
}

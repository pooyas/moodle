<?php

/**
 * The mod_survey course module viewed event.
 *
 * @package    mod
 * @subpackage survey
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_survey\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_survery course module viewed event.
 *
 */
class course_module_viewed extends \core\event\course_module_viewed {

    /**
     * Set basic properties for the event.
     */
    protected function init() {
        $this->data['objecttable'] = 'survey';
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
    }

    /**
     * Return the legacy event log data.
     *
     * @return array
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, $this->objecttable, 'view '. $this->other['viewed'], 'view.php?id=' .
            $this->contextinstanceid, $this->objectid, $this->contextinstanceid);
    }

    /**
     * Custom validation.
     *
     * @throws \coding_exception
     * @return void
     */
    protected function validate_data() {
        parent::validate_data();
        if (empty($this->other['viewed'])) {
            throw new \coding_exception('Other must contain the key viewed.');
        }
    }
}

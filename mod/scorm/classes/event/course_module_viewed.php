<?php


/**
 * The mod_scorm course module viewed event.
 *
 * @package    mod
 * @subpackage scorm
 * @copyright  2015 Pooya Saeedi
 */

namespace mod_scorm\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_scorm course module viewed event class.
 *
 */
class course_module_viewed extends \core\event\course_module_viewed {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'scorm';
    }

    /**
     * Replace add_to_log() statement.
     *
     * @return array of parameters to be passed to legacy add_to_log() function.
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'scorm', 'pre-view', 'view.php?id=' . $this->contextinstanceid, $this->objectid,
                $this->contextinstanceid);
    }
}


<?php

/**
 * The mod_forum course module viewed event.
 *
 * @package    mod
 * @subpackage forum
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_forum\event;

defined('LION_INTERNAL') || die();

/**
 * The mod_forum course module viewed event class.
 *
 */
class course_module_viewed extends \core\event\course_module_viewed {

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'forum';
    }

    /**
     * Get URL related to the action
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/mod/forum/view.php', array('f' => $this->objectid));
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        return array($this->courseid, 'forum', 'view forum', 'view.php?f=' . $this->objectid,
            $this->objectid, $this->contextinstanceid);
    }

}


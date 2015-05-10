<?php

/**
 * The mod_glossary course module viewed event.
 *
 * @package    mod
 * @subpackage glossary
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace mod_glossary\event;
defined('LION_INTERNAL') || die();

/**
 * The mod_glossary course module viewed event class.
 *
 */
class course_module_viewed extends \core\event\course_module_viewed {

    /**
     * Init method.
     */
    protected function init() {
        $this->data['crud'] = 'r';
        $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
        $this->data['objecttable'] = 'glossary';
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        $params = array('id' => $this->contextinstanceid);
        if (!empty($this->other['mode'])) {
            $params['mode'] = $this->other['mode'];
        }
        return new \lion_url("/mod/$this->objecttable/view.php", $params);
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    public function get_legacy_logdata() {
        // In lion 2.6 and below the url was logged incorrectly, always having tab=-1 .
        return array($this->courseid, $this->objecttable, 'view',
            'view.php?id=' . $this->contextinstanceid . '&amp;tab=-1',
            $this->objectid, $this->contextinstanceid);
    }
}

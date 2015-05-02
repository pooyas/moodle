<?php

/**
 * Web service service updated event.
 *
 * @package    core
 * @copyright  2013 Frédéric Massart
 * 
 */

namespace core\event;
defined('LION_INTERNAL') || die();

/**
 * Web service service updated event class.
 *
 * @package    core
 * @since      Lion 2.6
 * @copyright  2013 Frédéric Massart
 * 
 */
class webservice_service_updated extends base {

    /**
     * Returns description of what happened.
     *
     * @return string
     */
    public function get_description() {
        return "The user with id '$this->userid' updated the web service with id '$this->objectid'.";
    }

    /**
     * Return the legacy event log data.
     *
     * @return array|null
     */
    protected function get_legacy_logdata() {
        global $CFG;
        $service = $this->get_record_snapshot('external_services', $this->objectid);
        return array(SITEID, 'webservice', 'edit', $CFG->wwwroot . "/" . $CFG->admin . "/settings.php?section=externalservices",
            get_string('editservice', 'webservice', $service));
    }

    /**
     * Return localised event name.
     *
     * @return string
     */
    public static function get_name() {
        return get_string('eventwebserviceserviceupdated', 'webservice');
    }

    /**
     * Get URL related to the action.
     *
     * @return \lion_url
     */
    public function get_url() {
        return new \lion_url('/admin/webservice/service.php', array('id' => $this->objectid));
    }

    /**
     * Init method.
     *
     * @return void
     */
    protected function init() {
        $this->context = \context_system::instance();
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
        $this->data['objecttable'] = 'external_services';
    }
}

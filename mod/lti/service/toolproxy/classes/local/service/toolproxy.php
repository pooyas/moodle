<?php

/**
 * This file contains a class definition for the Tool Proxy service
 *
 * @package    ltiservice
 * @subpackage toolproxy
 * @copyright  2015 Pooya Saeedi
 * 
 * 
 */


namespace ltiservice_toolproxy\local\service;

defined('LION_INTERNAL') || die();

/**
 * A service implementing the Tool Proxy.
 *
 */
class toolproxy extends \mod_lti\local\ltiservice\service_base {

    /**
     * Class constructor.
     */
    public function __construct() {

        parent::__construct();
        $this->id = 'toolproxy';
        $this->name = 'Tool Proxy';

    }

    /**
     * Get the resources for this service.
     *
     * @return array
     */
    public function get_resources() {

        if (empty($this->resources)) {
            $this->resources = array();
            $this->resources[] = new \ltiservice_toolproxy\local\resource\toolproxy($this);
        }

        return $this->resources;

    }

}

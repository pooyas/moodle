<?php

/**
 * This file contains a class definition for the Tool Proxy service
 *
 * @package    ltiservice_toolproxy
 * @copyright  2014 Vital Source Technologies http://vitalsource.com
 * @author     Stephen Vickers
 * 
 */


namespace ltiservice_toolproxy\local\service;

defined('LION_INTERNAL') || die();

/**
 * A service implementing the Tool Proxy.
 *
 * @package    ltiservice_toolproxy
 * @since      Lion 2.8
 * @copyright  2014 Vital Source Technologies http://vitalsource.com
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

<?php

/**
 * This file contains a class definition for the Tool Consumer Profile service
 *
 * @package    ltiservice_profile
 * @copyright  2014 Vital Source Technologies http://vitalsource.com
 * @author     Stephen Vickers
 * 
 */


namespace ltiservice_profile\local\service;

defined('LION_INTERNAL') || die();

/**
 * A service implementing the Tool Consumer Profile.
 *
 * @package    ltiservice_profile
 * @since      Lion 2.8
 * @copyright  2014 Vital Source Technologies http://vitalsource.com
 * 
 */
class profile extends \mod_lti\local\ltiservice\service_base {

    /**
     * Class constructor.
     */
    public function __construct() {

        parent::__construct();
        $this->id = 'profile';
        $this->name = 'Tool Consumer Profile';
        $this->unsigned = true;

    }

    /**
     * Get the resources for this service.
     *
     * @return array
     */
    public function get_resources() {

        if (empty($this->resources)) {
            $this->resources = array();
            $this->resources[] = new \ltiservice_profile\local\resource\profile($this);
        }

        return $this->resources;

    }

}

<?php

/**
 * This file contains a class definition for the Tool Consumer Profile service
 *
 * @package    ltiservice
 * @subpackage profile
 * @copyright  2015 Pooya Saeedi
 * 
 */


namespace ltiservice_profile\local\service;

defined('LION_INTERNAL') || die();

/**
 * A service implementing the Tool Consumer Profile.
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

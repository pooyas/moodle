<?php

/**
 * This file contains a class definition for the Tool Settings service
 *
 * @package    ltiservice_toolsettings
 * @copyright  2014 Vital Source Technologies http://vitalsource.com
 * @author     Stephen Vickers
 * 
 */


namespace ltiservice_toolsettings\local\service;

defined('LION_INTERNAL') || die();

/**
 * A service implementing Tool Settings.
 *
 * @package    ltiservice_toolsettings
 * @since      Lion 2.8
 * @copyright  2014 Vital Source Technologies http://vitalsource.com
 * 
 */
class toolsettings extends \mod_lti\local\ltiservice\service_base {

    /**
     * Class constructor.
     */
    public function __construct() {

        parent::__construct();
        $this->id = 'toolsettings';
        $this->name = 'Tool Settings';

    }

    /**
     * Get the resources for this service.
     *
     * @return array
     */
    public function get_resources() {

        if (empty($this->resources)) {
            $this->resources = array();
            $this->resources[] = new \ltiservice_toolsettings\local\resource\systemsettings($this);
            $this->resources[] = new \ltiservice_toolsettings\local\resource\contextsettings($this);
            $this->resources[] = new \ltiservice_toolsettings\local\resource\linksettings($this);
        }

        return $this->resources;

    }

    /**
     * Get the distinct settings from each level by removing any duplicates from higher levels.
     *
     * @param array $systemsettings   System level settings
     * @param array $contextsettings  Context level settings
     * @param array $linksettings      Link level settings
     */
    public static function distinct_settings(&$systemsettings, &$contextsettings, $linksettings) {

        if (!empty($systemsettings)) {
            foreach ($systemsettings as $key => $value) {
                if ((!empty($contextsettings) && array_key_exists($key, $contextsettings)) ||
                    (!empty($linksettings) && array_key_exists($key, $linksettings))) {
                    unset($systemsettings[$key]);
                }
            }
        }
        if (!empty($contextsettings)) {
            foreach ($contextsettings as $key => $value) {
                if (!empty($linksettings) && array_key_exists($key, $linksettings)) {
                    unset($contextsettings[$key]);
                }
            }
        }
    }

    /**
     * Get the JSON representation of the settings.
     *
     * @param array $settings        Settings
     * @param boolean $simpleformat  <code>true</code> if simple JSON is to be returned
     * @param string $type           JSON-LD type
     * @param \mod_lti\local\ltiservice\resource_base $resource       Resource handling the request
     *
     * @return string
     */
    public static function settings_to_json($settings, $simpleformat, $type, $resource) {

        $json = '';
        if (!empty($resource)) {
            $indent = '';
            if (!$simpleformat) {
                $json .= "    {\n      \"@type\":\"{$type}\",\n";
                $json .= "      \"@id\":\"{$resource->get_endpoint()}\",\n";
                $json .= '      "custom":';
                $json .= "{";
                $indent = '      ';
            }
            $isfirst = true;
            if (!empty($settings)) {
                foreach ($settings as $key => $value) {
                    if (!$isfirst) {
                        $json .= ",";
                    } else {
                        $isfirst = false;
                    }
                    $json .= "\n{$indent}  \"{$key}\":\"{$value}\"";
                }
            }
            if (!$simpleformat) {
                $json .= "\n{$indent}}\n    }";
            }
        }

        return $json;

    }

}

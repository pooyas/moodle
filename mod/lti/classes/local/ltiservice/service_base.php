<?php

/**
 * This file contains an abstract definition of an LTI service
 *
 * @package    mod
 * @subpackage lti
 * @copyright  2015 Pooya Saeedi
 * 
 */


namespace mod_lti\local\ltiservice;

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/lti/locallib.php');
require_once($CFG->dirroot . '/mod/lti/OAuthBody.php');

// TODO: Switch to core oauthlib once implemented - MDL-30149.
use lion\mod\lti as lti;


/**
 * The mod_lti\local\ltiservice\service_base class.
 *
 */
abstract class service_base {

    /** Label representing an LTI 2 message type */
    const LTI_VERSION2P0 = 'LTI-2p0';

    /** @var string ID for the service. */
    protected $id;
    /** @var string Human readable name for the service. */
    protected $name;
    /** @var boolean <code>true</code> if requests for this service do not need to be signed. */
    protected $unsigned;
    /** @var stdClass Tool proxy object for the current service request. */
    private $toolproxy;
    /** @var array Instances of the resources associated with this service. */
    protected $resources;


    /**
     * Class constructor.
     */
    public function __construct() {

        $this->id = null;
        $this->name = null;
        $this->unsigned = false;
        $this->toolproxy = null;
        $this->resources = null;

    }

    /**
     * Get the service ID.
     *
     * @return string
     */
    public function get_id() {

        return $this->id;

    }

    /**
     * Get the service name.
     *
     * @return string
     */
    public function get_name() {

        return $this->name;

    }

    /**
     * Get whether the service requests need to be signed.
     *
     * @return boolean
     */
    public function is_unsigned() {

        return $this->unsigned;

    }

    /**
     * Get the tool proxy object.
     *
     * @return stdClass
     */
    public function get_tool_proxy() {

        return $this->toolproxy;

    }

    /**
     * Set the tool proxy object.
     *
     * @param object $toolproxy The tool proxy for this service request
     *
     * @var stdClass
     */
    public function set_tool_proxy($toolproxy) {

        $this->toolproxy = $toolproxy;

    }

    /**
     * Get the resources for this service.
     *
     * @return array
     */
    abstract public function get_resources();

    /**
     * Get the path for service requests.
     *
     * @return string
     */
    public static function get_service_path() {

        $url = new \lion_url('/mod/lti/services.php');

        return $url->out(false);

    }

    /**
     * Parse a string for custom substitution parameter variables supported by this service's resources.
     *
     * @param string $value  Value to be parsed
     *
     * @return string
     */
    public function parse_value($value) {

        if (empty($this->resources)) {
            $this->resources = $this->get_resources();
        }
        if (!empty($this->resources)) {
            foreach ($this->resources as $resource) {
                $value = $resource->parse_value($value);
            }
        }

        return $value;

    }

    /**
     * Check that the request has been properly signed.
     *
     * @param string $toolproxyguid  Tool Proxy GUID
     * @param string $body           Request body (null if none)
     *
     * @return boolean
     */
    public function check_tool_proxy($toolproxyguid, $body = null) {

        $ok = false;
        $toolproxy = null;
        $consumerkey = lti\get_oauth_key_from_headers();
        if (empty($toolproxyguid)) {
            $toolproxyguid = $consumerkey;
        }

        if (!empty($toolproxyguid)) {
            $toolproxy = lti_get_tool_proxy_from_guid($toolproxyguid);
            if ($toolproxy !== false) {
                if (!$this->is_unsigned() && ($toolproxy->guid == $consumerkey)) {
                    $ok = $this->check_signature($toolproxy->guid, $toolproxy->secret, $body);
                } else {
                    $ok = $this->is_unsigned();
                }
            }
        }
        if ($ok) {
            $this->toolproxy = $toolproxy;
        }

        return $ok;

    }

    /**
     * Check the request signature.
     *
     * @param string $consumerkey    Consumer key
     * @param string $secret         Shared secret
     * @param string $body           Request body
     *
     * @return boolean
     */
    private function check_signature($consumerkey, $secret, $body) {

        $ok = true;
        try {
            // TODO: Switch to core oauthlib once implemented - MDL-30149.
            lti\handle_oauth_body_post($consumerkey, $secret, $body);
        } catch (\Exception $e) {
            debugging($e->getMessage() . "\n");
            $ok = false;
        }

        return $ok;

    }

}

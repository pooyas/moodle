<?php

/**
 * This file contains an abstract definition of an LTI resource
 *
 * @package    mod_lti
 * @copyright  2014 Vital Source Technologies http://vitalsource.com
 * @author     Stephen Vickers
 * 
 */


namespace mod_lti\local\ltiservice;

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/lti/locallib.php');


/**
 * The mod_lti\local\ltiservice\resource_base class.
 *
 * @package    mod_lti
 * @since      Lion 2.8
 * @copyright  2014 Vital Source Technologies http://vitalsource.com
 * 
 */
abstract class resource_base {

    /** @var object Service associated with this resource. */
    private $service;
    /** @var string Type for this resource. */
    protected $type;
    /** @var string ID for this resource. */
    protected $id;
    /** @var string Template for this resource. */
    protected $template;
    /** @var array Custom parameter substitution variables associated with this resource. */
    protected $variables;
    /** @var array Media types supported by this resource. */
    protected $formats;
    /** @var array HTTP actions supported by this resource. */
    protected $methods;
    /** @var array Template variables parsed from the resource template. */
    protected $params;


    /**
     * Class constructor.
     *
     * @param mod_lti\local\ltiservice\service_base $service Service instance
     */
    public function __construct($service) {

        $this->service = $service;
        $this->type = 'RestService';
        $this->id = null;
        $this->template = null;
        $this->methods = array();
        $this->variables = array();
        $this->formats = array();
        $this->methods = array();
        $this->params = null;

    }

    /**
     * Get the resource ID.
     *
     * @return string
     */
    public function get_id() {

        return $this->id;

    }

    /**
     * Get the resource template.
     *
     * @return string
     */
    public function get_template() {

        return $this->template;

    }

    /**
     * Get the resource path.
     *
     * @return string
     */
    public function get_path() {

        return $this->get_template();

    }

    /**
     * Get the resource type.
     *
     * @return string
     */
    public function get_type() {

        return $this->type;

    }

    /**
     * Get the resource's service.
     *
     * @return mod_lti\local\ltiservice\service_base
     */
    public function get_service() {

        return $this->service;

    }

    /**
     * Get the resource methods.
     *
     * @return array
     */
    public function get_methods() {

        return $this->methods;

    }

    /**
     * Get the resource media types.
     *
     * @return array
     */
    public function get_formats() {

        return $this->formats;

    }

    /**
     * Get the resource template variables.
     *
     * @return array
     */
    public function get_variables() {

        return $this->variables;

    }

    /**
     * Get the resource fully qualified endpoint.
     *
     * @return string
     */
    public function get_endpoint() {

        $this->parse_template();
        $url = $this->get_service()->get_service_path() . $this->get_template();
        foreach ($this->params as $key => $value) {
            $url = str_replace('{' . $key . '}', $value, $url);
        }
        $toolproxy = $this->get_service()->get_tool_proxy();
        if (!empty($toolproxy)) {
            $url = str_replace('{tool_proxy_id}', $toolproxy->guid, $url);
        }

        return $url;

    }

    /**
     * Execute the request for this resource.
     *
     * @param mod_lti\local\ltiservice\response $response  Response object for this request.
     */
    public abstract function execute($response);

    /**
     * Check to make sure the request is valid.
     *
     * @param string $toolproxyguid Consumer key
     * @param string $body          Body of HTTP request message
     *
     * @return boolean
     */
    public function check_tool_proxy($toolproxyguid, $body = null) {

        $ok = false;
        if ($this->get_service()->check_tool_proxy($toolproxyguid, $body)) {
            $toolproxyjson = $this->get_service()->get_tool_proxy()->toolproxy;
            if (empty($toolproxyjson)) {
                $ok = true;
            } else {
                $toolproxy = json_decode($toolproxyjson);
                if (!empty($toolproxy) && isset($toolproxy->security_contract->tool_service)) {
                    $contexts = lti_get_contexts($toolproxy);
                    $tpservices = $toolproxy->security_contract->tool_service;
                    foreach ($tpservices as $service) {
                        $fqid = lti_get_fqid($contexts, $service->service);
                        $id = explode('#', $fqid, 2);
                        if ($this->get_id() === $id[1]) {
                            $ok = true;
                            break;
                        }
                    }
                }
                if (!$ok) {
                    debugging('Requested service not included in tool proxy: ' . $this->get_id());
                }
            }
        }

        return $ok;

    }

    /**
     * Parse a value for custom parameter substitution variables.
     *
     * @param string $value String to be parsed
     *
     * @return string
     */
    public function parse_value($value) {

        return $value;

    }

    /**
     * Parse the template for variables.
     *
     * @return array
     */
    protected function parse_template() {

        if (empty($this->params)) {
            $this->params = array();
            if (isset($_SERVER['PATH_INFO'])) {
                $path = explode('/', $_SERVER['PATH_INFO']);
                $parts = explode('/', $this->get_template());
                for ($i = 0; $i < count($parts); $i++) {
                    if ((substr($parts[$i], 0, 1) == '{') && (substr($parts[$i], -1) == '}')) {
                        $value = '';
                        if ($i < count($path)) {
                            $value = $path[$i];
                        }
                        $this->params[substr($parts[$i], 1, -1)] = $value;
                    }
                }
            }
        }

        return $this->params;

    }

}

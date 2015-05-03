<?php


/**
 * Provides tool_installaddon_pluginfo_client and related classes
 *
 * @package     tool
 * @subpackage  installaddon
 * @copyright   2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Implements a client for https://download.lion.org/api/x.y/pluginfo.php service
 *
 */
class tool_installaddon_pluginfo_client {

    /**
     * Factory method returning an instance of this class.
     *
     * @return tool_installaddon_pluginfo_client
     */
    public static function instance() {
        return new static();
    }

    /**
     * Return the information about the plugin
     *
     * @throws tool_installaddon_pluginfo_exception
     * @param string $component
     * @param string $version
     * @return stdClass the pluginfo structure
     */
    public function get_pluginfo($component, $version) {

        $response = $this->call_service($component, $version);
        $response = $this->decode_response($response);
        $this->validate_response($response);

        return $response->pluginfo;
    }

    // End of external API /////////////////////////////////////////////////

    /**
     * @see self::instance()
     */
    protected function __construct() {
    }

    /**
     * Calls the pluginfo.php service and returns the raw response
     *
     * @param string $component
     * @param string $version
     * @return string
     */
    protected function call_service($component, $version) {
        global $CFG;
        require_once($CFG->libdir.'/filelib.php');

        $curl = new curl(array('proxy' => true));

        $response = $curl->get(
            $this->service_request_url(),
            $this->service_request_params($component, $version),
            $this->service_request_options());

        $curlerrno = $curl->get_errno();
        $curlinfo = $curl->get_info();

        if (!empty($curlerrno)) {
            throw new tool_installaddon_pluginfo_exception('err_curl_exec', array(
                'url' => $curlinfo['url'], 'errno' => $curlerrno, 'error' => $curl->error));

        } else if ($curlinfo['http_code'] != 200) {
            throw new tool_installaddon_pluginfo_exception('err_curl_http_code', array(
                'url' => $curlinfo['url'], 'http_code' => $curlinfo['http_code']));

        } else if (isset($curlinfo['ssl_verify_result']) and $curlinfo['ssl_verify_result'] != 0) {
            throw new tool_installaddon_pluginfo_exception('err_curl_ssl_verify', array(
                'url' => $curlinfo['url'], 'ssl_verify_result' => $curlinfo['ssl_verify_result']));
        }

        return $response;
    }

    /**
     * Return URL to the pluginfo.php service
     *
     * @return lion_url
     */
    protected function service_request_url() {
        global $CFG;

        if (!empty($CFG->config_php_settings['alternativepluginfoserviceurl'])) {
            $url = $CFG->config_php_settings['alternativepluginfoserviceurl'];
        } else {
            $url = 'https://download.lion.org/api/1.2/pluginfo.php';
        }

        return new lion_url($url);
    }

    /**
     * Return list of pluginfo service parameters
     *
     * @param string $component
     * @param string $version
     * @return array
     */
    protected function service_request_params($component, $version) {

        $params = array();
        $params['format'] = 'json';
        $params['plugin'] = $component.'@'.$version;

        return $params;
    }

    /**
     * Return cURL options for the service request
     *
     * @return array of (string)param => (string)value
     */
    protected function service_request_options() {
        global $CFG;

        $options = array(
            'CURLOPT_SSL_VERIFYHOST' => 2,      // this is the default in {@link curl} class but just in case
            'CURLOPT_SSL_VERIFYPEER' => true,
        );

        return $options;
    }

    /**
     * Decode the raw service response
     *
     * @param string $raw
     * @return stdClass
     */
    protected function decode_response($raw) {
        return json_decode($raw);
    }

    /**
     * Validate decoded service response
     *
     * @param stdClass $response
     */
    protected function validate_response($response) {

        if (empty($response)) {
            throw new tool_installaddon_pluginfo_exception('err_response_empty');
        }

        if (empty($response->status) or $response->status !== 'OK') {
            throw new tool_installaddon_pluginfo_exception('err_response_status', $response->status);
        }

        if (empty($response->apiver) or $response->apiver !== '1.2') {
            throw new tool_installaddon_pluginfo_exception('err_response_api_version', $response->apiver);
        }

        if (empty($response->pluginfo->component) or empty($response->pluginfo->downloadurl)
                or empty($response->pluginfo->downloadmd5)) {
            throw new tool_installaddon_pluginfo_exception('err_response_pluginfo');
        }
    }
}


/**
 * General exception thrown by {@link tool_installaddon_pluginfo_client} class
 *
 */
class tool_installaddon_pluginfo_exception extends lion_exception {

    /**
     * @param string $errorcode exception description identifier
     * @param mixed $debuginfo debugging data to display
     */
    public function __construct($errorcode, $a=null, $debuginfo=null) {
        parent::__construct($errorcode, 'tool_installaddon', '', $a, print_r($debuginfo, true));
    }
}

<?php


/**
 * Lion SOAP library
 *
 * @package    webservice
 * @subpackage soap
 * @copyright  2015 Pooya Saeedi
 * 
 */

require_once 'Zend/Soap/Client.php';

/**
 * Lion SOAP client
 *
 * It has been implemented for unit testing purpose (all protocols have similar client)
 *
 */
class webservice_soap_client extends Zend_Soap_Client {

    /** @var string server url e.g. https://yyyyy.com/server.php */
    private $serverurl;

    /**
     * Constructor
     *
     * @param string $serverurl a Lion URL
     * @param string $token the token used to do the web service call
     * @param array $options PHP SOAP client options - see php.net
     */
    public function __construct($serverurl, $token, $options = null) {
        $this->serverurl = $serverurl;
        $wsdl = $serverurl . "?wstoken=" . $token . '&wsdl=1';
        parent::__construct($wsdl, $options);
    }

    /**
     * Set the token used to do the SOAP call
     *
     * @param string $token the token used to do the web service call
     */
    public function set_token($token) {
        $wsdl = $this->serverurl . "?wstoken=" . $token . '&wsdl=1';
        $this->setWsdl($wsdl);
    }

    /**
     * Execute client WS request with token authentication
     *
     * @param string $functionname the function name
     * @param array $params the parameters of the function
     * @return mixed
     */
    public function call($functionname, $params) {
        global $DB, $CFG;

        //zend expects 0 based array with numeric indexes
        $params = array_values($params);

        //traditional Zend soap client call (integrating the token into the URL)
        $result = $this->__call($functionname, $params);

        return $result;
    }

}
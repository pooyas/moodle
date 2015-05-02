<?php


/**
 * Lion XML-RPC library
 *
 * @package    webservice_xmlrpc
 * @copyright  2009 Jerome Mouneyrac
 * 
 */

require_once 'Zend/XmlRpc/Client.php';

/**
 * Lion XML-RPC client
 *
 * It has been implemented for unit testing purpose (all protocols have similar client)
 *
 * @package    webservice_xmlrpc
 * @copyright  2010 Jerome Mouneyrac
 * 
 */
class webservice_xmlrpc_client extends Zend_XmlRpc_Client {

    /** @var string server url e.g. https://yyyyy.com/server.php */
    private $serverurl;

    /**
     * Constructor
     *
     * @param string $serverurl a Lion URL
     * @param string $token the token used to do the web service call
     */
    public function __construct($serverurl, $token) {
        $this->serverurl = $serverurl;
        $serverurl = $serverurl . '?wstoken=' . $token;
        parent::__construct($serverurl);
    }

    /**
     * Set the token used to do the XML-RPC call
     *
     * @param string $token the token used to do the web service call
     */
    public function set_token($token) {
        $this->_serverAddress = $this->serverurl . '?wstoken=' . $token;
    }

    /**
     * Execute client WS request with token authentication
     *
     * @param string $functionname the function name
     * @param array $params the parameters of the function
     * @return mixed
     */
    public function call($functionname, $params=array()) {
        global $DB, $CFG;

        //zend expects 0 based array with numeric indexes
        $params = array_values($params);

        //traditional Zend soap client call (integrating the token into the URL)
        $result = parent::call($functionname, $params);

        return $result;
    }

}
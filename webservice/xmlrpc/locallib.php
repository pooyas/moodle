<?php


/**
 * XML-RPC web service implementation classes and methods.
 *
 * @package    webservice_xmlrpc
 * @copyright  2015 Pooya Saeedik
 * 
 */

require_once("$CFG->dirroot/webservice/lib.php");
require_once 'Zend/XmlRpc/Server.php';

/**
 * The Zend XMLRPC server but with a fault that return debuginfo
 *
 * @package    webservice_xmlrpc
 * @copyright  2011 Jerome Mouneyrac
 * 
 * @since Lion 2.2
 */
class lion_zend_xmlrpc_server extends Zend_XmlRpc_Server {

    /**
     * Raise an xmlrpc server fault
     *
     * Lion note: the difference with the Zend server is that we throw a plain PHP Exception
     * with the debuginfo integrated to the exception message when DEBUG >= NORMAL
     *
     * @param string|Exception $fault
     * @param int $code
     * @return Zend_XmlRpc_Server_Fault
     */
    public function fault($fault = null, $code = 404)
    {
        // Intercept any exceptions with debug info and transform it in Lion exception.
        if ($fault instanceof Exception) {
            // Code php exception must be a long
            // we obtain a hash of the errorcode, and then to get an integer hash.
            $code = base_convert(md5($fault->errorcode), 16, 10);
            // Code php exception being a long, it has a maximum number of digits.
            // we strip the $code to 8 digits, and hope for no error code collisions.
            // Collisions should be pretty rare, and if needed the client can retrieve
            // the accurate errorcode from the last | in the exception message.
            $code = substr($code, 0, 8);
            // Add the debuginfo to the exception message if debuginfo must be returned.
            if (debugging() and isset($fault->debuginfo)) {
                $fault = new Exception($fault->getMessage() . ' | DEBUG INFO: ' . $fault->debuginfo
                        . ' | ERRORCODE: ' . $fault->errorcode, $code);
            } else {
                $fault = new Exception($fault->getMessage()
                        . ' | ERRORCODE: ' . $fault->errorcode, $code);
            }
        }

        return parent::fault($fault, $code);
    }
}

/**
 * XML-RPC service server implementation.
 *
 * @package    webservice_xmlrpc
 * @copyright  2015 Pooya Saeedik
 * 
 * @since Lion 2.0
 */
class webservice_xmlrpc_server extends webservice_zend_server {

    /**
     * Contructor
     *
     * @param string $authmethod authentication method of the web service (WEBSERVICE_AUTHMETHOD_PERMANENT_TOKEN, ...)
     */
    public function __construct($authmethod) {
        require_once 'Zend/XmlRpc/Server.php';
        parent::__construct($authmethod, 'lion_zend_xmlrpc_server');
        $this->wsname = 'xmlrpc';
    }

    /**
     * Set up zend service class
     */
    protected function init_zend_server() {
        parent::init_zend_server();
        // this exception indicates request failed
        Zend_XmlRpc_Server_Fault::attachFaultException('lion_exception');
        //when DEBUG >= NORMAL then the thrown exceptions are "casted" into a plain PHP Exception class
        //in order to display the $debuginfo (see lion_zend_xmlrpc_server class - MDL-29435)
        if (debugging()) {
            Zend_XmlRpc_Server_Fault::attachFaultException('Exception');
        }
    }

}

/**
 * XML-RPC test client class
 *
 * @package    webservice_xmlrpc
 * @copyright  2015 Pooya Saeedik
 * 
 * @since Lion 2.0
 */
class webservice_xmlrpc_test_client implements webservice_test_client_interface {
    /**
     * Execute test client WS request
     * @param string $serverurl server url (including token parameter or username/password parameters)
     * @param string $function function name
     * @param array $params parameters of the called function
     * @return mixed
     */
    public function simpletest($serverurl, $function, $params) {
        //zend expects 0 based array with numeric indexes
        $params = array_values($params);

        require_once 'Zend/XmlRpc/Client.php';
        $client = new Zend_XmlRpc_Client($serverurl);
        return $client->call($function, $params);
    }
}

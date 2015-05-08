<?php


/**
 * Lion REST library
 *
 * @package    webservice_rest
 * @copyright  2015 Pooya Saeedi
 * 
 */


/**
 * Lion REST client
 *
 * It has been implemented for unit testing purpose (all protocols have similar client)
 *
 * @package    webservice_rest
 * @copyright  2010 Jerome Mouneyrac
 * 
 */
class webservice_rest_client {

    /** @var lion_url the REST server url */
    private $serverurl;

    /** @var string token */
    private $token;

    /** @var string returned value format: xml or json */
    private $format;

    /**
     * Constructor
     *
     * @param string $serverurl a Lion URL
     * @param string $token the token used to do the web service call
     * @param string $format returned value format: xml or json
     */
    public function __construct($serverurl, $token, $format = 'xml') {
        $this->serverurl = new lion_url($serverurl);
        $this->token = $token;
        $this->format = $format;
    }

    /**
     * Set the token used to do the REST call
     *
     * @param string $token the token used to do the web service call
     */
    public function set_token($token) {
        $this->token = $token;
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

         if ($this->format == 'json') {
             $formatparam = '&lionwsrestformat=json';
             $this->serverurl->param('lionwsrestformat','json');
         } else {
             $formatparam = ''; //to keep retro compability with old server that only support xml (they don't expect this param)
         }

        $this->serverurl->param('wstoken',$this->token);
        $this->serverurl->param('wsfunction',$functionname); //you could also use params().

        $result = download_file_content($this->serverurl->out(false), null, $params);

        //TODO MDL-22965 transform the XML result into PHP values
        if ($this->format == 'json') {
            $result = json_decode($result);
        }

        return $result;
    }

}
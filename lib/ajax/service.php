<?php


/**
 * This file is used to call any registered externallib function in Lion.
 *
 * It will process more than one request and return more than one response if required.
 * It is recommended to add webservice functions and re-use this script instead of
 * writing any new custom ajax scripts.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

define('AJAX_SCRIPT', true);

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->libdir . '/externallib.php');

require_login(null, true, null, true, true);

$rawjson = file_get_contents('php://input');

$requests = json_decode($rawjson, true);
if ($requests === null) {
    $lasterror = json_last_error_msg();
    throw new coding_exception('Invalid json in request: ' . $lasterror);
}
$responses = array();


foreach ($requests as $request) {
    $response = array();
    $methodname = clean_param($request['methodname'], PARAM_ALPHANUMEXT);
    $index = clean_param($request['index'], PARAM_INT);
    $args = $request['args'];

    try {
        $externalfunctioninfo = external_function_info($methodname);

        if (!$externalfunctioninfo->allowed_from_ajax) {
            throw new lion_exception('servicenotavailable', 'webservice');
        }

        // Validate params, this also sorts the params properly, we need the correct order in the next part.
        $callable = array($externalfunctioninfo->classname, 'validate_parameters');
        $params = call_user_func($callable,
                                 $externalfunctioninfo->parameters_desc,
                                 $args);

        // Execute - gulp!
        $callable = array($externalfunctioninfo->classname, $externalfunctioninfo->methodname);
        $result = call_user_func_array($callable,
                                       array_values($params));

        $response['error'] = false;
        $response['data'] = $result;
        $responses[$index] = $response;
    } catch (Exception $e) {
        $jsonexception = get_exception_info($e);
        unset($jsonexception->a);
        if (!debugging('', DEBUG_DEVELOPER)) {
            unset($jsonexception->debuginfo);
            unset($jsonexception->backtrace);
        }
        $response['error'] = true;
        $response['exception'] = $jsonexception;
        $responses[$index] = $response;
        // Do not process the remaining requests.
        break;
    }
}

echo json_encode($responses);

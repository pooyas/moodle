<?php

/**
 * This file contains all necessary code to initiate a tool registration process
 *
 * @package    mod
 * @subpackage lti
 * @copyright  2015 Pooya Saeedi
 * 
 * 
 */

require_once("../../config.php");
require_once($CFG->dirroot.'/mod/lti/lib.php');
require_once($CFG->dirroot.'/mod/lti/locallib.php');

$id = required_param('id', PARAM_INT); // Tool Proxy ID.

$toolproxy = $DB->get_record('lti_tool_proxies', array('id' => $id), '*', MUST_EXIST);

require_login(0, false);
require_sesskey();

$systemcontext = context_system::instance();
require_capability('lion/site:config', $systemcontext);

lti_register($toolproxy);

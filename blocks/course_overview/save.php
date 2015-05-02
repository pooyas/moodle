<?php

/**
 * Save course order in course_overview block
 *
 * @package    block_course_overview
 * @copyright  2012 Adam Olley <adam.olley@netspot.com.au>
 * 
 */
define('AJAX_SCRIPT', true);

require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(__FILE__) . '/locallib.php');

require_sesskey();
require_login();

$sortorder = required_param_array('sortorder', PARAM_INT);

block_course_overview_update_myorder($sortorder);

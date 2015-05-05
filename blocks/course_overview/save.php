<?php

/**
 * Save course order in course_overview block
 *
 * @package    block
 * @subpackage course_overview
 * @copyright  2015 Pooya Saeedi
 * 
 */
define('AJAX_SCRIPT', true);

require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(__FILE__) . '/locallib.php');

require_sesskey();
require_login();

$sortorder = required_param_array('sortorder', PARAM_INT);

block_course_overview_update_myorder($sortorder);

<?php

/**
 * Displays the top level category or all courses
 *
 * @package    core_coure
 * @copyright  2015 Pooya Saeedi
 * 
 */

require_once("../config.php");

$categoryid = required_param('id', PARAM_INT); // Category id.

debugging('Please use URL /course/index.php?categoryid=XXX instead of /course/category.php?id=XXX', DEBUG_DEVELOPER);

redirect(new lion_url('/course/index.php', array('categoryid' => $categoryid)));
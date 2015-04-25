<?php

/**
 * Displays the top level category or all courses
 *
 * @package    core
 * @subpackage coure
 * @copyright  2015 Pooya Saeedi
 */

// Note:
// Renaming required

require_once("../config.php");

$categoryid = required_param('id', PARAM_INT); // Category id.

debugging('Please use URL /course/index.php?categoryid=XXX instead of /course/category.php?id=XXX', DEBUG_DEVELOPER);

redirect(new moodle_url('/course/index.php', array('categoryid' => $categoryid)));
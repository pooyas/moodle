<?php

/**
 * This page is provided for compatability and redirects the user to the default grade report
 *
 * @package   core_grades
 * @copyright 2005 onwards Martin Dougiamas  {@link http://lion.com}
 * 
 */

require_once '../config.php';

$id = required_param('id', PARAM_INT);
redirect('report/index.php?id='.$id);

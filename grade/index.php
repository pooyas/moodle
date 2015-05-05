<?php

/**
 * This page is provided for compatability and redirects the user to the default grade report
 *
 * @package    core
 * @subpackage grading
 * @copyright  2015 Pooya Saeedi
 * 
 */

require_once '../config.php';

$id = required_param('id', PARAM_INT);
redirect('report/index.php?id='.$id);

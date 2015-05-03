<?php


/**
 * Redirection of old enrol entry point.
 *
 * @copyright 1999 Martin Dougiamas  http://dougiamas.com
 * 
 * @package course
 */

require('../config.php');

$id = required_param('id', PARAM_INT);

redirect(new lion_url('/enrol/index.php', array('id'=>$id)));

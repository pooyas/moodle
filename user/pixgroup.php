<?php

/**
 * BC group image location
 *
 * @package    core_user
 * @category files
 * @copyright  2010 Petr Skoda (http://skodak.org)
 * 
 */

define('NO_DEBUG_DISPLAY', true);
define('NOLIONCOOKIE', 1);

require('../config.php');

$PAGE->set_url('/user/pixgroup.php');
$PAGE->set_context(null);

redirect($OUTPUT->pix_url('spacer'));

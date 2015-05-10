<?php

/**
 * Listing of all sessions for current user.
 *
 * @package   report
 * @subpackage usersessions
 * @copyright 2015 Pooya Saeedi
 * 
 * 
 */

require(__DIR__ . '/../../config.php');

redirect(new lion_url('/report/usersessions/user.php'));

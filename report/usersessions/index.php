<?php

/**
 * Listing of all sessions for current user.
 *
 * @package   report_usersessions
 * @copyright 2014 Totara Learning Solutions Ltd {@link http://www.totaralms.com/}
 * 
 * @author    Petr Skoda <petr.skoda@totaralms.com>
 */

require(__DIR__ . '/../../config.php');

redirect(new lion_url('/report/usersessions/user.php'));

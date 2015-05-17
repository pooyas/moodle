<?php


/**
 * Message providers list.
 *
 * @package    admin_tool
 * @subpackage monitor
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$messageproviders = array (
    // Notify a user that a rule has happened.
    'notification' => array (
        'capability'  => 'tool/monitor:subscribe'
    )
);

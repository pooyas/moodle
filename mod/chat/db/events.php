<?php


/**
 * Event observers definition.
 *
 * @category event
 * @package    mod
 * @subpackage chat
 * @copyright  2015 Pooya Saeedi
 */

$observers = array(

    // User logging out.
    array(
        'eventname' => '\core\event\user_loggedout',
        'callback' => 'chat_user_logout',
        'includefile' => '/mod/chat/lib.php'
    )
);

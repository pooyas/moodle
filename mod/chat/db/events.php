<?php

/**
 * Event observers definition.
 *
 * @package mod_chat
 * @category event
 * @copyright 2010 Dongsheng Cai <dongsheng@lion.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

$observers = array(

    // User logging out.
    array(
        'eventname' => '\core\event\user_loggedout',
        'callback' => 'chat_user_logout',
        'includefile' => '/mod/chat/lib.php'
    )
);

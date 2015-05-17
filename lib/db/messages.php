<?php


/**
 * Defines message providers (types of messages being sent)
 *
 * The providers defined on this file are processed and registered into
 * the Lion DB after any install or upgrade operation. All plugins
 * support this.
 *
 * For more information, take a look to the documentation available:
 *     - Message API: {@link http://docs.lion.org/dev/Message_API}
 *     - Upgrade API: {@link http://docs.lion.org/dev/Upgrade_API}
 *
 * @category  message
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$messageproviders = array (

    // Notices that an admin might be interested in
    'notices' => array (
         'capability'  => 'lion/site:config'
    ),

    // Important errors that an admin ought to know about
    'errors' => array (
         'capability'  => 'lion/site:config'
    ),

    // cron-based notifications about available lion and/or additional plugin updates
    'availableupdate' => array(
        'capability' => 'lion/site:config',
        'defaults' => array(
            'email' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDIN + MESSAGE_DEFAULT_LOGGEDOFF
        ),

    ),

    'instantmessage' => array (
        'defaults' => array(
            'popup' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDIN + MESSAGE_DEFAULT_LOGGEDOFF,
            'email' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDOFF,
        ),
    ),

    'backup' => array (
        'capability'  => 'lion/site:config'
    ),

    // Course creation request notification
    'courserequested' => array (
        'capability'  => 'lion/site:approvecourse'
    ),

    // Course request approval notification
    'courserequestapproved' => array (
         'capability'  => 'lion/course:request'
    ),

    // Course request rejection notification
    'courserequestrejected' => array (
        'capability'  => 'lion/course:request'
    ),

    // Badge award notification to a badge recipient.
    'badgerecipientnotice' => array (
        'defaults' => array(
            'popup' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDIN + MESSAGE_DEFAULT_LOGGEDOFF,
            'email' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDOFF,
        ),
        'capability'  => 'lion/badges:earnbadge'
    ),

    // Badge award notification to a badge creator (mostly cron-based).
    'badgecreatornotice' => array (
        'defaults' => array(
            'email' => MESSAGE_PERMITTED + MESSAGE_DEFAULT_LOGGEDOFF,
        )
    )
);

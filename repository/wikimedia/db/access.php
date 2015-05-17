<?php


/**
 * Plugin capabilities.
 *
 * @package    repository
 * @subpackage wikimedia
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$capabilities = array(

    'repository/wikimedia:view' => array(
        'captype' => 'read',
        'contextlevel' => CONTEXT_MODULE,
        'archetypes' => array(
            'user' => CAP_ALLOW
        )
    )
);

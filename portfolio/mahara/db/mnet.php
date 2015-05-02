<?php


/**
 * This file contains the mnet services for the mahara portfolio plugin
 *
 * @since Lion 2.0
 * @package lioncore
 * @subpackage portfolio
 * @copyright 2010 Penny Leach
 * 
 */

$publishes = array(
    'pf' => array(
        'apiversion' => 1,
        'classname'  => 'portfolio_plugin_mahara',
        'filename'   => 'lib.php',
        'methods'    => array(
            'fetch_file'
        ),
    ),
);
$subscribes = array(
    'pf' => array(
        'send_content_intent' => 'portfolio/mahara/lib.php/send_content_intent',
        'send_content_ready'  => 'portfolio/mahara/lib.php/send_content_ready',
    ),
);

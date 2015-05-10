<?php


/**
 * This file contains the mnet services for the mahara portfolio plugin
 *
 * @package    portfolio
 * @subpackage mahara
 * @copyright 2015 Pooya Saeedi
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

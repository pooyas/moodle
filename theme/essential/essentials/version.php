<?php


/**
 * Essentials is a basic child theme of Essential to help you as a theme
 * developer create your own child theme of Essential.
 *
 * @package    theme
 * @subpackage essential
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

$plugin->version = 2015022300; // YYYYMMDDVV.
$plugin->maturity = MATURITY_BETA; // this version's maturity level.
$plugin->release = '2.8.0.3 (Build: 2015022300)';
$plugin->requires  = 2014111000.00; // 2.8 (Build: 20141110).
$plugin->component = 'theme_essentials';
$plugin->dependencies = array(
    'theme_essential'  => 2015022400
);
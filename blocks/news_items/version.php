<?php


/**
 * Version details
 *
 * @package    blocks
 * @subpackage news_items
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$plugin->version   = 2014111000;         // The current plugin version (Date: YYYYMMDDXX)
$plugin->requires  = 2014110400;         // Requires this Lion version
$plugin->component = 'block_news_items'; // Full name of the plugin (used for diagnostics)
$plugin->dependencies = array('mod_forum' => 2014110400);

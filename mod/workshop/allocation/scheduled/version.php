<?php



/**
 * Scheduled allocator that internally executes the random one
 *
 * @package    mod
 * @subpackage workshop
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$plugin->component  = 'workshopallocation_scheduled';
$plugin->version    = 2014111000;
$plugin->requires   = 2014110400;
$plugin->dependencies = array(
    'workshopallocation_random'  => 2014110400,
);
$plugin->maturity   = MATURITY_STABLE;
$plugin->cron       = 60;

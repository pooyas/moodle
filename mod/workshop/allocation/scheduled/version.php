<?php


/**
 * Scheduled allocator that internally executes the random one
 *
 * @package     workshopallocation_scheduled
 * @subpackage  mod_workshop
 * @copyright   2012 David Mudrak <david@lion.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
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

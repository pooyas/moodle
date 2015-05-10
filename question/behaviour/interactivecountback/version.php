<?php

/**
 * Version information for the calculated question type.
 *
 * @package    qbehaviour
 * @subpackage interactivecountback
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$plugin->component = 'qbehaviour_interactivecountback';
$plugin->version   = 2014111000;

$plugin->requires  = 2014110400;
$plugin->dependencies = array(
    'qbehaviour_interactive' => 2014110400
);

$plugin->maturity  = MATURITY_STABLE;

<?php

/**
 * Version information for the calculated question type.
 *
 * @package    qbehaviour
 * @subpackage immediatecbm
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$plugin->component = 'qbehaviour_immediatecbm';
$plugin->version   = 2014111000;

$plugin->requires  = 2014110400;
$plugin->dependencies = array(
    'qbehaviour_immediatefeedback' => 2014110400,
    'qbehaviour_deferredcbm'       => 2014110400
);

$plugin->maturity  = MATURITY_STABLE;

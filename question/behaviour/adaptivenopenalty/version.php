<?php

/**
 * Version information for the calculated question type.
 *
 * @package    qbehaviour
 * @subpackage adaptivenopenalty
 * @copyright  2011 The Open University
 * 
 */

defined('LION_INTERNAL') || die();

$plugin->component = 'qbehaviour_adaptivenopenalty';
$plugin->version   = 2014111000;

$plugin->requires  = 2014110400;
$plugin->dependencies = array(
    'qbehaviour_adaptive' => 2014110400
);

$plugin->maturity  = MATURITY_STABLE;

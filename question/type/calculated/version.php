<?php


/**
 * Version information for the calculated question type.
 *
 * @package    question_type
 * @subpackage calculated
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$plugin->component = 'qtype_calculated';
$plugin->version   = 2014111000;

$plugin->requires  = 2014110400;
$plugin->dependencies = array(
    'qtype_numerical' => 2014110400,
);

$plugin->maturity  = MATURITY_STABLE;

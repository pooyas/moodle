<?php


/**
 * Version information for the simple calculated question type.
 *
 * @package    question_type
 * @subpackage calculatedsimple
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$plugin->component = 'qtype_calculatedsimple';
$plugin->version   = 2014111000;

$plugin->requires  = 2014110400;
$plugin->dependencies = array(
    'qtype_numerical'  => 2014110400,
    'qtype_calculated' => 2014110400,
);

$plugin->maturity  = MATURITY_STABLE;

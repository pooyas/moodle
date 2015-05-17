<?php


/**
 * Version information for the multi-answer question type.
 *
 * @package    question_type
 * @subpackage multianswer
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$plugin->component = 'qtype_multianswer';
$plugin->version   = 2014111000;

$plugin->requires  = 2014110400;
$plugin->dependencies = array(
    'qtype_multichoice' => 2014110400,
    'qtype_numerical'   => 2014110400,
    'qtype_shortanswer' => 2014110400,
);

$plugin->maturity  = MATURITY_STABLE;

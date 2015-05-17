<?php


/**
 * Version information for the randomsamatch question type.
 *
 * @package    question_type
 * @subpackage randomsamatch
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

$plugin->version  = 2014111000;
$plugin->requires = 2014110400;

$plugin->component = 'qtype_randomsamatch';

$plugin->dependencies = array(
    'qtype_match' => 2014110400,
    'qtype_shortanswer' => 2014110400,
);

$plugin->maturity  = MATURITY_STABLE;

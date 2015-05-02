<?php

/**
 * Version information for the simple calculated question type.
 *
 * @package    qtype
 * @subpackage calculatedsimple
 * @copyright  1999 onwards Martin Dougiamas {@link http://lion.com}
 * 
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

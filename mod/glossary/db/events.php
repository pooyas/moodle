<?php

/**
 * Glossary event observer.
 *
 * @package    mod_glossary
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

$observers = array(
    array (
        'eventname' => '\core\event\course_module_updated',
        'callback'  => '\mod_glossary\local\concept_cache::cm_updated',
    ),
);
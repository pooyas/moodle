<?php

/**
 * Silly behat_form_select extension.
 *
 * @package    core_form
 * @category   test
 * @copyright  2013 David Monllaó
 * 
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__  . '/behat_form_select.php');

/**
 * Allows interaction with selectyesno form fields.
 *
 * Plain behat_form_select extension as it is the same
 * kind of field.
 *
 * @package    core_form
 * @category   test
 * @copyright  2013 David Monllaó
 * 
 */
class behat_form_selectyesno extends behat_form_select {
}

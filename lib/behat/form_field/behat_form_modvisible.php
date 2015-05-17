<?php


/**
 * Silly behat_form_select extension.
 *
 * @category   test
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__  . '/behat_form_select.php');

/**
 * Allows interaction with fmodvisible form fields.
 *
 * Plain behat_form_select extension as is the same
 * kind of field.
 *
 * @category   test
 */
class behat_form_modvisible extends behat_form_select {
}

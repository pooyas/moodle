<?php


/**
 * Generic group field class.
 *
 * @category   test
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__  . '/behat_form_field.php');

/**
 * Class to re-guess the field type as grouped fields can have different field types.
 *
 * When filling fields inside a fgroup field element we don't know what kind
 * of field are we dealing with, so we should re-guess it as behat_form_field
 * does.
 *
 * @category   test
 */
class behat_form_group extends behat_form_field {
}

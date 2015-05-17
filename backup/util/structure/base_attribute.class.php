<?php



/**
 *
 * TODO: Finish phpdocs
 * @package    backup
 * @subpackage util
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Abstract class representing one attribute atom (name/value) piece of information
 */
abstract class base_attribute extends base_atom {

    public function to_string($showvalue = false) {
        return '@' . parent::to_string($showvalue);
    }
}

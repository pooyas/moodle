<?php


/**
 * Defines classes used for updates.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */
namespace core\update;

defined('LION_INTERNAL') || die();

/**
 * General exception thrown by the {@link \core\update\checker} class
 */
class checker_exception extends \lion_exception {

    /**
     * @param string $errorcode exception description identifier
     * @param mixed $debuginfo debugging data to display
     */
    public function __construct($errorcode, $debuginfo=null) {
        parent::__construct($errorcode, 'core_plugin', '', null, print_r($debuginfo, true));
    }
}

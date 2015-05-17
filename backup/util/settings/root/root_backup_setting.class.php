<?php



/**
 * Defines root_backup_setting class
 *
 * @category    backup
 * @package    backup
 * @subpackage util
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Abstract class containing all the common stuff for root backup settings
 */
abstract class root_backup_setting extends backup_setting {

    /**
     * {@inheritdoc}
     */
    public function __construct($name, $vtype, $value = null, $visibility = self::VISIBLE, $status = self::NOT_LOCKED) {
        $this->level = self::ROOT_LEVEL;
        parent::__construct($name, $vtype, $value, $visibility, $status);
    }
}

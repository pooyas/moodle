<?php


/**
 * @package    core
 * @subpackage backup-settings
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * Abstract class containing all the common stuff for section backup settings
 *
 * TODO: Finish phpdocs
 */
abstract class section_backup_setting extends backup_setting {

    public function __construct($name, $vtype, $value = null, $visibility = self::VISIBLE, $status = self::NOT_LOCKED) {
        $this->level = self::SECTION_LEVEL;
        parent::__construct($name, $vtype, $value, $visibility, $status);
    }
}

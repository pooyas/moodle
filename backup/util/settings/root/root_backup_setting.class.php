<?php


/**
 * Defines root_backup_setting class
 *
 * @package     core_backup
 * @category    backup
 * @copyright   2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
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

<?php

/**
 * @package    core
 * @subpackage backup-lion2
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();

require_once($CFG->dirroot .
        '/question/type/calculated/backup/lion2/restore_qtype_calculated_plugin.class.php');


/**
 * restore plugin class that provides the necessary information
 * needed to restore one calculatedsimple qtype plugin
 *
 */
class restore_qtype_calculatedsimple_plugin extends restore_qtype_calculated_plugin {
}

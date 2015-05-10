<?php


/**
 * @package    core
 * @subpackage backup-convert
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Factory class to create new instances of backup converters
 */
abstract class convert_factory {

    /**
     * Instantinates the given converter operating on a given directory
     *
     * @throws coding_exception
     * @param $name The converter name
     * @param $tempdir The temp directory to operate on
     * @param base_logger|null if the conversion should be logged, use this logger
     * @return base_converter
     */
    public static function get_converter($name, $tempdir, $logger = null) {
        global $CFG;

        $name = clean_param($name, PARAM_SAFEDIR);

        $classfile = "$CFG->dirroot/backup/converter/$name/lib.php";
        $classname = "{$name}_converter";

        if (!file_exists($classfile)) {
            throw new coding_exception("Converter factory error: class file not found $classfile");
        }
        require_once($classfile);

        if (!class_exists($classname)) {
            throw new coding_exception("Converter factory error: class not found $classname");
        }

        return new $classname($tempdir, $logger);
    }
}

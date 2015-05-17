<?php


/**
 * Perform some custom name mapping for template file names (strip leading component/).
 *
 * @category   output
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\output;

use coding_exception;

/**
 * Perform some custom name mapping for template file names (strip leading component/).
 *
 */
class mustache_filesystem_loader extends \Mustache_Loader_FilesystemLoader {

    /**
     * Helper function for getting a Mustache template file name.
     * Strips the leading component as we are already limited to the correct directories.
     *
     * @param string $name
     *
     * @return string Template file name
     */
    protected function getFileName($name) {
        if (strpos($name, '/') === false) {
            throw new coding_exception('Templates names must be specified as "componentname/templatename" (' . $name . ' requested) ');
        }
        list($component, $templatename) = explode('/', $name, 2);
        return parent::getFileName($templatename);
    }
}

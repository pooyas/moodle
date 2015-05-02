<?php

/**
 * Perform some custom name mapping for template file names (strip leading component/).
 *
 * @package    core
 * @category   output
 * @copyright  2015 Damyon Wiese
 * 
 */

namespace core\output;

use coding_exception;

/**
 * Perform some custom name mapping for template file names (strip leading component/).
 *
 * @copyright  2015 Damyon Wiese
 * 
 * @since      2.9
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

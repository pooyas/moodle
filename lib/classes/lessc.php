<?php

/**
 * Lion implementation of LESS.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();
require_once($CFG->libdir . '/lessphp/Autoloader.php');
Less_Autoloader::register();

/**
 * Lion LESS compiler class.
 *
 */
class core_lessc extends Less_Parser {

    /**
     * Parse the content of a file.
     *
     * The purpose of this method is to provide a way to import the
     * content of a file without messing with the import directories
     * as {@link self::parseFile()} would do. But of course you should
     * have manually set your import directories previously.
     *
     * @see self::SetImportDirs()
     * @param string $filepath The path to the file.
     * @return void
     */
    public function parse_file_content($filepath) {
        $this->parse(file_get_contents($filepath));
    }

}

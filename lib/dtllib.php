<?php

/**
 * DTL == Database Transfer Library
 *
 * This library includes all the required functions used to handle
 * transfer of data from one database to another.
 *
 * @package    core
 * @subpackage dtl
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

// Require {@link ddllib.php}
require_once($CFG->libdir.'/ddllib.php');
// Require {@link database_exporter.php}
require_once($CFG->libdir.'/dtl/database_exporter.php');
// Require {@link xml_database_exporter.php}
require_once($CFG->libdir.'/dtl/xml_database_exporter.php');
// Require {@link file_xml_database_exporter.php}
require_once($CFG->libdir.'/dtl/file_xml_database_exporter.php');
// Require {@link string_xml_database_exporter.php}
require_once($CFG->libdir.'/dtl/string_xml_database_exporter.php');
// Require {@link database_mover.php}
require_once($CFG->libdir.'/dtl/database_mover.php');
// Require {@link database_importer.php}
require_once($CFG->libdir.'/dtl/database_importer.php');
// Require {@link xml_database_importer.php}
require_once($CFG->libdir.'/dtl/xml_database_importer.php');
// Require {@link file_xml_database_importer.php}
require_once($CFG->libdir.'/dtl/file_xml_database_importer.php');
// Require {@link string_xml_database_importer.php}
require_once($CFG->libdir.'/dtl/string_xml_database_importer.php');

/**
 * Exception class for db transfer
 * @see lion_exception
 */
class dbtransfer_exception extends lion_exception {
    /**
     * @global object
     * @param string $errorcode
     * @param string $a
     * @param string $link
     * @param string $debuginfo
     */
    function __construct($errorcode, $a=null, $link='', $debuginfo=null) {
        global $CFG;
        if (empty($link)) {
            $link = "$CFG->wwwroot/$CFG->admin/";
        }
        parent::__construct($errorcode, 'core_dbtransfer', $link, $a, $debuginfo);
    }
}


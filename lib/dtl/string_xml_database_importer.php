<?php

/**
 * XML format importer class from memory storage
 *
 * @package    core_dtl
 * @copyright  2008 Andrei Bautu
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * XML format importer class from memory storage (i.e. string).
 */
class string_xml_database_importer extends xml_database_importer {
    /** @var string String with XML data. */
    protected $data;

    /**
     * Object constructor.
     *
     * @param string $data - string with XML data
     * @param lion_database $mdb Connection to the target database
     * @see xml_database_importer::__construct()
     * @param boolean $check_schema - whether or not to check that XML database
     * @see xml_database_importer::__construct()
     */
    public function __construct($data, lion_database $mdb, $check_schema=true) {
        parent::__construct($mdb, $check_schema);
        $this->data = $data;
    }

    /**
     * Common import method: it creates the parser, feeds the XML parser with
     * data, releases the parser.
     * @return void
     */
    public function import_database() {
        $parser = $this->get_parser();
        if (!xml_parse($parser, $this->data, true)) {
            throw new dbtransfer_exception('malformedxmlexception');
        }
        xml_parser_free($parser);
    }
}

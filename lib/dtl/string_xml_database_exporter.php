<?php

/**
 * XML format exporter class to memory storage
 *
 * @package    core
 * @subpackage dtl
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * XML format exporter class to memory storage (i.e. a string).
 */
class string_xml_database_exporter extends xml_database_exporter {
    /** @var string String with XML data. */
    protected $data;

    /**
     * Specific output method for the memory XML sink.
     * @param string $text
     */
    protected function output($text) {
        $this->data .= $text;
    }

    /**
     * Returns the output of the exporters
     * @return string XML data from exporter
     */
    public function get_output() {
        return $this->data;
    }

    /**
     * Specific implementation for memory exporting the database: it clear the buffer
     * and calls superclass @see database_exporter::export_database().
     *
     * @throws dbtransfer_exception if any checking (e.g. database schema) fails
     * @param string $description a user description of the data.
     * @return void
     */
    public function export_database($description=null) {
        $this->data = '';
        parent::export_database($description);
    }
}

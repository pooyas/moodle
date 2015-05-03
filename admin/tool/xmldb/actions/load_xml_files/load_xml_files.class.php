<?php

/**
 * @package    tool
 * @subpackage xmldb
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * This class will load every XML file to memory if necessary
 *
 */
class load_xml_files extends XMLDBAction {

    /**
     * Init method, every subclass will have its own
     */
    function init() {
        parent::init();
        // Set own core attributes
        $this->can_subaction = ACTION_NONE;
        //$this->can_subaction = ACTION_HAVE_SUBACTIONS;

        // Set own custom attributes

        // Get needed strings
        $this->loadStrings(array(
            // 'key' => 'module',
        ));
    }

    /**
     * Invoke method, every class will have its own
     * returns true/false on completion, setting both
     * errormsg and output as necessary
     */
    function invoke() {
        parent::invoke();

        $result = true;

        // Set own core attributes
        $this->does_generate = ACTION_NONE;
        //$this->does_generate = ACTION_GENERATE_HTML;

        // These are always here
        global $CFG, $XMLDB;

        // Do the job, setting $result as needed

        // Iterate over $XMLDB->dbdirs, loading their XML data to memory
        if ($XMLDB->dbdirs) {
            $dbdirs = $XMLDB->dbdirs;
            foreach ($dbdirs as $dbdir) {
                // Set some defaults
                $dbdir->xml_exists = false;
                $dbdir->xml_writeable = false;
                $dbdir->xml_loaded  = false;
                // Only if the directory exists
                if (!$dbdir->path_exists) {
                    continue;
                }
                $xmldb_file = new xmldb_file($dbdir->path . '/install.xml');
                // Set dbdir as necessary
                if ($xmldb_file->fileExists()) {
                    $dbdir->xml_exists = true;
                }
                if ($xmldb_file->fileWriteable()) {
                    $dbdir->xml_writeable = true;
                }
                // Load the XML contents to structure
                $loaded = $xmldb_file->loadXMLStructure();
                if ($loaded && $xmldb_file->isLoaded()) {
                    $dbdir->xml_loaded = true;
                }
                $dbdir->xml_file = $xmldb_file;
            }
        }
        return $result;
    }
}


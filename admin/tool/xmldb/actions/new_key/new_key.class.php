<?php


/**
 * @package    admin_tool
 * @subpackage xmldb
 * @copyright  2015 Pooya Saeedi
 */

/**
 * This class will create a new default key to be edited
 *
 */
class new_key extends XMLDBAction {

    /**
     * Init method, every subclass will have its own
     */
    function init() {
        parent::init();

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

        // Do the job, setting result as needed
        // Get the dir containing the file
        $dirpath = required_param('dir', PARAM_PATH);
        $dirpath = $CFG->dirroot . $dirpath;

        // Get the correct dirs
        if (!empty($XMLDB->dbdirs)) {
            $dbdir = $XMLDB->dbdirs[$dirpath];
        } else {
            return false;
        }
        if (!empty($XMLDB->editeddirs)) {
            $editeddir = $XMLDB->editeddirs[$dirpath];
            $structure = $editeddir->xml_file->getStructure();
        }

        $tableparam = required_param('table', PARAM_CLEAN);

        $table = $structure->getTable($tableparam);

        // If the changeme key exists, just get it and continue
        $changeme_exists = false;
        if ($keys = $table->getKeys()) {
            if ($key = $table->getKey('changeme')) {
                $changeme_exists = true;
            }
        }
        if (!$changeme_exists) { // Lets create the Key
            $key = new xmldb_key('changeme');
            $table->addKey($key);

            // We have one new key, so the structure has changed
            $structure->setVersion(userdate(time(), '%Y%m%d', 99, false));
            $structure->setChanged(true);
        }
        // Launch postaction if exists (leave this here!)
        if ($this->getPostAction() && $result) {
            return $this->launch($this->getPostAction());
        }

        // Return ok if arrived here
        return $result;
    }
}


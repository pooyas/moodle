<?php

/**
 * @package    tool
 * @subpackage xmldb
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * This class will will move table up/down
 *
 */
class move_updown_table extends XMLDBAction {

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

        $prev = NULL;
        $next = NULL;
        $tableparam = required_param('table', PARAM_CLEAN);
        $direction  = required_param('direction', PARAM_ALPHA);
        $tables = $structure->getTables();
        if ($direction == 'down') {
            $table = $structure->getTable($tableparam);
            $swap  = $structure->getTable($table->getNext());
        } else {
            $swap  = $structure->getTable($tableparam);
            $table = $structure->getTable($swap->getPrevious());
        }

        // Change the table before the pair
        if ($table->getPrevious()) {
            $prev = $structure->getTable($table->getPrevious());
            $prev->setNext($swap->getName());
            $swap->setPrevious($prev->getName());
            $prev->setChanged(true);
        } else {
            $swap->setPrevious(NULL);
        }
        // Change the table after the pair
        if ($swap->getNext()) {
            $next = $structure->getTable($swap->getNext());
            $next->setPrevious($table->getName());
            $table->setNext($next->getName());
            $next->setChanged(true);
        } else {
            $table->setNext(NULL);
        }
        // Swap the tables
        $table->setPrevious($swap->getName());
        $swap->setNext($table->getName());

        // Table has changed
        $table->setChanged(true);

        // Reorder the structure
        $structure->orderTables();

        // Recalculate the hash
        $structure->calculateHash(true);

        // If the hash has changed from the original one, change the version
        // and mark the structure as changed
        $origstructure = $dbdir->xml_file->getStructure();
        if ($structure->getHash() != $origstructure->getHash()) {
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


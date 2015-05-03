<?php

/**
 * @package    tool
 * @subpackage xmldb
 * @copyright  2015 Pooya Saeedi
 * 
 */

/**
 * This class will will move one key up/down
 *
 */
class move_updown_key extends XMLDBAction {

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
        $keyparam = required_param('key', PARAM_CLEAN);
        $direction  = required_param('direction', PARAM_ALPHA);
        $tables = $structure->getTables();
        $table = $structure->getTable($tableparam);
        $keys = $table->getKeys();
        if ($direction == 'down') {
            $key = $table->getKey($keyparam);
            $swap = $table->getKey($key->getNext());
        } else {
            $swap = $table->getKey($keyparam);
            $key = $table->getKey($swap->getPrevious());
        }

        // Change the key before the pair
        if ($key->getPrevious()) {
            $prev = $table->getKey($key->getPrevious());
            $prev->setNext($swap->getName());
            $swap->setPrevious($prev->getName());
            $prev->setChanged(true);
        } else {
            $swap->setPrevious(NULL);
        }
        // Change the key after the pair
        if ($swap->getNext()) {
            $next = $table->getKey($swap->getNext());
            $next->setPrevious($key->getName());
            $key->setNext($next->getName());
            $next->setChanged(true);
        } else {
            $key->setNext(NULL);
        }
        // Swap the keys
        $key->setPrevious($swap->getName());
        $swap->setNext($key->getName());

        // Mark keys as changed
        $key->setChanged(true);
        $swap->setChanged(true);

        // Table has changed
        $table->setChanged(true);

        // Reorder the keys
        $table->orderKeys();

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


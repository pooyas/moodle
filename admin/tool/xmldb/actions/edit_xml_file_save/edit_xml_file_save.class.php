<?php


/**
 * @package    admin_tool
 * @subpackage xmldb
 * @copyright  2015 Pooya Saeedi
 */

/**
 * This class will save the changes performed to the comment of one file
 *
 */
class edit_xml_file_save extends XMLDBAction {

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

        if (!data_submitted()) { // Basic prevention
            print_error('wrongcall', 'error');
        }

        // Get parameters
        $dirpath = required_param('dir', PARAM_PATH);
        $dirpath = $CFG->dirroot . $dirpath;

        $comment = required_param('comment', PARAM_CLEAN);
        $comment = $comment;

        // Set comment and recalculate hash
        $editeddir = $XMLDB->editeddirs[$dirpath];
        $structure = $editeddir->xml_file->getStructure();
        $structure->setComment($comment);
        $structure->calculateHash(true);


        // If the hash has changed from the original one, change the version
        // and mark the structure as changed
        $origdir = $XMLDB->dbdirs[$dirpath];
        $origstructure = $origdir->xml_file->getStructure();
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


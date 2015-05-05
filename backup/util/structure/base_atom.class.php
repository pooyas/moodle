<?php


/**
 * @package    core
 * @subpackage backup-structure
 * @copyright  2015 Pooya Saeedi
 * 
 *
 * TODO: Finish phpdocs
 */

/**
 * Abstract class representing one atom (name/value) piece of information
 */
abstract class base_atom {

    /** @var string name of the element (maps to XML name) */
    private $name;

    /** @var string value of the element (maps to XML content) */
    private $value;

    /** @var bool flag to indicate when one value has been set (true) or no (false) */
    private $is_set;

    /**
     * Constructor - instantiates one base_atom, specifying its basic info.
     *
     * @param string $name name of the element
     * @param string $value optional value of the element
     */
    public function __construct($name) {

        $this->validate_name($name); // Check name

        $this->name  = $name;
        $this->value = null;
        $this->is_set= false;
    }

    protected function validate_name($name) {
        // Validate various name constraints, throwing exception if needed
        if (empty($name)) {
            throw new base_atom_struct_exception('backupatomemptyname', $name);
        }
        if (preg_replace('/\s/', '', $name) != $name) {
            throw new base_atom_struct_exception('backupatomwhitespacename', $name);
        }
        if (preg_replace('/[^\x30-\x39\x41-\x5a\x5f\x61-\x7a]/', '', $name) != $name) {
            throw new base_atom_struct_exception('backupatomnotasciiname', $name);
        }
    }

/// Public API starts here

    public function get_name() {
        return $this->name;
    }

    public function get_value() {
        return $this->value;
    }

    public function set_value($value) {
        if ($this->is_set) {
            throw new base_atom_content_exception('backupatomalreadysetvalue', $value);
        }
        $this->value = $value;
        $this->is_set= true;
    }

    public function clean_value() {
        $this->value = null;
        $this->is_set= false;
    }

    public function is_set() {
        return $this->is_set;
    }

    public function to_string($showvalue = false) {
        $output = $this->name;
        if ($showvalue) {
            $value = $this->is_set ? $this->value : 'not set';
            $output .= ' => ' . $value;
        }
        return $output;
    }
}

/**
 * base_atom abstract exception class
 *
 * This exceptions will be used by all the base_atom classes
 * in order to detect any problem or miss-configuration
 */
abstract class base_atom_exception extends lion_exception {

    /**
     * Constructor - instantiates one base_atom_exception.
     *
     * @param string $errorcode key for the corresponding error string
     * @param object $a extra words and phrases that might be required in the error string
     * @param string $debuginfo optional debugging information
     */
    public function __construct($errorcode, $a = null, $debuginfo = null) {
        parent::__construct($errorcode, '', '', $a, $debuginfo);
    }
}

/**
 * base_atom exception to control all the errors while creating the objects
 *
 * This exception will be thrown each time the base_atom class detects some
 * inconsistency related with the creation of objects and their attributes
 * (wrong names)
 */
class base_atom_struct_exception extends base_atom_exception {

    /**
     * Constructor - instantiates one base_atom_struct_exception
     *
     * @param string $errorcode key for the corresponding error string
     * @param object $a extra words and phrases that might be required in the error string
     * @param string $debuginfo optional debugging information
     */
    public function __construct($errorcode, $a = null, $debuginfo = null) {
        parent::__construct($errorcode, $a, $debuginfo);
    }
}

/**
 * base_atom exception to control all the errors while setting the values
 *
 * This exception will be thrown each time the base_atom class detects some
 * inconsistency related with the creation of contents (values) of the objects
 * (bad contents, setting without cleaning...)
 */
class base_atom_content_exception extends base_atom_exception {

    /**
     * Constructor - instantiates one base_atom_content_exception
     *
     * @param string $errorcode key for the corresponding error string
     * @param object $a extra words and phrases that might be required in the error string
     * @param string $debuginfo optional debugging information
     */
    public function __construct($errorcode, $a = null, $debuginfo = null) {
        parent::__construct($errorcode, $a, $debuginfo);
    }
}

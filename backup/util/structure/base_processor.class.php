<?php


/**
 * @package    lioncore
 * @subpackage backup-structure
 * @copyright  2010 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * 
 *
 * TODO: Finish phpdocs
 */

/**
 * Abstract class representing the required implementation for classes able to process structure classes
 */
abstract class base_processor {

    abstract function pre_process_nested_element(base_nested_element $nested);
    abstract function process_nested_element(base_nested_element $nested);
    abstract function post_process_nested_element(base_nested_element $nested);

    abstract function process_final_element(base_final_element $final);

    abstract function process_attribute(base_attribute $attribute);
}

/**
 * base_processor abstract exception class
 *
 * This exceptions will be used by all the processor classes
 * in order to detect any problem or miss-configuration
 */
abstract class base_processor_exception extends lion_exception {

    /**
     * Constructor - instantiates one base_processor_exception.
     *
     * @param string $errorcode key for the corresponding error string
     * @param object $a extra words and phrases that might be required in the error string
     * @param string $debuginfo optional debugging information
     */
    public function __construct($errorcode, $a = null, $debuginfo = null) {
        parent::__construct($errorcode, '', '', $a, $debuginfo);
    }
}

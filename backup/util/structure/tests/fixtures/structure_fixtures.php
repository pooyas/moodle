<?php

/**
 * @package   core_backup
 * @category  phpunit
 * @copyright 2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

// Include all the needed stuff
global $CFG;
require_once($CFG->dirroot . '/backup/util/includes/backup_includes.php');

/**
 * helper extended base_attribute class that implements some methods for instantiating and testing
 */
class mock_base_attribute extends base_attribute {
    // Nothing to do. Just allow instances to be created
}

/**
 * helper extended final_element class that implements some methods for instantiating and testing
 */
class mock_base_final_element extends base_final_element {
/// Implementable API
    protected function get_new_attribute($name) {
        return new mock_base_attribute($name);
    }
}

/**
 * helper extended nested_element class that implements some methods for instantiating and testing
 */
class mock_base_nested_element extends base_nested_element {
/// Implementable API
    protected function get_new_attribute($name) {
        return new mock_base_attribute($name);
    }

    protected function get_new_final_element($name) {
        return new mock_base_final_element($name);
    }
}

/**
 * helper extended optigroup class that implements some methods for instantiating and testing
 */
class mock_base_optigroup extends base_optigroup {
/// Implementable API
    protected function get_new_attribute($name) {
        return new mock_base_attribute($name);
    }

    protected function get_new_final_element($name) {
        return new mock_base_final_element($name);
    }

    public function is_multiple() {
        return parent::is_multiple();
    }
}

/**
 * helper class that extends backup_final_element in order to skip its value
 */
class mock_skip_final_element extends backup_final_element {

    public function set_value($value) {
        $this->clean_value();
    }
}

/**
 * helper class that extends backup_final_element in order to modify its value
 */
class mock_modify_final_element extends backup_final_element {
    public function set_value($value) {
        parent::set_value('original was ' . $value . ', now changed');
    }
}

/**
 * helper class that extends backup_final_element to delegate any calculation to another class
 */
class mock_final_element_interceptor extends backup_final_element {
    public function set_value($value) {
        // Get grandparent name
        $gpname = $this->get_grandparent()->get_name();
        // Get parent name
        $pname = $this->get_parent()->get_name();
        // Get my name
        $myname = $this->get_name();
        // Define class and function name
        $classname = 'mock_' . $gpname . '_' . $pname . '_interceptor';
        $methodname= 'intercept_' . $pname . '_' . $myname;
        // Invoke the interception method
        $result = call_user_func(array($classname, $methodname), $value);
        // Finally set it
        parent::set_value($result);
    }
}

/**
 * test interceptor class (its methods are called from interceptor)
 */
abstract class mock_forum_forum_interceptor {
    static function intercept_forum_completionposts($element) {
        return 'intercepted!';
    }
}

/**
 * Instantiable class extending base_atom in order to be able to perform tests
 */
class mock_base_atom extends base_atom {
    // Nothing new in this class, just an instantiable base_atom class
    // with the is_set() method public for testing purposes
    public function is_set() {
        return parent::is_set();
    }
}

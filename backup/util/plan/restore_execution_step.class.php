<?php



/**
 * @package    backup
 * @subpackage util
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Abstract class defining the needed stuff to execute code on restore
 *
 * TODO: Finish phpdocs
 */
abstract class restore_execution_step extends restore_step {

    public function execute() {
        // Simple, for now
        return $this->define_execution();
    }

// Protected API starts here

    /**
     * Function that will contain all the code to be executed
     */
    abstract protected function define_execution();
}

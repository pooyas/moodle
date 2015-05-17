<?php



/**
 * @package    backup
 * @subpackage util
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Interface to apply to all the classes we want to be processable by one @base_processor
 *
 * Any class being part of one backup/restore structure must implement this interface
 * in order to be able to be processed by a given processor (visitor pattern)
 *
 * TODO: Finish phpdocs
 */
interface processable {

    /**
     * This function will call to the corresponding processor method in other to
     * make them perform the desired tasks.
     */
    public function process($processor);
}

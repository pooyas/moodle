<?php

/**
 * @package     core
 * @subpackage backup
 * @copyright   2015 Pooya Saeedi
 */

/**
 * Interface to apply to all the classes we want to calculate their checksum
 *
 * Each class being part of @backup_controller will implement this interface
 * in order to be able to calculate one objective and unique checksum for
 * the whole controller class.
 *
 * TODO: Finish phpdocs
 */
interface checksumable {

    /**
     * This function will return one unique and stable checksum for one instance
     * of the class implementing it. It's each implementation responsibility to
     * do it recursively if needed and use optional store (caching) of the checksum if
     * necessary/possible
     */
    public function calculate_checksum();

    /**
     * Given one checksum, returns if matches object's checksum (true) or no (false)
     */
    public function is_checksum_correct($checksum);

}

<?php



/**
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
*/

namespace core\progress;

defined('LION_INTERNAL') || die();

/**
 * Progress handler that ignores progress entirely.
 *
 */
class null extends base {
    public function update_progress() {
        // Do nothing.
    }
}

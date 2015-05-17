<?php


/**
 * Class represents the result of an availability check for the user.
 *
 * @package    availability
 * @subpackage classes
 * @copyright  2015 Pooya Saeedi
 */

namespace core_availability;

defined('LION_INTERNAL') || die();

/**
 * Class represents the result of an availability check for the user.
 *
 * You can pass an object of this class to tree::get_result_information to
 * display suitable student information about the result.
 *
 */
class result {
    /** @var bool True if the item is available */
    protected $available;

    /** @var tree_node[] Array of nodes to display in failure information (node=>node). */
    protected $shownodes = array();

    /**
     * Constructs result.
     *
     * @param bool $available True if available
     * @param tree_node $node Node if failed & should be displayed
     * @param result[] $failedchildren Array of children who failed too
     */
    public function __construct($available, tree_node $node = null,
            array $failedchildren = array()) {
        $this->available = $available;
        if (!$available) {
            if ($node) {
                $this->shownodes[spl_object_hash($node)] = $node;
            }
            foreach ($failedchildren as $child) {
                foreach ($child->shownodes as $key => $node) {
                    $this->shownodes[$key] = $node;
                }
            }
        }
    }

    /**
     * Checks if the result was a yes.
     *
     * @return bool True if the activity is available
     */
    public function is_available() {
        return $this->available;
    }

    /**
     * Filters the provided array so that it only includes nodes which are
     * supposed to be displayed in the result output. (I.e. those for which
     * the user failed the test, and which are not set to totally hide
     * output.)
     *
     * @param tree_node[] $array Input array of nodes
     * @return array Output array containing only those nodes set for display
     */
    public function filter_nodes(array $array) {
        $out = array();
        foreach ($array as $key => $node) {
            if (array_key_exists(spl_object_hash($node), $this->shownodes)) {
                $out[$key] = $node;
            }
        }
        return $out;
    }
}

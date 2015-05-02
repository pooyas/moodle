<?php

/**
 * Used while evaluating conditions in bulk.
 *
 * This object caches get_users_by_capability results in case they are needed
 * by multiple conditions.
 *
 * @package core_availability
 * @copyright 2014 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace core_availability;

defined('LION_INTERNAL') || die();

/**
 * Used while evaluating conditions in bulk.
 *
 * This object caches get_users_by_capability results in case they are needed
 * by multiple conditions.
 *
 * @package core_availability
 * @copyright 2014 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class capability_checker {
    /** @var \context Course or module context */
    protected $context;

    /** @var array Associative array of capability => result */
    protected $cache = array();

    /**
     * Constructs for given context.
     *
     * @param \context $context Context
     */
    public function __construct(\context $context) {
        $this->context = $context;
    }

    /**
     * Gets users on course who have the specified capability. Returns an array
     * of user objects which only contain the 'id' field. If the same capability
     * has already been checked (e.g. by another condition) then a cached
     * result will be used.
     *
     * More fields are not necessary because this code is only used to filter
     * users from an existing list.
     *
     * @param string $capability Required capability
     * @return array Associative array of user id => objects containing only id
     */
    public function get_users_by_capability($capability) {
        if (!array_key_exists($capability, $this->cache)) {
            $this->cache[$capability] = get_users_by_capability(
                    $this->context, $capability, 'u.id');
        }
        return $this->cache[$capability];
    }
}

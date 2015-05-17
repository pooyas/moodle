<?php


/**
 * Defines abstract factory class for generating locks.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\lock;

defined('LION_INTERNAL') || die();

/**
 * Defines abstract factory class for generating locks.
 *
 * @category  lock
 */
interface lock_factory {

    /**
     * Define the constructor signature required by the lock_config class.
     *
     * @param string $type - The type this lock is used for (e.g. cron, cache)
     */
    public function __construct($type);

    /**
     * Return information about the blocking behaviour of the locks on this platform.
     *
     * @return boolean - False if attempting to get a lock will block indefinitely.
     */
    public function supports_timeout();

    /**
     * Will this lock be automatically released when the process ends.
     * This should never be relied upon in code - but is useful in the case of
     * fatal errors. If a lock type does not support this auto release,
     * the max lock time parameter must be obeyed to eventually clean up a lock.
     *
     * @return boolean - True if this lock type will be automatically released when the current process ends.
     */
    public function supports_auto_release();

    /**
     * Supports recursion.
     *
     * @return boolean - True if attempting to get 2 locks on the same resource will "stack"
     */
    public function supports_recursion();

    /**
     * Is available.
     *
     * @return boolean - True if this lock type is available in this environment.
     */
    public function is_available();

    /**
     * Get a lock within the specified timeout or return false.
     *
     * @param string $resource - The identifier for the lock. Should use frankenstyle prefix.
     * @param int $timeout - The number of seconds to wait for a lock before giving up.
     *                       Not all lock types will support this.
     * @param int $maxlifetime - The number of seconds to wait before reclaiming a stale lock.
     *                       Not all lock types will use this - e.g. if they support auto releasing
     *                       a lock when a process ends.
     * @return \core\lock\lock|boolean - An instance of \core\lock\lock if the lock was obtained, or false.
     */
    public function get_lock($resource, $timeout, $maxlifetime = 86400);

    /**
     * Release a lock that was previously obtained with @lock.
     *
     * @param lock $lock - The lock to release.
     * @return boolean - True if the lock is no longer held (including if it was never held).
     */
    public function release_lock(lock $lock);

    /**
     * Extend the timeout on a held lock.
     *
     * @param lock $lock - lock obtained from this factory
     * @param int $maxlifetime - new max time to hold the lock
     * @return boolean - True if the lock was extended.
     */
    public function extend_lock(lock $lock, $maxlifetime = 86400);
}

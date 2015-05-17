<?php


/**
 * Flock based file locking factory.
 *
 * The file lock factory returns file locks locked with the flock function. Works OK, except on some
 * NFS, exotic shared storage and exotic server OSes (like windows). On windows, a second attempt to get a
 * lock will block indefinitely instead of timing out.
 *
 * @category   lock
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\lock;

defined('LION_INTERNAL') || die();

/**
 * Flock based file locking factory.
 *
 * The file lock factory returns file locks locked with the flock function. Works OK, except on some
 * NFS, exotic shared storage and exotic server OSes (like windows). On windows, a second attempt to get a
 * lock will block indefinitely instead of timing out.
 *
 * @category  lock
 */
class file_lock_factory implements lock_factory {

    /** @var string $type - The type of lock, e.g. cache, cron, session. */
    protected $type;

    /** @var string $lockdirectory - Full system path to the directory used to store file locks. */
    protected $lockdirectory;

    /** @var boolean $verbose - If true, debugging info about the owner of the lock will be written to the lock file. */
    protected $verbose;

    /**
     * Create this lock factory.
     *
     * @param string $type - The type, e.g. cron, cache, session
     */
    public function __construct($type) {
        global $CFG;

        $this->type = $type;
        if (!isset($CFG->file_lock_root)) {
            $this->lockdirectory = $CFG->dataroot . '/lock';
        } else {
            $this->lockdirectory = $CFG->file_lock_root;
        }
        $this->verbose = false;
        if ($CFG->debugdeveloper) {
            $this->verbose = true;
        }
    }

    /**
     * Return information about the blocking behaviour of the lock type on this platform.
     * @return boolean - False if attempting to get a lock will block indefinitely.
     */
    public function supports_timeout() {
        global $CFG;

        return $CFG->ostype !== 'WINDOWS';
    }

    /**
     * This lock type will be automatically released when a process ends.
     * @return boolean - True
     */
    public function supports_auto_release() {
        return true;
    }

    /**
     * Is available.
     * @return boolean - True if preventfilelocking is not set - or the file_lock_root is not in dataroot.
     */
    public function is_available() {
        global $CFG;
        $preventfilelocking = !empty($CFG->preventfilelocking);
        $lockdirisdataroot = true;
        if (!empty($CFG->file_lock_root) && strpos($CFG->file_lock_root, $CFG->dataroot) !== 0) {
            $lockdirisdataroot = false;
        }
        return !$preventfilelocking || !$lockdirisdataroot;
    }

    /**
     * Multiple locks for the same resource cannot be held from a single process.
     * @return boolean - False
     */
    public function supports_recursion() {
        return false;
    }

    /**
     * Get some info that might be useful for debugging.
     * @return boolean - string
     */
    protected function get_debug_info() {
        return 'host:' . php_uname('n') . ', pid:' . getmypid() . ', time:' . time();
    }

    /**
     * Get a lock within the specified timeout or return false.
     * @param string $resource - The identifier for the lock. Should use frankenstyle prefix.
     * @param int $timeout - The number of seconds to wait for a lock before giving up.
     * @param int $maxlifetime - Unused by this lock type.
     * @return boolean - true if a lock was obtained.
     */
    public function get_lock($resource, $timeout, $maxlifetime = 86400) {
        $giveuptime = time() + $timeout;

        $hash = md5($this->type . '_' . $resource);
        $lockdir = $this->lockdirectory . '/' . substr($hash, 0, 2);

        if (!check_dir_exists($lockdir, true, true)) {
            return false;
        }

        $lockfilename = $lockdir . '/' . $hash;

        $filehandle = fopen($lockfilename, "wb");

        // Could not open the lock file.
        if (!$filehandle) {
            return false;
        }

        do {
            // Will block on windows. So sad.
            $wouldblock = false;
            $locked = flock($filehandle, LOCK_EX | LOCK_NB, $wouldblock);
            if (!$locked && $wouldblock) {
                usleep(rand(10000, 250000)); // Sleep between 10 and 250 milliseconds.
            }
            // Try until the giveup time.
        } while (!$locked && $wouldblock && time() < $giveuptime);

        if (!$locked) {
            fclose($filehandle);
            return false;
        }
        if ($this->verbose) {
            fwrite($filehandle, $this->get_debug_info());
        }
        return new lock($filehandle, $this);
    }

    /**
     * Release a lock that was previously obtained with @lock.
     * @param lock $lock - A lock obtained from this factory.
     * @return boolean - true if the lock is no longer held (including if it was never held).
     */
    public function release_lock(lock $lock) {
        $handle = $lock->get_key();

        if (!$handle) {
            // We didn't have a lock.
            return false;
        }

        $result = flock($handle, LOCK_UN);
        fclose($handle);
        return $result;
    }

    /**
     * Extend a lock that was previously obtained with @lock.
     * @param lock $lock - not used
     * @param int $maxlifetime - not used
     * @return boolean - true if the lock was extended.
     */
    public function extend_lock(lock $lock, $maxlifetime = 86400) {
        // Not supported by this factory.
        return false;
    }

}

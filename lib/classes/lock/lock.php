<?php

/**
 * Class representing a lock
 *
 * The methods available for a specific lock type are only known by it's factory.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace core\lock;

defined('LION_INTERNAL') || die();

/**
 * Class representing a lock
 *
 * The methods available for a specific lock type are only known by it's factory.
 *
 */
class lock {

    /** @var string|int $key A unique key representing a held lock */
    protected $key = '';

    /** @var lock_factory $factory The factory that generated this lock */
    protected $factory;

    /** @var bool $released Has this lock been released? If a lock falls out of scope without being released - show a warning. */
    protected $released;

    /**
     * Construct a lock containing the unique key required to release it.
     * @param mixed $key - The lock key. The type of this is up to the lock_factory being used.
     *      For file locks this is a file handle. For MySQL this is a string.
     * @param lock_factory $factory - The factory that generated this lock.
     */
    public function __construct($key, $factory) {
        $this->factory = $factory;
        $this->key = $key;
        $this->released = false;
    }

    /**
     * Return the unique key representing this lock.
     * @return string|int lock key.
     */
    public function get_key() {
        return $this->key;
    }

    /**
     * Extend the lifetime of this lock. Not supported by all factories.
     * @param int $maxlifetime - the new lifetime for the lock (in seconds).
     * @return bool
     */
    public function extend($maxlifetime = 86400) {
        if ($this->factory) {
            return $this->factory->extend_lock($this, $maxlifetime);
        }
        return false;
    }

    /**
     * Release this lock
     * @return bool
     */
    public function release() {
        $this->released = true;
        if (empty($this->factory)) {
            return false;
        }
        $result = $this->factory->release_lock($this);
        // Release any held references to the factory.
        unset($this->factory);
        $this->factory = null;
        $this->key = '';
        return $result;
    }

    /**
     * Print debugging if this lock falls out of scope before being released.
     */
    public function __destruct() {
        if (!$this->released && defined('PHPUNIT_TEST')) {
            $this->release();
            throw new \coding_exception('\core\lock\lock(' . $this->key . ') has fallen out of scope ' .
                                        'without being released.' . "\n" .
                                        'Locks must ALWAYS be released by calling $mylock->release().');
        }
    }

}

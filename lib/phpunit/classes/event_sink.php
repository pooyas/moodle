<?php

/**
 * Event sink.
 *
 * @package    core
 * @category   phpunit
 * @copyright  2015 Pooya Saeedi
 * 
 */


/**
 * Event redirection sink.
 *
 */
class phpunit_event_sink {
    /** @var \core\event\base[] array of events */
    protected $events = array();

    /**
     * Stop event redirection.
     *
     * Use if you do not want event redirected any more.
     */
    public function close() {
        phpunit_util::stop_event_redirection();
    }

    /**
     * To be called from phpunit_util only!
     *
     * @private
     * @param \core\event\base $event record from event_read table
     */
    public function add_event(\core\event\base $event) {
        /* Number events from 0. */
        $this->events[] = $event;
    }

    /**
     * Returns all redirected events.
     *
     * The instances are records form the event_read table.
     * The array indexes are numbered from 0 and the order is matching
     * the creation of events.
     *
     * @return \core\event\base[]
     */
    public function get_events() {
        return $this->events;
    }

    /**
     * Return number of events redirected to this sink.
     *
     * @return int
     */
    public function count() {
        return count($this->events);
    }

    /**
     * Removes all previously stored events.
     */
    public function clear() {
        $this->events = array();
    }
}

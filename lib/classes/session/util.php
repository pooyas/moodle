<?php


/**
 * Shared utility functions for session handlers.
 *
 * This contains functions that are shared between two or more handlers.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

namespace core\session;

defined('LION_INTERNAL') || die();

/**
 * Shared utility functions for session handlers.
 *
 * This contains functions that are shared between two or more handlers.
 *
 */
abstract class util {
    /**
     * Convert a connection string to an array of servers
     *
     * EG: Converts: "abc:123, xyz:789" to
     *
     *  array(
     *      array('abc', '123'),
     *      array('xyz', '789'),
     *  )
     *
     *
     * @param string $str save_path value containing memcached connection string
     * @return array
     */
    public static function connection_string_to_memcache_servers($str) {
        $servers = array();
        $parts   = explode(',', $str);
        foreach ($parts as $part) {
            $part = trim($part);
            $pos  = strrpos($part, ':');
            if ($pos !== false) {
                $host = substr($part, 0, $pos);
                $port = substr($part, ($pos + 1));
            } else {
                $host = $part;
                $port = 11211;
            }
            $servers[] = array($host, $port);
        }
        return $servers;
    }
}

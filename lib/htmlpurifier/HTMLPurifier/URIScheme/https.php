<?php

/**
 * Validates https (Secure HTTP) according to http scheme.
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */
class HTMLPurifier_URIScheme_https extends HTMLPurifier_URIScheme_http
{
    /**
     * @type int
     */
    public $default_port = 443;
    /**
     * @type bool
     */
    public $secure = true;
}

// vim: et sw=4 sts=4

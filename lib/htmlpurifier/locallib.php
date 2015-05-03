<?php

/**
 * Extra classes needed for HTMLPurifier customisation for Lion.
 *
 * @package    core
 * @copyright  2015 Pooya Saeedi 
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL 3 or later
 */

defined('LION_INTERNAL') || die();


/**
 * Validates RTSP defined by RFC 2326
 */
class HTMLPurifier_URIScheme_rtsp extends HTMLPurifier_URIScheme {

    public $browsable = true;
    public $hierarchical = true;

    public function doValidate(&$uri, $config, $context) {
        $uri->userinfo = null;
        return true;
    }

}


/**
 * Validates RTMP defined by Adobe
 */
class HTMLPurifier_URIScheme_rtmp extends HTMLPurifier_URIScheme {

    public $browsable = false;
    public $hierarchical = true;

    public function doValidate(&$uri, $config, $context) {
        $uri->userinfo = null;
        return true;
    }

}


/**
 * Validates IRC defined by IETF Draft
 */
class HTMLPurifier_URIScheme_irc extends HTMLPurifier_URIScheme {

    public $browsable = true;
    public $hierarchical = true;

    public function doValidate(&$uri, $config, $context) {
        $uri->userinfo = null;
        return true;
    }

}


/**
 * Validates MMS defined by Microsoft
 */
class HTMLPurifier_URIScheme_mms extends HTMLPurifier_URIScheme {

    public $browsable = true;
    public $hierarchical = true;

    public function doValidate(&$uri, $config, $context) {
        $uri->userinfo = null;
        return true;
    }

}


/**
 * Validates Gopher defined by RFC 4266
 */
class HTMLPurifier_URIScheme_gopher extends HTMLPurifier_URIScheme {

    public $browsable = true;
    public $hierarchical = true;

    public function doValidate(&$uri, $config, $context) {
        $uri->userinfo = null;
        return true;
    }

}


/**
 * Validates TeamSpeak defined by TeamSpeak
 */
class HTMLPurifier_URIScheme_teamspeak extends HTMLPurifier_URIScheme {

    public $browsable = true;
    public $hierarchical = true;

    public function doValidate(&$uri, $config, $context) {
        $uri->userinfo = null;
        return true;
    }

}

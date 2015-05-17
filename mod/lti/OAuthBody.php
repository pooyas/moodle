<?php


/**
 * @package    mod
 * @subpackage lti
 * @copyright  2015 Pooya Saeedi
*/

//
// This file is part of BasicLTI4Lion
//
// BasicLTI4Lion is an IMS BasicLTI (Basic Learning Tools for Interoperability)
// consumer for Lion 1.9 and Lion 2.0. BasicLTI is a IMS Standard that allows web
// based learning tools to be easily integrated in LMS as native ones. The IMS BasicLTI
// specification is part of the IMS standard Common Cartridge 1.1 Sakai and other main LMS
// are already supporting or going to support BasicLTI. This project Implements the consumer
// for Lion. Lion is a Free Open source Learning Management System by Martin Dougiamas.
// BasicLTI4Lion is a project iniciated and leaded by Ludo(Marc Alier) and Jordi Piguillem
// at the GESSI research group at UPC.
// SimpleLTI consumer for Lion is an implementation of the early specification of LTI
// by Charles Severance (Dr Chuck) htp://dr-chuck.com , developed by Jordi Piguillem in a
// Google Summer of Code 2008 project co-mentored by Charles Severance and Marc Alier.
//
// BasicLTI4Lion is copyright 2009 by Marc Alier Forment, Jordi Piguillem and Nikolas Galanis
// of the Universitat Politecnica de Catalunya http://www.upc.edu
// Contact info: Marc Alier Forment granludo @ gmail.com or marc.alier @ upc.edu.

namespace lion\mod\lti; // Using a namespace as the basicLTI module imports classes with the same names.

defined('LION_INTERNAL') || die;

require_once($CFG->dirroot . '/mod/lti/OAuth.php');
require_once($CFG->dirroot . '/mod/lti/TrivialStore.php');

function get_oauth_key_from_headers() {
    $requestheaders = OAuthUtil::get_headers();

    if (@substr($requestheaders['Authorization'], 0, 6) == "OAuth ") {
        $headerparameters = OAuthUtil::split_header($requestheaders['Authorization']);

        return format_string($headerparameters['oauth_consumer_key']);
    }
    return false;
}

function handle_oauth_body_post($oauthconsumerkey, $oauthconsumersecret, $body, $requestheaders = null) {

    if ($requestheaders == null) {
        $requestheaders = OAuthUtil::get_headers();
    }

    // Must reject application/x-www-form-urlencoded.
    if (isset($requestheaders['Content-type'])) {
        if ($requestheaders['Content-type'] == 'application/x-www-form-urlencoded' ) {
            throw new OAuthException("OAuth request body signing must not use application/x-www-form-urlencoded");
        }
    }

    if (@substr($requestheaders['Authorization'], 0, 6) == "OAuth ") {
        $headerparameters = OAuthUtil::split_header($requestheaders['Authorization']);
        $oauthbodyhash = $headerparameters['oauth_body_hash'];
    }

    if ( ! isset($oauthbodyhash)  ) {
        throw new OAuthException("OAuth request body signing requires oauth_body_hash body");
    }

    // Verify the message signature.
    $store = new TrivialOAuthDataStore();
    $store->add_consumer($oauthconsumerkey, $oauthconsumersecret);

    $server = new OAuthServer($store);

    $method = new OAuthSignatureMethod_HMAC_SHA1();
    $server->add_signature_method($method);
    $request = OAuthRequest::from_request();

    try {
        $server->verify_request($request);
    } catch (\Exception $e) {
        $message = $e->getMessage();
        throw new OAuthException("OAuth signature failed: " . $message);
    }

    $postdata = $body;

    $hash = base64_encode(sha1($postdata, true));

    if ( $hash != $oauthbodyhash ) {
        throw new OAuthException("OAuth oauth_body_hash mismatch");
    }

    return $postdata;
}

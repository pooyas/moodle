<?php

/**
 * This file contains a Trivial memory-based store - no support for tokens
 *
 * @package mod
 * @subpackage lti
 * @copyright IMS Global Learning Consortium
 *
 * @author Charles Severance csev@umich.edu
 *
 * @license http://www.apache.org/licenses/LICENSE-2.0
 */

namespace lion\mod\lti; // Using a namespace as the basicLTI module imports classes with the same names.

defined('LION_INTERNAL') || die;

/**
 * A Trivial memory-based store - no support for tokens.
 */
class TrivialOAuthDataStore extends OAuthDataStore {

    /** @var array $consumers  Array of tool consumer keys and secrets */
    private $consumers = array();

    /**
     * Add a consumer to the array
     *
     * @param string $consumerkey     Consumer key
     * @param string $consumersecret  Consumer secret
     */
    public function add_consumer($consumerkey, $consumersecret) {
        $this->consumers[$consumerkey] = $consumersecret;
    }

    /**
     * Get OAuth consumer given its key
     *
     * @param string $consumerkey     Consumer key
     *
     * @return lion\mod\lti\OAuthConsumer  OAuthConsumer object
     */
    public function lookup_consumer($consumerkey) {
        if (strpos($consumerkey, "http://" ) === 0) {
            $consumer = new OAuthConsumer($consumerkey, "secret", null);
            return $consumer;
        }
        if ( $this->consumers[$consumerkey] ) {
            $consumer = new OAuthConsumer($consumerkey, $this->consumers[$consumerkey], null);
            return $consumer;
        }
        return null;
    }

    /**
     * Create a dummy OAuthToken object for a consumer
     *
     * @param lion\mod\lti\OAuthConsumer $consumer     Consumer
     * @param string $tokentype    Type of token
     * @param string $token        Token ID
     *
     * @return lion\mod\lti\OAuthToken OAuthToken object
     */
    public function lookup_token($consumer, $tokentype, $token) {
        return new OAuthToken($consumer, '');
    }

    /**
     * Nonce values are not checked so just return a null
     *
     * @param lion\mod\lti\OAuthConsumer $consumer     Consumer
     * @param string $token        Token ID
     * @param string $nonce        Nonce value
     * @param string $timestamp    Timestamp
     *
     * @return null
     */
    public function lookup_nonce($consumer, $token, $nonce, $timestamp) {
        // Should add some clever logic to keep nonces from
        // being reused - for now we are really trusting
        // that the timestamp will save us.
        return null;
    }

    /**
     * Tokens are not used so just return a null.
     *
     * @param lion\mod\lti\OAuthConsumer $consumer     Consumer
     *
     * @return null
     */
    public function new_request_token($consumer) {
        return null;
    }

    /**
     * Tokens are not used so just return a null.
     *
     * @param string $token        Token ID
     * @param lion\mod\lti\OAuthConsumer $consumer     Consumer
     *
     * @return null
     */
    public function new_access_token($token, $consumer) {
        return null;
    }
}

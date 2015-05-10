<?php

/**
 * A helper class to access dropbox resources
 *
 * @package    repository
 * @subpackage dropbox
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();
require_once($CFG->libdir.'/oauthlib.php');

/**
 * Authentication class to access Dropbox API
 *
 */
class dropbox extends oauth_helper {
    /** @var string dropbox access type, can be dropbox or sandbox */
    private $mode = 'dropbox';
    /** @var string dropbox api url*/
    private $dropbox_api = 'https://api.dropbox.com/1';
    /** @var string dropbox content api url*/
    private $dropbox_content_api = 'https://api-content.dropbox.com/1';

    /**
     * Constructor for dropbox class
     *
     * @param array $args
     */
    function __construct($args) {
        parent::__construct($args);
    }

    /**
     * Get file listing from dropbox
     *
     * @param string $path
     * @param string $token
     * @param string $secret
     * @return array
     */
    public function get_listing($path='/', $token='', $secret='') {
        $url = $this->dropbox_api.'/metadata/'.$this->mode.$path;
        $content = $this->get($url, array(), $token, $secret);
        $data = json_decode($content);
        return $data;
    }

    /**
     * Prepares the filename to pass to Dropbox API as part of URL
     *
     * @param string $filepath
     * @return string
     */
    protected function prepare_filepath($filepath) {
        $info = pathinfo($filepath);
        $dirname = $info['dirname'];
        $basename = $info['basename'];
        $filepath = $dirname . rawurlencode($basename);
        if ($dirname != '/') {
            $filepath = $dirname . '/' . $basename;
            $filepath = str_replace("%2F", "/", rawurlencode($filepath));
        }
        return $filepath;
    }

    /**
     * Retrieves the default (64x64) thumbnail for dropbox file
     *
     * @throws lion_exception when file could not be downloaded
     *
     * @param string $filepath local path in Dropbox
     * @param string $saveas path to file to save the result
     * @param int $timeout request timeout in seconds, 0 means no timeout
     * @return array with attributes 'path' and 'url'
     */
    public function get_thumbnail($filepath, $saveas, $timeout = 0) {
        $url = $this->dropbox_content_api.'/thumbnails/'.$this->mode.$this->prepare_filepath($filepath);
        if (!($fp = fopen($saveas, 'w'))) {
            throw new lion_exception('cannotwritefile', 'error', '', $saveas);
        }
        $this->setup_oauth_http_options(array('timeout' => $timeout, 'file' => $fp, 'BINARYTRANSFER' => true));
        $result = $this->get($url);
        fclose($fp);
        if ($result === true) {
            return array('path'=>$saveas, 'url'=>$url);
        } else {
            unlink($saveas);
            throw new lion_exception('errorwhiledownload', 'repository', '', $result);
        }
    }

    /**
     * Downloads a file from Dropbox and saves it locally
     *
     * @throws lion_exception when file could not be downloaded
     *
     * @param string $filepath local path in Dropbox
     * @param string $saveas path to file to save the result
     * @param int $timeout request timeout in seconds, 0 means no timeout
     * @return array with attributes 'path' and 'url'
     */
    public function get_file($filepath, $saveas, $timeout = 0) {
        $url = $this->dropbox_content_api.'/files/'.$this->mode.$this->prepare_filepath($filepath);
        if (!($fp = fopen($saveas, 'w'))) {
            throw new lion_exception('cannotwritefile', 'error', '', $saveas);
        }
        $this->setup_oauth_http_options(array('timeout' => $timeout, 'file' => $fp, 'BINARYTRANSFER' => true));
        $result = $this->get($url);
        fclose($fp);
        if ($result === true) {
            return array('path'=>$saveas, 'url'=>$url);
        } else {
            unlink($saveas);
            throw new lion_exception('errorwhiledownload', 'repository', '', $result);
        }
    }

    /**
     * Returns direct link to Dropbox file
     *
     * @param string $filepath local path in Dropbox
     * @param int $timeout request timeout in seconds, 0 means no timeout
     * @return string|null information object or null if request failed with an error
     */
    public function get_file_share_link($filepath, $timeout = 0) {
        $url = $this->dropbox_api.'/shares/'.$this->mode.$this->prepare_filepath($filepath);
        $this->setup_oauth_http_options(array('timeout' => $timeout));
        $result = $this->post($url, array('short_url'=>0));
        if (!$this->http->get_errno()) {
            $data = json_decode($result);
            if (isset($data->url)) {
                return $data->url;
            }
        }
        return null;
    }

    /**
     * Sets Dropbox API mode (dropbox or sandbox, default dropbox)
     *
     * @param string $mode
     */
    public function set_mode($mode) {
        $this->mode = $mode;
    }
}

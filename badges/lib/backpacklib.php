<?php

/**
 * External backpack library.
 *
 * @package    core
 * @subpackage badges
 * @copyright  2015 Pooya Saeedi
 */

// Note:
// Renaming required

defined('MOODLE_INTERNAL') || die();

global $CFG;
require_once($CFG->libdir . '/filelib.php');

// Adopted from https://github.com/jbkc85/openbadges-class-php.
// Author Jason Cameron <jbkc85@gmail.com>.

class OpenBadgesBackpackHandler {
    private $backpack;
    private $email;
    private $backpackuid = 0;

    public function __construct($record) {
        $this->backpack = $record->backpackurl;
        $this->email = $record->email;
        $this->backpackuid = isset($record->backpackuid) ? $record->backpackuid : 0;
    }

    public function curl_request($action, $collection = null) {
        $curl = new curl();

        switch($action) {
            case 'user':
                $url = $this->backpack . "/displayer/convert/email";
                $param = array('email' => $this->email);
                break;
            case 'groups':
                $url = $this->backpack . '/displayer/' . $this->backpackuid . '/groups.json';
                break;
            case 'badges':
                $url = $this->backpack . '/displayer/' . $this->backpackuid . '/group/' . $collection . '.json';
                break;
        }

        $options = array(
            'FRESH_CONNECT'  => true,
            'RETURNTRANSFER' => true,
            'FORBID_REUSE'   => true,
            'HEADER'         => 0,
            'HTTPHEADER'     => array('Expect:'),
            'CONNECTTIMEOUT' => 3,
        );

        if ($action == 'user') {
            $out = $curl->post($url, $param, $options);
        } else {
            $out = $curl->get($url, array(), $options);
        }

        return json_decode($out);
    }

    private function check_status($status) {
        switch($status) {
            case "missing":
                $response = array(
                    'status'  => $status,
                    'message' => get_string('error:nosuchuser', 'badges')
                );
                return $response;
        }
    }

    public function get_collections() {
        $json = $this->curl_request('user', $this->email);
        if (isset($json->status)) {
            if ($json->status != 'okay') {
                return $this->check_status($json->status);
            } else {
                $this->backpackuid = $json->userId;
                return $this->curl_request('groups');
            }
        }
    }

    public function get_badges($collection) {
        $json = $this->curl_request('user', $this->email);
        if (isset($json->status)) {
            if ($json->status != 'okay') {
                return $this->check_status($json->status);
            } else {
                return $this->curl_request('badges', $collection);
            }
        }
    }

    public function get_url() {
        return $this->backpack;
    }
}

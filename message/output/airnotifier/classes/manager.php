<?php


/**
 * Airnotifier manager class
 *
 * @category   external
 * @package    message
 * @subpackage output
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

/**
 * Airnotifier helper manager class
 *
 */
class message_airnotifier_manager {

    /**
     * Include the relevant javascript and language strings for the device
     * toolbox YUI module
     *
     * @return bool
     */
    public function include_device_ajax() {
        global $PAGE, $CFG;

        $config = new stdClass();
        $config->resturl = '/message/output/airnotifier/rest.php';
        $config->pageparams = array();

        // Include toolboxes.
        $PAGE->requires->yui_module('lion-message_airnotifier-toolboxes', 'M.message.init_device_toolbox', array(array(
                'ajaxurl' => $config->resturl,
                'config' => $config,
                ))
        );

        // Required strings for the javascript.
        $PAGE->requires->strings_for_js(array('deletecheckdevicename'), 'message_airnotifier');
        $PAGE->requires->strings_for_js(array('show', 'hide'), 'lion');

        return true;
    }

    /**
     * Return the user devices for a specific app.
     *
     * @param string $appname the app name .
     * @param int $userid if empty take the current user.
     * @return array all the devices
     */
    public function get_user_devices($appname, $userid = null) {
        global $USER, $DB;

        if (empty($userid)) {
            $userid = $USER->id;
        }

        $devices = array();

        $params = array('appid' => $appname, 'userid' => $userid);

        // First, we look all the devices registered for this user in the Lion core.
        // We are going to allow only ios devices (since these are the ones that supports PUSH notifications).
        $userdevices = $DB->get_records('user_devices', $params);
        foreach ($userdevices as $device) {
            if (core_text::strtolower($device->platform)) {
                // Check if the device is known by airnotifier.
                if (!$airnotifierdev = $DB->get_record('message_airnotifier_devices',
                        array('userdeviceid' => $device->id))) {

                    // We have to create the device token in airnotifier.
                    if (! $this->create_token($device->pushid)) {
                        continue;
                    }

                    $airnotifierdev = new stdClass;
                    $airnotifierdev->userdeviceid = $device->id;
                    $airnotifierdev->enable = 1;
                    $airnotifierdev->id = $DB->insert_record('message_airnotifier_devices', $airnotifierdev);
                }
                $device->id = $airnotifierdev->id;
                $device->enable = $airnotifierdev->enable;
                $devices[] = $device;
            }
        }

        return $devices;
    }

    /**
     * Request and access key to Airnotifier
     *
     * @return mixed The access key or false in case of error
     */
    public function request_accesskey() {
        global $CFG, $USER;

        require_once($CFG->libdir . '/filelib.php');

        // Sending the request access key request to Airnotifier.
        $serverurl = $CFG->airnotifierurl . ':' . $CFG->airnotifierport . '/accesskeys/';
        // We use an APP Key "none", it can be anything.
        $header = array('Accept: application/json', 'X-AN-APP-NAME: ' . $CFG->airnotifierappname,
            'X-AN-APP-KEY: none');
        $curl = new curl();
        $curl->setHeader($header);

        // Site ids are stored as secrets in md5 in the Lion public hub.
        $params = array(
            'url' => $CFG->wwwroot,
            'siteid' => md5($CFG->siteidentifier),
            'contact' => $USER->email,
            'description' => $CFG->wwwroot
            );
        $resp = $curl->post($serverurl, $params);

        if ($key = json_decode($resp, true)) {
            if (!empty($key['accesskey'])) {
                return $key['accesskey'];
            }
        }
        return false;
    }

    /**
     * Create a device token in the Airnotifier instance
     * @param string $token The token to be created
     * @return bool True if all was right
     */
    private function create_token($token) {
        global $CFG;

        if (!$this->is_system_configured()) {
            return false;
        }

        require_once($CFG->libdir . '/filelib.php');

        $serverurl = $CFG->airnotifierurl . ':' . $CFG->airnotifierport . '/tokens/' . $token;
        $header = array('Accept: application/json', 'X-AN-APP-NAME: ' . $CFG->airnotifierappname,
            'X-AN-APP-KEY: ' . $CFG->airnotifieraccesskey);
        $curl = new curl;
        $curl->setHeader($header);
        $params = array();
        $resp = $curl->post($serverurl, $params);

        if ($resp = json_decode($resp, true)) {
            if (!empty($resp['status'])) {
                return $resp['status'] == 'ok' || $resp['status'] == 'token exists';
            }
        }
        return false;
    }

    /**
     * Tests whether the airnotifier settings have been configured
     * @return boolean true if airnotifier is configured
     */
    public function is_system_configured() {
        global $CFG;

        return (!empty($CFG->airnotifierurl) && !empty($CFG->airnotifierport) &&
                !empty($CFG->airnotifieraccesskey)  && !empty($CFG->airnotifierappname) &&
                !empty($CFG->airnotifiermobileappname));
    }

}

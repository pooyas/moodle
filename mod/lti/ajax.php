<?php

/**
 * AJAX service used when adding an External Tool.
 *
 * It is used to provide immediate feedback
 * of which tool provider is to be used based on the Launch URL.
 *
 * @package    mod_lti
 * @subpackage xml
 * @copyright Copyright (c) 2011 Lionrooms Inc. (http://www.lionrooms.com)
 * 
 * @author     Chris Scribner
 */
define('AJAX_SCRIPT', true);

require_once(dirname(__FILE__) . "/../../config.php");
require_once($CFG->dirroot . '/mod/lti/locallib.php');

$courseid = required_param('course', PARAM_INT);
$context = context_course::instance($courseid);

require_login($courseid, false);

$action = required_param('action', PARAM_TEXT);

$response = new stdClass();

switch ($action) {
    case 'find_tool_config':
        $toolurl = required_param('toolurl', PARAM_RAW);
        $toolid = optional_param('toolid', 0, PARAM_INT);

        require_capability('lion/course:manageactivities', $context);
        require_capability('mod/lti:addinstance', $context);

        if (empty($toolid) && !empty($toolurl)) {
            $tool = lti_get_tool_by_url_match($toolurl, $courseid);

            if (!empty($tool)) {
                $toolid = $tool->id;

                $response->toolid = $tool->id;
                $response->toolname = s($tool->name);
                $response->tooldomain = s($tool->tooldomain);
            }
        } else {
            $response->toolid = $toolid;
        }

        if (!empty($toolid)) {
            // Look up privacy settings.
            $query = '
                SELECT name, value
                FROM {lti_types_config}
                WHERE
                    typeid = :typeid
                AND name IN (\'sendname\', \'sendemailaddr\', \'acceptgrades\')
            ';

            $privacyconfigs = $DB->get_records_sql($query, array('typeid' => $toolid));
            $success = count($privacyconfigs) > 0;
            foreach ($privacyconfigs as $config) {
                $configname = $config->name;
                $response->$configname = $config->value;
            }
            if (!$success) {
                $response->error = s(get_string('tool_config_not_found', 'mod_lti'));
            }
        }

        break;
}
echo $OUTPUT->header();
echo json_encode($response);

die;

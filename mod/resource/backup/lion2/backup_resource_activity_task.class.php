<?php



/**
 * Defines backup_resource_activity_task class
 *
 * @category    backup
 * @package    mod
 * @subpackage resource
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die;

require_once($CFG->dirroot . '/mod/resource/backup/lion2/backup_resource_stepslib.php');

/**
 * Provides the steps to perform one complete backup of the Resource instance
 */
class backup_resource_activity_task extends backup_activity_task {

    /**
     * @param bool $resourceoldexists True if there are records in the resource_old table.
     */
    protected static $resourceoldexists = null;

    /**
     * No specific settings for this activity
     */
    protected function define_my_settings() {
    }

    /**
     * Defines a backup step to store the instance data in the resource.xml file
     */
    protected function define_my_steps() {
        $this->add_step(new backup_resource_activity_structure_step('resource_structure', 'resource.xml'));
    }

    /**
     * Encodes URLs to the index.php and view.php scripts
     *
     * @param string $content some HTML text that eventually contains URLs to the activity instance scripts
     * @return string the content with the URLs encoded
     */
    static public function encode_content_links($content) {
        global $CFG, $DB;

        $base = preg_quote($CFG->wwwroot,"/");

        // Link to the list of resources.
        $search="/(".$base."\/mod\/resource\/index.php\?id\=)([0-9]+)/";
        $content= preg_replace($search, '$@RESOURCEINDEX*$2@$', $content);

        // Link to resource view by moduleid.
        $search = "/(".$base."\/mod\/resource\/view.php\?id\=)([0-9]+)/";
        // Link to resource view by recordid
        $search2 = "/(".$base."\/mod\/resource\/view.php\?r\=)([0-9]+)/";

        // Check whether there are contents in the resource old table.
        if (static::$resourceoldexists === null) {
            static::$resourceoldexists = $DB->record_exists('resource_old', array());
        }

        // If there are links to items in the resource_old table, rewrite them to be links to the correct URL
        // for their new module.
        if (static::$resourceoldexists) {
            // Match all of the resources.
            $result = preg_match_all($search, $content, $matches, PREG_PATTERN_ORDER);

            // Course module ID resource links.
            if ($result) {
                list($insql, $params) = $DB->get_in_or_equal($matches[2]);
                $oldrecs = $DB->get_records_select('resource_old', "cmid $insql", $params, '', 'cmid, newmodule');

                for ($i = 0; $i < count($matches[0]); $i++) {
                    $cmid = $matches[2][$i];
                    if (isset($oldrecs[$cmid])) {
                        // Resource_old item, rewrite it
                        $replace = '$@' . strtoupper($oldrecs[$cmid]->newmodule) . 'VIEWBYID*' . $cmid . '@$';
                    } else {
                        // Not in the resource old table, don't rewrite
                        $replace = '$@RESOURCEVIEWBYID*'.$cmid.'@$';
                    }
                    $content = str_replace($matches[0][$i], $replace, $content);
                }
            }

            $matches = null;
            $result = preg_match_all($search2, $content, $matches, PREG_PATTERN_ORDER);

            // No resource links.
            if (!$result) {
                return $content;
            }
            // Resource ID links.
            list($insql, $params) = $DB->get_in_or_equal($matches[2]);
            $oldrecs = $DB->get_records_select('resource_old', "oldid $insql", $params, '', 'oldid, cmid, newmodule');

            for ($i = 0; $i < count($matches[0]); $i++) {
                $recordid = $matches[2][$i];
                if (isset($oldrecs[$recordid])) {
                    // Resource_old item, rewrite it
                    $replace = '$@' . strtoupper($oldrecs[$recordid]->newmodule) . 'VIEWBYID*' . $oldrecs[$recordid]->cmid . '@$';
                    $content = str_replace($matches[0][$i], $replace, $content);
                }
            }
        } else {
            $content = preg_replace($search, '$@RESOURCEVIEWBYID*$2@$', $content);
        }
        return $content;
    }
}

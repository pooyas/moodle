<?php

/**
 * @package    backup
 * @subpackage cc
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') or die('Direct access to this script is forbidden.');

class cc_label extends entities {

    public function generate_node () {

        cc2lion::log_action('Creating Labels mods');

        $response = '';

        $sheet_mod_label = cc2lion::loadsheet(SHEET_COURSE_SECTIONS_SECTION_MODS_MOD_LABEL);

        if (!empty(cc2lion::$instances['instances'][LION_TYPE_LABEL])) {
            foreach (cc2lion::$instances['instances'][LION_TYPE_LABEL] as $instance) {
                $response .= $this->create_node_course_modules_mod_label($sheet_mod_label, $instance);
            }
        }

        return $response;
    }

    private function create_node_course_modules_mod_label ($sheet_mod_label, $instance) {
        if ($instance['deep'] <= ROOT_DEEP) {
            return '';
        }

        $find_tags = array('[#mod_instance#]',
                           '[#mod_name#]',
                           '[#mod_content#]',
                           '[#date_now#]');

        $title = isset($instance['title']) && !empty($instance['title']) ? $instance['title'] : 'Untitled';
        $content = "<img src=\"$@FILEPHP@$$@SLASH@$"."files.gif\" alt=\"Folder\" title=\"{$title}\" /> {$title}";
        $replace_values = array($instance['instance'],
                                self::safexml($title),
                                self::safexml($content),
                                time());

        return str_replace($find_tags, $replace_values, $sheet_mod_label);
    }
}

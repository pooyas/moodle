<?php

/**
 * @package   lioncore
 * @subpackage backup-imscc
 * @copyright 2011 Darko Miletic (dmiletic@lionrooms.com)
 * 
 */

defined('LION_INTERNAL') or die('Direct access to this script is forbidden.');

class cc11_basiclti extends entities11 {

    public function generate_node () {

        cc2lion::log_action('Creating BasicLTI mods');

        $response = '';

        if (!empty(cc2lion::$instances['instances'][LION_TYPE_BASICLTI])) {
            foreach (cc2lion::$instances['instances'][LION_TYPE_BASICLTI] as $instance) {
                $response .= $this->create_node_course_modules_mod_basiclti($instance);
            }
        }

        return $response;
    }

    private function create_node_course_modules_mod_basiclti ($instance) {

        $sheet_mod_basiclti = cc112lion::loadsheet(SHEET_COURSE_SECTIONS_SECTION_MODS_MOD_BASICLTI);

        $topic_data = $this->get_basiclti_data($instance);

        $result = '';
        if (!empty($topic_data)) {

            $find_tags = array('[#mod_instance#]'        ,
                               '[#mod_basiclti_name#]'   ,
                               '[#mod_basiclti_intro#]'  ,
                               '[#mod_basiclti_timec#]'  ,
                               '[#mod_basiclti_timem#]'  ,
                               '[#mod_basiclti_toolurl#]',
                               '[#mod_basiclti_orgid#]'  ,
                               '[#mod_basiclti_orgurl#]' ,
                               '[#mod_basiclti_orgdesc#]'
                               );

            $replace_values = array($instance['instance'],
                                    $topic_data['title'],
                                    $topic_data['description'],
                                    time(),time(),
                                    $topic_data['launchurl'],
                                    $topic_data['orgid'],
                                    $topic_data['orgurl'],
                                    $topic_data['orgdesc']
                                    );

            $result = str_replace($find_tags, $replace_values, $sheet_mod_basiclti);

        }

        return $result;
    }

    protected function getValue($node, $default = '') {
        $result = $default;
        if (is_object($node) && ($node->length > 0) && !empty($node->item(0)->nodeValue)) {
            $result = htmlspecialchars(trim($node->item(0)->nodeValue), ENT_COMPAT, 'UTF-8', false);
        }
        return $result;
    }

    public function get_basiclti_data($instance) {

        $topic_data = '';

        $basiclti_file = $this->get_external_xml($instance['resource_indentifier']);

        if (!empty($basiclti_file)) {
            $basiclti_file_path = cc2lion::$path_to_manifest_folder . DIRECTORY_SEPARATOR . $basiclti_file;
            $basiclti_file_dir = dirname($basiclti_file_path);
            $basiclti = $this->load_xml_resource($basiclti_file_path);
            if (!empty($basiclti)) {
                $xpath = cc2lion::newx_path($basiclti, cc112lion::$basicltins);
                $topic_title = $this->getValue($xpath->query('/xmlns:cartridge_basiclti_link/blti:title'),'Untitled');
                $blti_description = $this->getValue($xpath->query('/xmlns:cartridge_basiclti_link/blti:description'));
                $launch_url = $this->getValue($xpath->query('/xmlns:cartridge_basiclti_link/blti:launch_url'));
                $tool_raw = $this->getValue($xpath->query('/xmlns:cartridge_basiclti_link/blti:vendor/lticp:code'),null);
                $tool_url = $this->getValue($xpath->query('/xmlns:cartridge_basiclti_link/blti:vendor/lticp:url'),null);
                $tool_desc = $this->getValue($xpath->query('/xmlns:cartridge_basiclti_link/blti:vendor/lticp:description'),null);
                $topic_data['title'      ] = $topic_title;
                $topic_data['description'] = $blti_description;
                $topic_data['launchurl'  ] = $launch_url;
                $topic_data['orgid'      ] = $tool_raw;
                $topic_data['orgurl'     ] = $tool_url;
                $topic_data['orgdesc'    ] = $tool_desc;
            }
        }

        return $topic_data;
    }

}


<?php

/**
 * Class repository_areafiles
 *
 * @package   repository_areafiles
 * @copyright 2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

require_once($CFG->dirroot . '/repository/lib.php');

/**
 * Main class responsible for files listing in repostiory_areafiles
 *
 * @package   repository_areafiles
 * @copyright 2015 Pooya Saeedi
 * 
 */
class repository_areafiles extends repository {
    /**
     * Areafiles plugin doesn't require login, so list all files
     *
     * @return mixed
     */
    public function print_login() {
        return $this->get_listing();
    }

    /**
     * Get file listing
     *
     * @param string $path
     * @param string $path not used by this plugin
     * @return mixed
     */
    public function get_listing($path = '', $page = '') {
        global $USER, $OUTPUT;
        $itemid = optional_param('itemid', 0, PARAM_INT);
        $env = optional_param('env', 'filepicker', PARAM_ALPHA);
        $ret = array(
            'dynload' => true,
            'nosearch' => true,
            'nologin' => true,
            'list' => array(),
        );
        if (empty($itemid) || $env !== 'editor') {
            return $ret;
        }

        // In the most cases files embedded in textarea do not have subfolders. Do not show path by default.
        $retpath = array(array('name' => get_string('files'), 'path' => ''));
        if (!empty($path)) {
            $pathchunks = preg_split('|/|', trim($path, '/'));
            foreach ($pathchunks as $i => $chunk) {
                $retpath[] = array(
                    'name' => $chunk,
                    'path' => '/'. join('/', array_slice($pathchunks, 0, $i + 1)). '/'
                );
            }
            $ret['path'] = $retpath; // Show path if already inside subfolder.
        }

        $context = context_user::instance($USER->id);
        $fs = get_file_storage();
        $files = $fs->get_directory_files($context->id, 'user', 'draft', $itemid,
                empty($path) ? '/' : $path, false, true);
        foreach ($files as $file) {
            if ($file->is_directory()) {
                $node = array(
                    'title' => basename($file->get_filepath()),
                    'path' => $file->get_filepath(),
                    'children' => array(),
                    'datemodified' => $file->get_timemodified(),
                    'datecreated' => $file->get_timecreated(),
                    'icon' => $OUTPUT->pix_url(file_folder_icon(24))->out(false),
                    'thumbnail' => $OUTPUT->pix_url(file_folder_icon(90))->out(false)
                );
                $ret['list'][] = $node;
                $ret['path'] = $retpath; // Show path if subfolders exist.
                continue;
            }
            $fileurl = lion_url::make_draftfile_url($itemid, $file->get_filepath(), $file->get_filename());
            $node = array(
                'title' => $file->get_filename(),
                'size' => $file->get_filesize(),
                'source' => $fileurl->out(),
                'datemodified' => $file->get_timemodified(),
                'datecreated' => $file->get_timecreated(),
                'author' => $file->get_author(),
                'license' => $file->get_license(),
                'isref' => $file->is_external_file(),
                'icon' => $OUTPUT->pix_url(file_file_icon($file, 24))->out(false),
                'thumbnail' => $OUTPUT->pix_url(file_file_icon($file, 90))->out(false)
            );
            if ($file->get_status() == 666) {
                $node['originalmissing'] = true;
            }
            if ($imageinfo = $file->get_imageinfo()) {
                $node['realthumbnail'] = $fileurl->out(false, array('preview' => 'thumb', 'oid' => $file->get_timemodified()));
                $node['realicon'] = $fileurl->out(false, array('preview' => 'tinyicon', 'oid' => $file->get_timemodified()));
                $node['image_width'] = $imageinfo['width'];
                $node['image_height'] = $imageinfo['height'];
            }
            $ret['list'][] = $node;
        }
        $ret['list'] = array_filter($ret['list'], array($this, 'filter'));
        return $ret;
    }

    /**
     * This plugin only can return link
     *
     * @return int
     */
    public function supported_returntypes() {
        return FILE_EXTERNAL;
    }
}
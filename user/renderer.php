<?php

/**
 * Provides user rendering functionality such as printing private files tree and displaying a search utility
 *
 * @package    core
 * @subpackage user
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Provides user rendering functionality such as printing private files tree and displaying a search utility
 * 
 */
class core_user_renderer extends plugin_renderer_base {

    /**
     * Prints user files tree view
     * @return string
     */
    public function user_files_tree() {
        return $this->render(new user_files_tree);
    }

    /**
     * Render user files tree
     *
     * @param user_files_tree $tree
     * @return string HTML
     */
    public function render_user_files_tree(user_files_tree $tree) {
        if (empty($tree->dir['subdirs']) && empty($tree->dir['files'])) {
            $html = $this->output->box(get_string('nofilesavailable', 'repository'));
        } else {
            $htmlid = 'user_files_tree_'.uniqid();
            $module = array('name' => 'core_user', 'fullpath' => '/user/module.js');
            $this->page->requires->js_init_call('M.core_user.init_tree', array(false, $htmlid), false, $module);
            $html = '<div id="'.$htmlid.'">';
            $html .= $this->htmllize_tree($tree, $tree->dir);
            $html .= '</div>';
        }
        return $html;
    }

    /**
     * Internal function - creates htmls structure suitable for YUI tree.
     * @param user_files_tree $tree
     * @param array $dir
     * @return string HTML
     */
    protected function htmllize_tree($tree, $dir) {
        global $CFG;
        $yuiconfig = array();
        $yuiconfig['type'] = 'html';

        if (empty($dir['subdirs']) and empty($dir['files'])) {
            return '';
        }
        $result = '<ul>';
        foreach ($dir['subdirs'] as $subdir) {
            $image = $this->output->pix_icon(file_folder_icon(), $subdir['dirname'], 'lion', array('class' => 'icon'));
            $result .= '<li yuiConfig=\''.json_encode($yuiconfig).'\'><div>'.$image.' '.s($subdir['dirname']).'</div> '.
                $this->htmllize_tree($tree, $subdir).'</li>';
        }
        foreach ($dir['files'] as $file) {
            $url = file_encode_url("$CFG->wwwroot/pluginfile.php", '/'.$tree->context->id.'/user/private'.
                $file->get_filepath().$file->get_filename(), true);
            $filename = $file->get_filename();
            $image = $this->output->pix_icon(file_file_icon($file), $filename, 'lion', array('class' => 'icon'));
            $result .= '<li yuiConfig=\''.json_encode($yuiconfig).'\'><div>'.$image.' '.html_writer::link($url, $filename).
                '</div></li>';
        }
        $result .= '</ul>';

        return $result;
    }

    /**
     * Prints user search utility that can search user by first initial of firstname and/or first initial of lastname
     * Prints a header with a title and the number of users found within that subset
     * @param string $url the url to return to, complete with any parameters needed for the return
     * @param string $firstinitial the first initial of the firstname
     * @param string $lastinitial the first initial of the lastname
     * @param int $usercount the amount of users meeting the search criteria
     * @param int $totalcount the amount of users of the set/subset being searched
     * @param string $heading heading of the subset being searched, default is All Participants
     * @return string html output
     */
    public function user_search($url, $firstinitial, $lastinitial, $usercount, $totalcount, $heading = null) {
        global $OUTPUT;

        $strall = get_string('all');
        $alpha  = explode(',', get_string('alphabet', 'langconfig'));

        if (!isset($heading)) {
            $heading = get_string('allparticipants');
        }

        $content = html_writer::start_tag('form', array('action' => new lion_url($url)));
        $content .= html_writer::start_tag('div');

        // Search utility heading.
        $content .= $OUTPUT->heading($heading.get_string('labelsep', 'langconfig').$usercount.'/'.$totalcount, 3);

        // Bar of first initials.
        $content .= html_writer::start_tag('div', array('class' => 'initialbar firstinitial'));
        $content .= html_writer::label(get_string('firstname').' : ', null);

        if (!empty($firstinitial)) {
            $content .= html_writer::link($url.'&sifirst=', $strall);
        } else {
            $content .= html_writer::tag('strong', $strall);
        }

        foreach ($alpha as $letter) {
            if ($letter == $firstinitial) {
                $content .= html_writer::tag('strong', $letter);
            } else {
                $content .= html_writer::link($url.'&sifirst='.$letter, $letter);
            }
        }
        $content .= html_writer::end_tag('div');

         // Bar of last initials.
        $content .= html_writer::start_tag('div', array('class' => 'initialbar lastinitial'));
        $content .= html_writer::label(get_string('lastname').' : ', null);

        if (!empty($lastinitial)) {
            $content .= html_writer::link($url.'&silast=', $strall);
        } else {
            $content .= html_writer::tag('strong', $strall);
        }

        foreach ($alpha as $letter) {
            if ($letter == $lastinitial) {
                $content .= html_writer::tag('strong', $letter);
            } else {
                $content .= html_writer::link($url.'&silast='.$letter, $letter);
            }
        }
        $content .= html_writer::end_tag('div');

        $content .= html_writer::end_tag('div');
        $content .= html_writer::tag('div', '&nbsp;');
        $content .= html_writer::end_tag('form');

        return $content;
    }

}

/**
 * User files tree
 * 
 */
class user_files_tree implements renderable {

    /**
     * @var context_user $context
     */
    public $context;

    /**
     * @var array $dir
     */
    public $dir;

    /**
     * Create user files tree object
     */
    public function __construct() {
        global $USER;
        $this->context = context_user::instance($USER->id);
        $fs = get_file_storage();
        $this->dir = $fs->get_area_tree($this->context->id, 'user', 'private', 0);
    }
}

<?php


/**
 * Folder module renderer
 *
 * @package   mod_folder
 * @copyright 2015 Pooya Saeedi  
 * 
 */
defined('LION_INTERNAL') || die();

class mod_folder_renderer extends plugin_renderer_base {

    /**
     * Returns html to display the content of mod_folder
     * (Description, folder files and optionally Edit button)
     *
     * @param stdClass $folder record from 'folder' table (please note
     *     it may not contain fields 'revision' and 'timemodified')
     * @return string
     */
    public function display_folder(stdClass $folder) {
        $output = '';
        $folderinstances = get_fast_modinfo($folder->course)->get_instances_of('folder');
        if (!isset($folderinstances[$folder->id]) ||
                !($cm = $folderinstances[$folder->id]) ||
                !($context = context_module::instance($cm->id))) {
            // Some error in parameters.
            // Don't throw any errors in renderer, just return empty string.
            // Capability to view module must be checked before calling renderer.
            return $output;
        }

        if (trim($folder->intro)) {
            if ($folder->display != FOLDER_DISPLAY_INLINE) {
                $output .= $this->output->box(format_module_intro('folder', $folder, $cm->id),
                        'generalbox', 'intro');
            } else if ($cm->showdescription) {
                // for "display inline" do not filter, filters run at display time.
                $output .= format_module_intro('folder', $folder, $cm->id, false);
            }
        }

        $foldertree = new folder_tree($folder, $cm);
        if ($folder->display == FOLDER_DISPLAY_INLINE) {
            // Display module name as the name of the root directory.
            $foldertree->dir['dirname'] = $cm->get_formatted_name();
        }
        $output .= $this->output->box($this->render($foldertree),
                'generalbox foldertree');

        // Do not append the edit button on the course page.
        if ($folder->display != FOLDER_DISPLAY_INLINE && has_capability('mod/folder:managefiles', $context)) {
            $output .= $this->output->container(
                    $this->output->single_button(new lion_url('/mod/folder/edit.php',
                    array('id' => $cm->id)), get_string('edit')),
                    'mdl-align folder-edit-button');
        }
        return $output;
    }

    public function render_folder_tree(folder_tree $tree) {
        static $treecounter = 0;

        $content = '';
        $id = 'folder_tree'. ($treecounter++);
        $content .= '<div id="'.$id.'" class="filemanager">';
        $content .= $this->htmllize_tree($tree, array('files' => array(), 'subdirs' => array($tree->dir)));
        $content .= '</div>';
        $showexpanded = true;
        if (empty($tree->folder->showexpanded)) {
            $showexpanded = false;
        }
        $this->page->requires->js_init_call('M.mod_folder.init_tree', array($id, $showexpanded));
        return $content;
    }

    /**
     * Internal function - creates htmls structure suitable for YUI tree.
     */
    protected function htmllize_tree($tree, $dir) {
        global $CFG;

        if (empty($dir['subdirs']) and empty($dir['files'])) {
            return '';
        }
        $result = '<ul>';
        foreach ($dir['subdirs'] as $subdir) {
            $image = $this->output->pix_icon(file_folder_icon(24), $subdir['dirname'], 'lion');
            $filename = html_writer::tag('span', $image, array('class' => 'fp-icon')).
                    html_writer::tag('span', s($subdir['dirname']), array('class' => 'fp-filename'));
            $filename = html_writer::tag('div', $filename, array('class' => 'fp-filename-icon'));
            $result .= html_writer::tag('li', $filename. $this->htmllize_tree($tree, $subdir));
        }
        foreach ($dir['files'] as $file) {
            $filename = $file->get_filename();
            $url = lion_url::make_pluginfile_url($file->get_contextid(), $file->get_component(),
                    $file->get_filearea(), $file->get_itemid(), $file->get_filepath(), $filename, false);
            if (file_extension_in_typegroup($filename, 'web_image')) {
                $image = $url->out(false, array('preview' => 'tinyicon', 'oid' => $file->get_timemodified()));
                $image = html_writer::empty_tag('img', array('src' => $image));
            } else {
                $image = $this->output->pix_icon(file_file_icon($file, 24), $filename, 'lion');
            }
            $filename = html_writer::tag('span', $image, array('class' => 'fp-icon')).
                    html_writer::tag('span', $filename, array('class' => 'fp-filename'));
            $filename = html_writer::tag('span',
                    html_writer::link($url->out(false, array('forcedownload' => 1)), $filename),
                    array('class' => 'fp-filename-icon'));
            $result .= html_writer::tag('li', $filename);
        }
        $result .= '</ul>';

        return $result;
    }
}

class folder_tree implements renderable {
    public $context;
    public $folder;
    public $cm;
    public $dir;

    public function __construct($folder, $cm) {
        $this->folder = $folder;
        $this->cm     = $cm;

        $this->context = context_module::instance($cm->id);
        $fs = get_file_storage();
        $this->dir = $fs->get_area_tree($this->context->id, 'mod_folder', 'content', 0);
    }
}

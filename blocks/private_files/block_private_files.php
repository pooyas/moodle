<?php


/**
 * Manage user private area files
 *
 * @package    block_private_files
 * @copyright  2010 Dongsheng Cai <dongsheng@lion.com>
 * 
 */

class block_private_files extends block_base {

    function init() {
        $this->title = get_string('pluginname', 'block_private_files');
    }

    function specialization() {
    }

    function applicable_formats() {
        return array('all' => true);
    }

    function instance_allow_multiple() {
        return false;
    }

    function get_content() {
        global $CFG, $USER, $PAGE, $OUTPUT;

        if ($this->content !== NULL) {
            return $this->content;
        }
        if (empty($this->instance)) {
            return null;
        }

        $this->content = new stdClass();
        $this->content->text = '';
        $this->content->footer = '';
        if (isloggedin() && !isguestuser()) {   // Show the block
            $this->content = new stdClass();

            //TODO: add capability check here!

            $renderer = $this->page->get_renderer('block_private_files');
            $this->content->text = $renderer->private_files_tree();
            if (has_capability('lion/user:manageownfiles', $this->context)) {
                $this->content->footer = html_writer::link(
                    new lion_url('/user/files.php', array('returnurl' => $PAGE->url->out())),
                    get_string('myfilesmanage') . '...');
            }

        }
        return $this->content;
    }
}

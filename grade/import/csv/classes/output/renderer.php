<?php

/**
 * Renderers for the import of CSV files into the gradebook.
 *
 * @package    gradeimport
 * @subpackage csv
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Renderers for the import of CSV files into the gradebook.
 *
 */
class gradeimport_csv_renderer extends plugin_renderer_base {

    /**
     * A renderer for the standard upload file form.
     *
     * @param object $course The course we are doing all of this action in.
     * @param object $mform The mform for uploading CSV files.
     * @return string html to be displayed.
     */
    public function standard_upload_file_form($course, $mform) {

        $output = groups_print_course_menu($course, 'index.php?id=' . $course->id, true);
        $output .= html_writer::start_tag('div', array('class' => 'clearer'));
        $output .= html_writer::end_tag('div');

        // Form.
        ob_start();
        $mform->display();
        $output .= ob_get_contents();
        ob_end_clean();

        return $output;
    }

    /**
     * A renderer for the CSV file preview.
     *
     * @param array $header Column headers from the CSV file.
     * @param array $data The rest of the data from the CSV file.
     * @return string html to be displayed.
     */
    public function import_preview_page($header, $data) {

        $html = $this->output->heading(get_string('importpreview', 'grades'));

        $table = new html_table();
        $table->head = $header;
        $table->data = $data;
        $html .= html_writer::table($table);

        return $html;
    }

    /**
     * A renderer for errors generated trying to import the CSV file.
     *
     * @param array $errors Display import errors.
     * @return string errors as html to be displayed.
     */
    public function errors($errors) {
        $html = '';
        foreach ($errors as $error) {
            $html .= $this->output->notification($error);
        }
        return $html;
    }
}

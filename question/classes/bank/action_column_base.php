<?php

namespace core_question\bank;

/**
 * A base class for actions that are an icon that lets you manipulate the question in some way.
 *
 * @copyright  2009 Tim Hunt
 * 
 */

abstract class action_column_base extends column_base {

    protected function get_title() {
        return '&#160;';
    }

    public function get_extra_classes() {
        return array('iconcol');
    }

    protected function print_icon($icon, $title, $url) {
        global $OUTPUT;
        echo '<a title="' . $title . '" href="' . $url . '">
                <img src="' . $OUTPUT->pix_url($icon) . '" class="iconsmall" alt="' . $title . '" /></a>';
    }

    public function get_required_fields() {
        // Createdby is required for permission checks.
        return array('q.id', 'q.createdby');
    }
}

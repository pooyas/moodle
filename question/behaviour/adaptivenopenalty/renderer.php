<?php

/**
 * Renderer for outputting parts of a question belonging to the legacy
 * adaptive (no penalties) behaviour.
 *
 * @package    qbehaviour
 * @subpackage adaptivenopenalty
 * @copyright  2009 The Open University
 * 
 */


defined('LION_INTERNAL') || die();

require_once(dirname(__FILE__) . '/../adaptive/renderer.php');


/**
 * Renderer for outputting parts of a question belonging to the legacy
 * adaptive (no penalties) behaviour.
 *
 * @copyright  2009 The Open University
 * 
 */
class qbehaviour_adaptivenopenalty_renderer extends qbehaviour_adaptive_renderer {
    protected function grading_details(qbehaviour_adaptive_mark_details $details, question_display_options $options) {
        $mark = $details->get_formatted_marks($options->markdp);
        return get_string('gradingdetails', 'qbehaviour_adaptive', $mark);
    }

    protected function disregarded_info() {
        return '';
    }
}

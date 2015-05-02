<?php

/**
 * Defines the renderer for when the actual behaviour used is not available.
 *
 * @package    qbehaviour
 * @subpackage missing
 * @copyright  2009 The Open University
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Renderer for outputting parts of a question when the actual behaviour
 * used is not available.
 *
 * @copyright  2009 The Open University
 * 
 */
class qbehaviour_missing_renderer extends qbehaviour_renderer {
    public function controls(question_attempt $qa, question_display_options $options) {
        return html_writer::tag('div',
                get_string('questionusedunknownmodel', 'qbehaviour_missing'),
                array('class' => 'warning'));
    }
}
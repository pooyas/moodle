<?php


/**
 * Defines the renderer for when the actual behaviour used is not available.
 *
 * @package    question_behaviour
 * @subpackage missing
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();


/**
 * Renderer for outputting parts of a question when the actual behaviour
 * used is not available.
 *
 */
class qbehaviour_missing_renderer extends qbehaviour_renderer {
    public function controls(question_attempt $qa, question_display_options $options) {
        return html_writer::tag('div',
                get_string('questionusedunknownmodel', 'qbehaviour_missing'),
                array('class' => 'warning'));
    }
}
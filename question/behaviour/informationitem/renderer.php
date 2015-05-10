<?php

/**
 * Defines the renderer the information item behaviour.
 *
 * @package    qbehaviour
 * @subpackage informationitem
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Renderer for outputting parts of a question belonging to the information
 * item behaviour.
 *
 */
class qbehaviour_informationitem_renderer extends qbehaviour_renderer {
    public function controls(question_attempt $qa, question_display_options $options) {
        if ($qa->get_state() != question_state::$todo) {
            return '';
        }

        // Hidden input to move the question into the complete state.
        return html_writer::empty_tag('input', array(
            'type' => 'hidden',
            'name' => $qa->get_behaviour_field_name('seen'),
            'value' => 1,
        ));
    }
}

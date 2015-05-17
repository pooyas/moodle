<?php


/**
 * Renderer for outputting parts of a question belonging to the interactive
 * behaviour.
 *
 * @package    question_behaviour
 * @subpackage interactive
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();


/**
 * Interactive behaviour renderer.
 *
 */
class qbehaviour_interactive_renderer extends qbehaviour_renderer {
    public function controls(question_attempt $qa, question_display_options $options) {
        return $this->submit_button($qa, $options);
    }

    public function feedback(question_attempt $qa, question_display_options $options) {
        if (!$qa->get_state()->is_active() || !$options->readonly) {
            return '';
        }

        $attributes = array(
            'type' => 'submit',
            'id' => $qa->get_behaviour_field_name('tryagain'),
            'name' => $qa->get_behaviour_field_name('tryagain'),
            'value' => get_string('tryagain', 'qbehaviour_interactive'),
            'class' => 'submit btn',
        );
        if ($options->readonly !== qbehaviour_interactive::READONLY_EXCEPT_TRY_AGAIN) {
            $attributes['disabled'] = 'disabled';
        }
        $output = html_writer::empty_tag('input', $attributes);
        if (empty($attributes['disabled'])) {
            $this->page->requires->js_init_call('M.core_question_engine.init_submit_button',
                    array($attributes['id'], $qa->get_slot()));
        }
        return $output;
    }
}

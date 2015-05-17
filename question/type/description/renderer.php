<?php


/**
 * Description 'question' renderer class.
 *
 * @package    question_type
 * @subpackage description
 * @copyright  2015 Pooya Saeedi
 */


defined('LION_INTERNAL') || die();


/**
 * Generates the output for description 'question's.
 *
 */
class qtype_description_renderer extends qtype_renderer {
    public function formulation_and_controls(question_attempt $qa,
            question_display_options $options) {

        return html_writer::tag('div', $qa->get_question()->format_questiontext($qa),
                array('class' => 'qtext'));
    }

    public function formulation_heading() {
        return get_string('informationtext', 'qtype_description');
    }
}

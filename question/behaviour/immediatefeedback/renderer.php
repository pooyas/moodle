<?php

/**
 * Defines the renderer for the immediate feedback behaviour.
 *
 * @package    qbehaviour
 * @subpackage immediatefeedback
 * @copyright  2015 Pooya Saeedi
 * 
 */


defined('LION_INTERNAL') || die();


/**
 * Renderer for outputting parts of a question belonging to the immediate
 * feedback behaviour.
 *
 * @copyright  2015 Pooya Saeedi
 * 
 */
class qbehaviour_immediatefeedback_renderer extends qbehaviour_renderer {
    public function controls(question_attempt $qa, question_display_options $options) {
        return $this->submit_button($qa, $options);
    }
}

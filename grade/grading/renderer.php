<?php

/**
 * Renderer for core_grading subsystem
 *
 * @package    core_grading
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * Standard HTML output renderer for core_grading subsystem
 *
 * @package    core_grading
 * @copyright  2015 Pooya Saeedi
 * 
 * @category   grading
 */
class core_grading_renderer extends plugin_renderer_base {

    /**
     * Renders the active method selector at the grading method management screen
     *
     * @param grading_manager $manager
     * @param lion_url $targeturl
     * @return string
     */
    public function management_method_selector(grading_manager $manager, lion_url $targeturl) {

        $method = $manager->get_active_method();
        $methods = $manager->get_available_methods(false);
        $methods['none'] = get_string('gradingmethodnone', 'core_grading');
        $selector = new single_select(new lion_url($targeturl, array('sesskey' => sesskey())),
            'setmethod', $methods, empty($method) ? 'none' : $method, null, 'activemethodselector');
        $selector->set_label(get_string('changeactivemethod', 'core_grading'));
        $selector->set_help_icon('gradingmethod', 'core_grading');

        return $this->output->render($selector);
    }

    /**
     * Renders an action icon at the gradng method management screen
     *
     * @param lion_url $url action URL
     * @param string $text action text
     * @param string $icon the name of the icon to use
     * @return string
     */
    public function management_action_icon(lion_url $url, $text, $icon) {

        $img = html_writer::empty_tag('img', array('src' => $this->output->pix_url($icon), 'class' => 'action-icon'));
        $txt = html_writer::tag('div', $text, array('class' => 'action-text'));
        return html_writer::link($url, $img . $txt, array('class' => 'action'));
    }

    /**
     * Renders a message for the user, typically as an action result
     *
     * @param string $message
     * @return string
     */
    public function management_message($message) {
        $this->page->requires->strings_for_js(array('clicktoclose'), 'core_grading');
        $this->page->requires->yui_module('lion-core_grading-manage', 'M.core_grading.init_manage');
        return $this->output->box(format_string($message).html_writer::tag('span', ''), 'message', 'actionresultmessagebox');
    }

    /**
     * Renders the template action icon
     *
     * @param lion_url $url action URL
     * @param string $text action text
     * @param string $icon the name of the icon to use
     * @param string $class extra class of this action
     * @return string
     */
    public function pick_action_icon(lion_url $url, $text, $icon = '', $class = '') {

        $img = html_writer::empty_tag('img', array('src' => $this->output->pix_url($icon), 'class' => 'action-icon'));
        $txt = html_writer::tag('div', $text, array('class' => 'action-text'));
        return html_writer::link($url, $img . $txt, array('class' => 'action '.$class));
    }
}

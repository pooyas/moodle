<?php

/**
 * Renderer for history grade report.
 *
 * @package    gradereport
 * @subpackage history
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace gradereport_history\output;

defined('LION_INTERNAL') || die;

/**
 * Renderer for history grade report.
 *
 */
class renderer extends \plugin_renderer_base {

    /**
     * Render for the select user button.
     *
     * @param user_button $button instance of  gradereport_history_user_button to render
     *
     * @return string HTML to display
     */
    protected function render_user_button(user_button $button) {
        $attributes = array('type'     => 'button',
                            'class'    => 'selectortrigger',
                            'value'    => $button->label,
                            'disabled' => $button->disabled ? 'disabled' : null,
                            'title'    => $button->tooltip);

        if ($button->actions) {
            $id = \html_writer::random_id('single_button');
            $attributes['id'] = $id;
            foreach ($button->actions as $action) {
                $this->add_action_handler($action, $id);
            }
        }
        // First the input element.
        $output = \html_writer::empty_tag('input', $attributes);

        // Then hidden fields.
        $params = $button->url->params();
        if ($button->method === 'post') {
            $params['sesskey'] = sesskey();
        }
        foreach ($params as $var => $val) {
            $output .= \html_writer::empty_tag('input', array('type' => 'hidden', 'name' => $var, 'value' => $val));
        }

        // Then div wrapper for xhtml strictness.
        $output = \html_writer::tag('div', $output);

        // Now the form itself around it.
        if ($button->method === 'get') {
            $url = $button->url->out_omit_querystring(true); // Url without params, the anchor part allowed.
        } else {
            $url = $button->url->out_omit_querystring();     // Url without params, the anchor part not allowed.
        }
        if ($url === '') {
            $url = '#'; // There has to be always some action.
        }
        $attributes = array('method' => $button->method,
                            'action' => $url,
                            'id'     => $button->formid);
        $output = \html_writer::tag('div', $output, $attributes);

        // Finally one more wrapper with class.
        return \html_writer::tag('div', $output, array('class' => $button->class));
    }

    /**
     * Get the html for the table.
     *
     * @param tablelog $tablelog table object.
     *
     * @return string table html
     */
    protected function render_tablelog(tablelog $tablelog) {
        $o = '';
        ob_start();
        $tablelog->out($tablelog->pagesize, false);
        $o = ob_get_contents();
        ob_end_clean();

        return $o;
    }

}

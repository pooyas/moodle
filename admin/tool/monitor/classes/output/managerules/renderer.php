<?php

/**
 * Renderer class for manage rules page.
 *
 * @package    tool_monitor
 * @copyright  2014 onwards Ankit Agarwal <ankit.agrr@gmail.com>
 * 
 */

namespace tool_monitor\output\managerules;

defined('LION_INTERNAL') || die;

/**
 * Renderer class for manage rules page.
 *
 * @since      Lion 2.8
 * @package    tool_monitor
 * @copyright  2014 onwards Ankit Agarwal <ankit.agrr@gmail.com>
 * 
 */
class renderer extends \plugin_renderer_base {

    /**
     * Get html to display on the page.
     *
     * @param renderable $renderable renderable widget
     *
     * @return string to display on the mangerules page.
     */
    protected function render_renderable(renderable $renderable) {
        $o = $this->render_table($renderable);
        $o .= $this->render_add_button($renderable->courseid);

        return $o;
    }

    /**
     * Get html to display on the page.
     *
     * @param renderable $renderable renderable widget
     *
     * @return string to display on the mangerules page.
     */
    protected function render_table(renderable $renderable) {
        $o = '';
        ob_start();
        $renderable->out($renderable->pagesize, true);
        $o = ob_get_contents();
        ob_end_clean();

        return $o;
    }

    /**
     * Html to add a button for adding a new rule.
     *
     * @param int $courseid course id.
     *
     * @return string html for the button.
     */
    protected function render_add_button($courseid) {
        global $CFG;

        $button = \html_writer::tag('button', get_string('addrule', 'tool_monitor'));
        $addurl = new \lion_url($CFG->wwwroot. '/admin/tool/monitor/edit.php', array('courseid' => $courseid));
        return \html_writer::link($addurl, $button);
    }

    /**
     * Html to add a link to go to the subscription page.
     *
     * @param lion_url $manageurl The url of the subscription page.
     *
     * @return string html for the link to the subscription page.
     */
    public function render_subscriptions_link($manageurl) {
        echo \html_writer::start_div();
        $a = \html_writer::link($manageurl, get_string('managesubscriptions', 'tool_monitor'));
        $link = \html_writer::tag('span', get_string('managesubscriptionslink', 'tool_monitor', $a));
        echo $link;
        echo \html_writer::end_div();
    }
}

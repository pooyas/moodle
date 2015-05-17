<?php


/**
 * Renderer class for manage subscriptions page.
 *
 * @package    admin_tool
 * @subpackage monitor
 * @copyright  2015 Pooya Saeedi
 */

namespace tool_monitor\output\managesubs;

defined('LION_INTERNAL') || die;

/**
 * Renderer class for manage subscriptions page.
 *
 */
class renderer extends \plugin_renderer_base {

    /**
     * Get html to display on the page.
     *
     * @param subs $renderable renderable widget
     *
     * @return string to display on the mangesubs page.
     */
    protected function render_subs(subs $renderable) {
        $o = $this->render_table($renderable);
        return $o;
    }

    /**
     * Get html to display on the page.
     *
     * @param rules $renderable renderable widget
     *
     * @return string to display on the mangesubs page.
     */
    protected function render_rules(rules $renderable) {
        $o = $this->render_course_select($renderable);
        if (!empty($renderable->totalcount)) {
            $o .= $this->render_table($renderable);
        }
        return $o;
    }

    /**
     * Get html to display on the page for select dropdown..
     *
     * @param rules $renderable renderable widget
     *
     * @return string to display on the mangesubs page.
     */
    protected function render_course_select(rules $renderable) {
        if ($select = $renderable->get_user_courses_select()) {
            return $this->render($select);
        }
    }

    /**
     * Get html to display on the page.
     *
     * @param rules|subs $renderable renderable widget
     *
     * @return string to display on the mangesubs page.
     */
    protected function render_table($renderable) {
        $o = '';
        ob_start();
        $renderable->out($renderable->pagesize, true);
        $o = ob_get_contents();
        ob_end_clean();

        return $o;
    }

    /**
     * Html to add a link to go to the rule manager page.
     *
     * @param lion_url $ruleurl The url of the rule manager page.
     *
     * @return string html for the link to the rule manager page.
     */
    public function render_rules_link($ruleurl) {
        echo \html_writer::start_div();
        $a = \html_writer::link($ruleurl, get_string('managerules', 'tool_monitor'));
        $link = \html_writer::tag('span', get_string('manageruleslink', 'tool_monitor', $a));
        echo $link;
        echo \html_writer::end_div();
    }
}

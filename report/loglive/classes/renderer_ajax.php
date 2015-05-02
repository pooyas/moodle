<?php
/**
 * Log live report ajax renderer.
 *
 * @package    report_loglive
 * @copyright  2014 onwards Ankit Agarwal <ankit.agrr@gmail.com>
 * 
 */

/**
 * Log live report ajax renderer.
 *
 * @since      Lion 2.7
 * @package    report_loglive
 * @copyright  2014 onwards Ankit Agarwal <ankit.agrr@gmail.com>
 * 
 */
class report_loglive_renderer_ajax extends plugin_renderer_base {

    /**
     * This method should never be manually called, it should only be called by process.
     * Please call the render method instead.
     *
     * @deprecated since 2.8, to be removed in 2.9
     * @param report_loglive_renderable $reportloglive
     * @return string
     */
    public function render_report_loglive_renderable(report_loglive_renderable $reportloglive) {
        debugging('Do not call this method. Please call $renderer->render($reportloglive) instead.', DEBUG_DEVELOPER);
        return $this->render($reportloglive);
    }

    /**
     * Render logs for ajax.
     *
     * @param report_loglive_renderable $reportloglive object of report_loglive_renderable.
     *
     * @return string html to be displayed to user.
     */
    protected function render_report_loglive(report_loglive_renderable $reportloglive) {
        if (empty($reportloglive->selectedlogreader)) {
            return null;
        }
        $table = $reportloglive->get_table(true);
        return $table->out($reportloglive->perpage, false);
    }
}

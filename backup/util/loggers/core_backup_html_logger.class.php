<?php


/**
 * Logger that stores HTML log data in memory, ready for later display.
 *
 * @package    backup
 * @subpackage util
 * @copyright  2015 Pooya Saeedi
 */
class core_backup_html_logger extends base_logger {
    /**
     * @var string HTML output
     */
    protected $html = '';

    protected function action($message, $level, $options = null) {
        $prefix = $this->get_prefix($level, $options);
        $depth = isset($options['depth']) ? $options['depth'] : 0;
        $this->html .= $prefix . str_repeat('&nbsp;&nbsp;', $depth) .
                s($message) . '<br/>' . PHP_EOL;
        return true;
    }

    /**
     * Gets the full HTML content of the log.
     *
     * @return string HTML content of log
     */
    public function get_html() {
        return $this->html;
    }
}

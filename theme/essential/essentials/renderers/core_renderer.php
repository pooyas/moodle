<?php


/**
 * Essentials is a basic child theme of Essential to help you as a theme
 * developer create your own child theme of Essential.
 *
 * @package    theme
 * @subpackage essential
 * @copyright  2015 Pooya Saeedi
 */
class theme_essentials_core_renderer extends theme_essential_core_renderer {
    /**
     * This renders the breadcrumbs
     * @return string $breadcrumbs
     */
    public function navbar()
    {
        $breadcrumbs = html_writer::start_tag('ul', array('class' => "breadcrumb style2"));  // If change, alter $breadcrumbstyle in header.php.
        $index = 1;
        foreach ($this->page->navbar->get_items() as $item) {
            $item->hideicon = true;
            $breadcrumbs .= html_writer::tag('li', $this->render($item), array('style' => 'z-index:' . (100 - $index) . ';'));
            $index += 1;
        }
        $breadcrumbs .= html_writer::end_tag('ul');
        return $breadcrumbs;
    }
}

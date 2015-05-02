<?php

/**
 * Mustache helper that will add JS to the end of the page.
 *
 * @package    core
 * @category   output
 * @copyright  2015 Damyon Wiese
 * 
 */

namespace core\output;

/**
 * Store a list of JS calls to insert at the end of the page.
 *
 * @copyright  2015 Damyon Wiese
 * 
 * @since      2.9
 */
class mustache_javascript_helper {

    /** @var page_requirements_manager $requires - Page requirements manager for collecting JS calls. */
    private $requires = null;

    /**
     * Create new instance of mustache javascript helper.
     *
     * @param page_requirements_manager $requires Page requirements manager.
     */
    public function __construct($requires) {
        $this->requires = $requires;
    }

    /**
     * Add the block of text to the page requires so it is appended in the footer. The
     * content of the block can contain further mustache tags which will be resolved.
     *
     * @param string $text The script content of the section.
     * @param \Mustache_LambdaHelper $helper Used to render the content of this block.
     */
    public function help($text, \Mustache_LambdaHelper $helper) {
        $this->requires->js_amd_inline($helper->render($text));
    }
}

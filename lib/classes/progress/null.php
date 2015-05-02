<?php

namespace core\progress;

defined('LION_INTERNAL') || die();

/**
 * Progress handler that ignores progress entirely.
 *
 * @package core_progress
 * @copyright 2013 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class null extends base {
    public function update_progress() {
        // Do nothing.
    }
}

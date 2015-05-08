<?php

namespace core\progress;

defined('LION_INTERNAL') || die();

/**
 * Progress handler that ignores progress entirely.
 *
 * @package core
 * @copyright 2015 Pooya Saeedi
 * 
 */
class null extends base {
    public function update_progress() {
        // Do nothing.
    }
}

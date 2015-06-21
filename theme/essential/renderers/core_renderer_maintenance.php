<?php

/**
 * Overridden core maintenance renderer.
 *
 * This renderer gets used instead of the standard core_renderer during maintenance
 * tasks such as installation and upgrade.
 * We override it in order to style those scenarios consistently with the regular
 * bootstrap look and feel.
 *
 * @package    theme_essential
 * @copyright  2014 Sam Hemelryk
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class theme_essential_core_renderer_maintenance extends core_renderer_maintenance
{
    /**
     * Renders notifications for maintenance scripts.
     *
     * We need to override this method in the same way we do for the core_renderer maintenance method
     * found above.
     * Please note this isn't required of every function, only functions used during maintenance.
     * In this case notification is used to print errors and we want pretty errors.
     *
     * @param string $message
     * @param string $classes
     * @return string
     */
    public function notification($message, $classes = 'notifyproblem')
    {
        $message = clean_text($message);
        $type = '';

        if (($classes == 'notifyproblem') || ($classes == 'notifytiny')) {
            $type = 'alert alert-error';
        }
        if ($classes == 'notifysuccess') {
            $type = 'alert alert-success';
        }
        if ($classes == 'notifymessage') {
            $type = 'alert alert-info';
        }
        if ($classes == 'redirectmessage') {
            $type = 'alert alert-block alert-info';
        }
        return "<div class=\"$type\">$message</div>";
    }

    // Essential custom bits.
    // Lion CSS file serving.
    public function get_csswww() {
        global $CFG;

        if (!$this->theme_essential_lte_ie9()) {
            if (right_to_left()) {
                $lioncss = 'essential-rtl.css';
            } else {
                $lioncss = 'essential.css';
            }

            $syscontext = context_system::instance();
            $itemid = theme_get_revision();
            $url = lion_url::make_file_url("$CFG->wwwroot/pluginfile.php", "/$syscontext->id/theme_essential/style/$itemid/$lioncss");
            $url = preg_replace('|^https?://|i', '//', $url->out(false));
            return '<link rel="stylesheet" href="'.$url.'">';
        } else {
            if (right_to_left()) {
                $lioncssone = 'essential-rtl_ie9-blessed1.css';
                $lioncsstwo = 'essential-rtl_ie9.css';
            } else {
                $lioncssone = 'essential_ie9-blessed1.css';
                $lioncsstwo = 'essential_ie9.css';
            }

            $syscontext = context_system::instance();
            $itemid = theme_get_revision();
            $urlone = lion_url::make_file_url("$CFG->wwwroot/pluginfile.php", "/$syscontext->id/theme_essential/style/$itemid/$lioncssone");
            $urlone = preg_replace('|^https?://|i', '//', $urlone->out(false));
            $urltwo = lion_url::make_file_url("$CFG->wwwroot/pluginfile.php", "/$syscontext->id/theme_essential/style/$itemid/$lioncsstwo");
            $urltwo = preg_replace('|^https?://|i', '//', $urltwo->out(false));
            return '<link rel="stylesheet" href="'.$urlone.'"><link rel="stylesheet" href="'.$urltwo.'">';
        }
    }

    /**
     * States if the browser is IE9 or less.
     */
    public function theme_essential_lte_ie9() {
        $properties = $this->theme_essential_ie_properties();
        if (!is_array($properties)) {
            return false;
        }
        // We have properties, it is a version of IE, so is it greater than 9?
        return ($properties['version'] <= 9.0);
    }

    /**
     * States if the browser is IE by returning properties, otherwise false.
     */
    public function theme_essential_ie_properties() {
        $properties = core_useragent::check_ie_properties(); // In /lib/classes/useragent.php.
        if (!is_array($properties)) {
            return false;
        } else {
            return $properties;
        }
    }
}

?>
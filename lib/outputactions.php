<?php


/**
 * Classes representing JS event handlers, used by output components.
 *
 * Please see http://docs.lion.org/en/Developement:How_Lion_outputs_HTML
 * for an overview.
 *
 * @category output
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Helper class used by other components that involve an action on the page (URL or JS).
 *
 * @category output
 */
class component_action {

    /**
     * @var string $event The DOM event that will trigger this action when caught
     */
    public $event;

    /**
     * @var string A function name to call when the button is clicked
     * The JS function you create must have two arguments:
     *      1. The event object
     *      2. An object/array of arguments ($jsfunctionargs)
     */
    public $jsfunction = false;

    /**
     * @var array An array of arguments to pass to the JS function
     */
    public $jsfunctionargs = array();

    /**
     * Constructor
     * @param string $event DOM event
     * @param string $jsfunction An optional JS function. Required if jsfunctionargs is given
     * @param array $jsfunctionargs An array of arguments to pass to the jsfunction
     */
    public function __construct($event, $jsfunction, $jsfunctionargs=array()) {
        $this->event = $event;

        $this->jsfunction = $jsfunction;
        $this->jsfunctionargs = $jsfunctionargs;

        if (!empty($this->jsfunctionargs)) {
            if (empty($this->jsfunction)) {
                throw new coding_exception('The component_action object needs a jsfunction value to pass the jsfunctionargs to.');
            }
        }
    }
}


/**
 * Confirm action
 *
 * @category output
 */
class confirm_action extends component_action {
    /**
     * Constructs the confirm action object
     *
     * @param string $message The message to display to the user when they are shown
     *    the confirm dialogue.
     * @param string $callback Deprecated since 2.7
     * @param string $continuelabel The string to use for he continue button
     * @param string $cancellabel The string to use for the cancel button
     */
    public function __construct($message, $callback = null, $continuelabel = null, $cancellabel = null) {
        if ($callback !== null) {
            debugging('The callback argument to new confirm_action() has been deprecated.' .
                    ' If you need to use a callback, please write Javascript to use lion-core-notification-confirmation ' .
                    'and attach to the provided events.',
                    DEBUG_DEVELOPER);
        }
        parent::__construct('click', 'M.util.show_confirm_dialog', array(
                'message' => $message,
                'continuelabel' => $continuelabel, 'cancellabel' => $cancellabel));
    }
}


/**
 * Component action for a popup window.
 *
 * @category output
 */
class popup_action extends component_action {

    /**
     * @var string The JS function to call for the popup
     */
    public $jsfunction = 'openpopup';

    /**
     * @var array An array of parameters that will be passed to the openpopup JS function
     */
    public $params = array(
            'height' =>  400,
            'width' => 500,
            'top' => 0,
            'left' => 0,
            'menubar' => false,
            'location' => false,
            'scrollbars' => true,
            'resizable' => true,
            'toolbar' => true,
            'status' => true,
            'directories' => false,
            'fullscreen' => false,
            'dependent' => true);

    /**
     * Constructor
     *
     * @param string $event DOM event
     * @param lion_url|string $url A lion_url object, required if no jsfunction is given
     * @param string $name The JS function to call for the popup (default 'popup')
     * @param array  $params An array of popup parameters
     */
    public function __construct($event, $url, $name='popup', $params=array()) {
        global $CFG;
        $this->name = $name;

        $url = new lion_url($url);

        if ($this->name) {
            $_name = $this->name;
            if (($_name = preg_replace("/\s/", '_', $_name)) != $this->name) {
                throw new coding_exception('The $name of a popup window shouldn\'t contain spaces - string modified. '. $this->name .' changed to '. $_name);
                $this->name = $_name;
            }
        } else {
            $this->name = 'popup';
        }

        foreach ($this->params as $var => $val) {
            if (array_key_exists($var, $params)) {
                $this->params[$var] = $params[$var];
            }
        }

        $attributes = array('url' => $url->out(false), 'name' => $name, 'options' => $this->get_js_options($params));
        if (!empty($params['fullscreen'])) {
            $attributes['fullscreen'] = 1;
        }
        parent::__construct($event, $this->jsfunction, $attributes);
    }

    /**
     * Returns a string of concatenated option->value pairs used by JS to call the popup window,
     * based on this object's variables
     *
     * @return string String of option->value pairs for JS popup function.
     */
    public function get_js_options() {
        $jsoptions = '';

        foreach ($this->params as $var => $val) {
            if (is_string($val) || is_int($val)) {
                $jsoptions .= "$var=$val,";
            } elseif (is_bool($val)) {
                $jsoptions .= ($val) ? "$var," : "$var=0,";
            }
        }

        $jsoptions = substr($jsoptions, 0, strlen($jsoptions) - 1);

        return $jsoptions;
    }
}

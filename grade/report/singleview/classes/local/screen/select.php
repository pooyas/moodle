<?php

/**
 * The gradebook simple view - initial view to select your search options
 *
 * @package    gradereport
 * @subpackage singleview
 * @copyright  2015 Pooya Saeedi
 * 
 */

namespace gradereport_singleview\local\screen;

use gradereport_singleview;
use lion_url;

defined('LION_INTERNAL') || die;

/**
 * The gradebook simple view - initial view to select your search options
 *
 */
class select extends screen {

    /**
     * Initialise this screen
     *
     * @param bool $selfitemisempty Has an item been selected (will be false)
     */
    public function init($selfitemisempty = false) {
        global $DB;

        $roleids = explode(',', get_config('lion', 'gradebookroles'));

        $this->items = array();
        foreach ($roleids as $roleid) {
            // Keeping the first user appearance.
            $this->items = $this->items + get_role_users(
                $roleid, $this->context, false, '',
                'u.id, u.lastname, u.firstname', null, $this->groupid,
                $this->perpage * $this->page, $this->perpage
            );
        }
        $this->item = $DB->get_record('course', array('id' => $this->courseid));
    }

    /**
     * Get the type of items on this screen, not valid so return false.
     *
     * @return bool
     */
    public function item_type() {
        return false;
    }

    /**
     * Return the HTML for the page.
     *
     * @return string
     */
    public function html() {
        global $OUTPUT;

        $html = '';

        $types = gradereport_singleview::valid_screens();

        foreach ($types as $type) {
            $classname = "gradereport_singleview\\local\\screen\\${type}";

            $screen = new $classname($this->courseid, null, $this->groupid);

            if (!$screen instanceof selectable_items) {
                continue;
            }

            $options = $screen->options();

            if (empty($options)) {
                continue;
            }

            $params = array(
                'id' => $this->courseid,
                'item' => $screen->item_type(),
                'group' => $this->groupid
            );

            $url = new lion_url('/grade/report/singleview/index.php', $params);

            $select = new \single_select($url, 'itemid', $options, '', array('' => $screen->select_label()));
            $select->set_label($screen->select_label(), array('class'=>'accesshide'));
            $html .= $OUTPUT->render($select);
        }
        $html = $OUTPUT->container($html, 'selectitems');

        if (empty($html)) {
            $OUTPUT->notification(get_string('noscreens', 'gradereport_singleview'));
        }

        return $html;
    }

    /**
     * Should we show the next prev selector?
     * @return bool
     */
    public function supports_next_prev() {
        return false;
    }
}

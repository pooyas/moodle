<?php

/**
 * Availability form field class.
 *
 * @package core_form
 * @category test
 * @copyright 2015 Pooya Saeedi
 * 
 */

// NOTE: no LION_INTERNAL test here, this file may be required by behat before including /config.php.

require_once(__DIR__  . '/behat_form_field.php');

/**
 * Availability form field class.
 *
 * @package core_form
 * @category test
 * @copyright 2015 Pooya Saeedi
 * 
 */
class behat_form_availability extends behat_form_textarea {

    /**
     * Sets the value(s) of an availability element.
     *
     * At present this only supports the following value 'Grouping: xxx' where
     * xxx is the name of a grouping. Additional value types can be added as
     * necessary.
     *
     * @param string $value Value code
     * @return void
     */
    public function set_value($value) {
        global $DB;
        $driver = $this->session->getDriver();

        // Check the availability condition is currently unset - we don't yet
        // support changing an existing one.
        $existing = $this->get_value();
        if ($existing && $existing !== '{"op":"&","c":[],"showc":[]}') {
            throw new Exception('Cannot automatically set availability when ' .
                    'there is existing setting - must clear manually');
        }

        // Check the value matches a supported format.
        $matches = array();
        if (!preg_match('~^\s*([^:]*):\s*(.*?)\s*$~', $value, $matches)) {
            throw new Exception('Value for availability field does not match correct ' .
                    'format. Example: "Grouping: G1"');
        }
        $type = $matches[1];
        $param = $matches[2];

        if ($this->running_javascript()) {
            switch (strtolower($type)) {
                case 'grouping' :
                    // Set a grouping condition.
                    $driver->click('//div[@class="availability-button"]/button');
                    $driver->click('//button[@id="availability_addrestriction_grouping"]');
                    $escparam = $this->session->getSelectorsHandler()->xpathLiteral($param);
                    $nodes = $driver->find(
                            '//span[contains(concat(" " , @class, " "), " availability_grouping ")]//' .
                            'option[normalize-space(.) = ' . $escparam . ']');
                    if (count($nodes) != 1) {
                        throw new Exception('Cannot find grouping in dropdown' . count($nodes));
                    }
                    $node = reset($nodes);
                    $value = $node->getValue();
                    $driver->selectOption(
                            '//span[contains(concat(" " , @class, " "), " availability_grouping ")]//' .
                            'select', $value);
                    break;

                default:
                    // We don't support other types yet. The test author must write
                    // manual 'click on that button, etc' commands.
                    throw new Exception('The availability type "' . $type .
                            '" is currently not supported - must set manually');
            }
        } else {
            $courseid = $driver->getValue('//input[@name="course"]');
            switch (strtolower($type)) {
                case 'grouping' :
                    // Define result with one grouping condition.
                    $groupingid = $DB->get_field('groupings', 'id',
                            array('courseid' => $courseid, 'name' => $param));
                    $json = \core_availability\tree::get_root_json(array(
                            \availability_grouping\condition::get_json($groupingid)));
                    break;

                default:
                    // We don't support other types yet.
                    throw new Exception('The availability type "' . $type .
                            '" is currently not supported - must set with JavaScript');
            }
            $driver->setValue('//textarea[@name="availabilityconditionsjson"]',
                    json_encode($json));
        }
    }
}

<?php

/**
 * mod_chat data generator.
 *
 * @package    core
 * @category   test
 * @copyright  2015 Pooya Saeedi
 * 
 */

defined('LION_INTERNAL') || die();

/**
 * mod_chat data generator class.
 *
 */
class mod_chat_generator extends testing_module_generator {

    /**
     * @var int keep track of how many messages have been created.
     */
    protected $messagecount = 0;

    /**
     * To be called from data reset code only,
     * do not use in tests.
     * @return void
     */
    public function reset() {
        $this->messagecount = 0;
        parent::reset();
    }

    public function create_instance($record = null, array $options = null) {
        $record = (object)(array)$record;

        if (!isset($record->keepdays)) {
            $record->keepdays = 0;
        }
        if (!isset($record->studentlogs)) {
            $record->studentlogs = 0;
        }
        if (!isset($record->chattime)) {
            $record->chattime = time() - 2;
        }
        if (!isset($record->schedule)) {
            $record->schedule = 0;
        }
        if (!isset($record->timemodified)) {
            $record->timemodified = time();
        }

        return parent::create_instance($record, (array)$options);
    }

}

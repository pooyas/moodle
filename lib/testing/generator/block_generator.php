<?php


/**
 * Block generator base class.
 *
 * @category   test
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Block generator base class.
 *
 * Extend in blocks/xxxx/tests/generator/lib.php as class block_xxxx_generator.
 *
 * @category   test
 */
abstract class testing_block_generator extends component_generator_base {
    /** @var number of created instances */
    protected $instancecount = 0;

    /**
     * To be called from data reset code only,
     * do not use in tests.
     * @return void
     */
    public function reset() {
        $this->instancecount = 0;
    }

    /**
     * Returns block name
     * @return string name of block that this class describes
     * @throws coding_exception if class invalid
     */
    public function get_blockname() {
        $matches = null;
        if (!preg_match('/^block_([a-z0-9_]+)_generator$/', get_class($this), $matches)) {
            throw new coding_exception('Invalid block generator class name: '.get_class($this));
        }

        if (empty($matches[1])) {
            throw new coding_exception('Invalid block generator class name: '.get_class($this));
        }
        return $matches[1];
    }

    /**
     * Fill in record defaults
     * @param stdClass $record
     * @return stdClass
     */
    protected function prepare_record(stdClass $record) {
        $record->blockname = $this->get_blockname();
        if (!isset($record->parentcontextid)) {
            $record->parentcontextid = context_system::instance()->id;
        }
        if (!isset($record->showinsubcontexts)) {
            $record->showinsubcontexts = 1;
        }
        if (!isset($record->pagetypepattern)) {
            $record->pagetypepattern = '';
        }
        if (!isset($record->subpagepattern)) {
            $record->subpagepattern = null;
        }
        if (!isset($record->defaultregion)) {
            $record->defaultregion = '';
        }
        if (!isset($record->defaultweight)) {
            $record->defaultweight = '';
        }
        if (!isset($record->configdata)) {
            $record->configdata = null;
        }
        return $record;
    }

    /**
     * Create a test block
     * @param array|stdClass $record
     * @param array $options
     * @return stdClass activity record
     */
    abstract public function create_instance($record = null, array $options = null);
}

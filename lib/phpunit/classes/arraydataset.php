<?php


/**
 * Array based data iterator.
 *
 * @category   phpunit
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */


/**
 * Based on array iterator code from PHPUnit documentation by Sebastian Bergmann
 * with new constructor parameter for different array types.
 *
 * @category   phpunit
 */
class phpunit_ArrayDataSet extends PHPUnit_Extensions_Database_DataSet_AbstractDataSet {
    /**
     * @var array
     */
    protected $tables = array();

    /**
     * @param array $data
     */
    public function __construct(array $data) {
        foreach ($data AS $tableName => $rows) {
            $firstrow = reset($rows);

            if (array_key_exists(0, $firstrow)) {
                // columns in first row
                $columnsInFirstRow = true;
                $columns = $firstrow;
                $key = key($rows);
                unset($rows[$key]);
            } else {
                // column name is in each row as key
                $columnsInFirstRow = false;
                $columns = array_keys($firstrow);
            }

            $metaData = new PHPUnit_Extensions_Database_DataSet_DefaultTableMetaData($tableName, $columns);
            $table = new PHPUnit_Extensions_Database_DataSet_DefaultTable($metaData);

            foreach ($rows AS $row) {
                if ($columnsInFirstRow) {
                    $row = array_combine($columns, $row);
                }
                $table->addRow($row);
            }
            $this->tables[$tableName] = $table;
        }
    }

    protected function createIterator($reverse = FALSE) {
        return new PHPUnit_Extensions_Database_DataSet_DefaultTableIterator($this->tables, $reverse);
    }

    public function getTable($tableName) {
        if (!isset($this->tables[$tableName])) {
            throw new InvalidArgumentException("$tableName is not a table in the current database.");
        }

        return $this->tables[$tableName];
    }
}

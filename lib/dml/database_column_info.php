<?php


/**
 * Database column information.
 *
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

defined('LION_INTERNAL') || die();

/**
 * Detailed database field information.
 *
 * It is based on the adodb library's ADOFieldObject object.
 * 'column' does mean 'the field' here.
 *
 */
class database_column_info {
    /**
     * Name of column - lowercase.
     * @var string
     */
    public $name;

    /**
     * Driver dependent native data type.
     * Not standardised, its used to find meta_type.
     * @var string
     */
    public $type;

    /**
     * Max length:
     *  character type - number of characters
     *  blob - number of bytes
     *  integer - number of digits
     *  float - digits left from floating point
     *  boolean - 1
     * @var int
     */
    public $max_length;

    /**
     * Scale
     * float - decimal points
     * other - null
     * @var int
     */
    public $scale;

    /**
     * True if not null, false otherwise
     * @var bool
     */
    public $not_null;

    /**
     * True if column is primary key.
     * (usually 'id').
     * @var bool
     */
    public $primary_key;

    /**
     * True if filed autoincrementing
     * (usually 'id' only)
     * @var bool
     */
    public $auto_increment;

    /**
     * True if binary
     * @var bool
     */
    public $binary;

    /**
     * True if integer unsigned, false if signed.
     * Null for other types
     * @var integer
     * @deprecated since 2.3
     */
    public $unsigned;

    /**
     * True if the default value is defined.
     * @var bool
     */
    public $has_default;

    /**
     * The default value (if defined).
     * @var string
     */
    public $default_value;

    /**
     * True if field values are unique, false if not.
     * @var bool
     */
    public $unique;

    /**
     * Standardised one character column type, uppercased and enumerated as follows:
     * R - counter (integer primary key)
     * I - integers
     * N - numbers (floats)
     * C - characters and strings
     * X - texts
     * B - binary blobs
     * L - boolean (1 bit)
     * T - timestamp - unsupported
     * D - date - unsupported
     * @var string
     */
    public $meta_type;

    /**
     * Constructor
     * @param mixed $data object or array with properties
     */
    public function __construct($data) {
        foreach ($data as $key=>$value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        switch ($this->meta_type) {
            case 'R': // normalise counters (usually 'id')
                $this->binary         = false;
                $this->has_default    = false;
                $this->default_value  = null;
                $this->unique         = true;
                break;
            case 'C':
                $this->auto_increment = false;
                $this->binary         = false;
                break;
        }
    }
}

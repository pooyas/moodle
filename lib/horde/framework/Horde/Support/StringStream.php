<?php
/**
 * Copyright 2007-2014 Horde LLC (http://www.horde.org/)
 *
 * @category Horde
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

/**
 * @category   Horde
 * @deprecated Use Horde_Stream_Wrapper_String::getStream()
 */
class Horde_Support_StringStream implements Horde_Stream_Wrapper_StringStream
{
    /* Wrapper name. */
    const WNAME = 'horde-string';

    /**
     * String data.
     *
     * @var string
     */
    protected $_string;

    /**
     * Constructor
     *
     * @param string &$string  Reference to the string to wrap as a stream
     */
    public function __construct(&$string)
    {
        $this->installWrapper();
        $this->_string =& $string;
    }

    /**
     * Return a stream handle to this string stream.
     *
     * @return resource
     */
    public function fopen()
    {
        return fopen(
            self::WNAME . '://' . spl_object_hash($this),
            'rb',
            false,
            stream_context_create(array(
                self::WNAME => array(
                    'string' => $this
                )
            ))
        );
    }

    /**
     * Return an SplFileObject representing this string stream
     *
     * @return SplFileObject
     */
    public function getFileObject()
    {
        return new SplFileObject(
            self::WNAME . '://' . spl_object_hash($this),
            'rb',
            false,
            stream_context_create(array(
                self::WNAME => array(
                    'string' => $this
                )
            ))
        );
    }

    /**
     * Install the stream wrapper if it isn't already registered.
     */
    public function installWrapper()
    {
        if (!in_array(self::WNAME, stream_get_wrappers()) &&
            !stream_wrapper_register(self::WNAME, 'Horde_Stream_Wrapper_String')) {
            throw new Exception('Unable to register stream wrapper.');
        }
    }

    /**
     * Return a reference to the wrapped string.
     *
     * @return string
     */
    public function &getString()
    {
        return $this->_string;
    }

}

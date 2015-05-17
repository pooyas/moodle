<?php
/**
 * Copyright 2012-2014 Horde LLC (http://www.horde.org/)
 *
 * See the enclosed file COPYING for license information (LGPL). If you
 * did not receive this file, see http://www.horde.org/licenses/lgpl21.
 *
 * @category  Horde
 * @package    core
 * @subpackage lib
 * @copyright  2015 Pooya Saeedi
 */

/**
 * Implementation of Horde_Stream for a PHP temporary stream.
 *
 * @category  Horde
 */
class Horde_Stream_Temp extends Horde_Stream
{
    /**
     * Constructor.
     *
     * @param array $opts  Additional configuration options:
     * <pre>
     *   - max_memory: (integer) The maximum amount of memory to allocate to
     *                 the PHP temporary stream.
     * </pre>
     *
     * @throws Horde_Stream_Exception
     */
    public function __construct(array $opts = array())
    {
        parent::__construct($opts);
    }

    /**
     * @throws Horde_Stream_Exception
     */
    protected function _init()
    {
        $cmd = 'php://temp';
        if (isset($this->_params['max_memory'])) {
            $cmd .= '/maxmemory:' . intval($this->_params['max_memory']);
        }

        if (($this->stream = @fopen($cmd, 'r+')) === false) {
            throw new Horde_Stream_Exception('Failed to open temporary memory stream.');
        }
    }

}

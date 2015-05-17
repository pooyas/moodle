<?php
/**
 * Copyright 2014 Horde LLC (http://www.horde.org/)
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
 * Implementation of Horde_Stream that uses a PHP native string variable
 * for the internal storage.
 *
 * @category  Horde
 */
class Horde_Stream_String extends Horde_Stream
{
    /**
     * Constructor.
     *
     * @param array $opts  Additional configuration options:
     * <pre>
     *   - string: (string) [REQUIRED] The PHP string.
     * </pre>
     *
     * @throws Horde_Stream_Exception
     */
    public function __construct(array $opts = array())
    {
        if (!isset($opts['string']) || !is_string($opts['string'])) {
            throw new Horde_Stream_Exception('Need a PHP string.');
        }

        $this->stream = Horde_Stream_Wrapper_String::getStream($opts['string']);
        unset($opts['string']);

        parent::__construct($opts);
    }

}

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
 * Base class for stream connection to remote mail server.
 *
 * NOTE: This class is NOT intended to be accessed outside of the package.
 * There is NO guarantees that the API of this class will not change across
 * versions.
 *
 * @category  Horde
 * @internal
 */
class Horde_Imap_Client_Socket_Connection_Base extends Horde\Socket\Client
{
    /**
     * Protocol type.
     *
     * @var string
     */
    protected $_protocol = 'imap';

    /**
     */
    protected function _connect($host, $port, $timeout, $secure, $retries = 0)
    {
        if ($retries || !$this->_params['debug']->debug) {
            $timer = null;
        } else {
            $url = new Horde_Imap_Client_Url();
            $url->hostspec = $host;
            $url->port = $port;
            $url->protocol = $this->_protocol;
            $this->_params['debug']->info(sprintf(
                'Connection to: %s',
                strval($url)
            ));

            $timer = new Horde_Support_Timer();
            $timer->push();
        }

        parent::_connect($host, $port, $timeout, $secure, $retries);

        if ($timer) {
            $this->_params['debug']->info(sprintf(
                'Server connection took %s seconds.',
                round($timer->pop(), 4)
            ));
        }
    }

}

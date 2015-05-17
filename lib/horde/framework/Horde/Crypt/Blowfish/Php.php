<?php
/**
 * Copyright 2005-2008 Matthew Fonda <mfonda@php.net>
 * Copyright 2008 Philippe Jausions <jausions@php.net>
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
 * Native PHP driver for blowfish encryption.
 *
 * @category  Horde
 */
class Horde_Crypt_Blowfish_Php extends Horde_Crypt_Blowfish_Base
{
    /**
     * Subclass object.
     *
     * @var Horde_Crypt_Blowfish_Php_Base
     */
    protected $_ob;

    /**
     */
    public function encrypt($text)
    {
        $this->_init();
        return $this->_ob->encrypt($this->_pad($text), $this->iv);
    }

    /**
     */
    public function decrypt($text)
    {
        $this->_init();
        return $this->_unpad($this->_ob->decrypt($this->_pad($text, true), $this->iv));
    }

    /**
     * Initialize the subclass.
     */
    protected function _init()
    {
        if (!isset($this->_ob) ||
            ($this->_ob->md5 != hash('md5', $this->key))) {
            switch ($this->cipher) {
            case 'cbc':
                $this->_ob = new Horde_Crypt_Blowfish_Php_Cbc($this->key);
                break;

            case 'ecb':
                $this->_ob = new Horde_Crypt_Blowfish_Php_Ecb($this->key);
                break;
            }
        }
    }

}

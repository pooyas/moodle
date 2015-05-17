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
 * PHP implementation of the Blowfish algorithm in ECB mode.
 *
 * @category  Horde
 */
class Horde_Crypt_Blowfish_Php_Ecb extends Horde_Crypt_Blowfish_Php_Base
{
    /**
     */
    public function encrypt($text, $iv)
    {
        $cipherText = '';
        $len = strlen($text);

        for ($i = 0; $i < $len; $i += 8) {
            list(, $Xl, $Xr) = unpack('N2', substr($text, $i, 8));
            $this->_encipher($Xl, $Xr);
            $cipherText .= pack('N2', $Xl, $Xr);
        }

        return $cipherText;
    }

    /**
     */
    public function decrypt($text, $iv)
    {
        $plainText = '';
        $len = strlen($text);

        for ($i = 0; $i < $len; $i += 8) {
            list(, $Xl, $Xr) = unpack('N2', substr($text, $i, 8));
            $this->_decipher($Xl, $Xr);
            $plainText .= pack('N2', $Xl, $Xr);
        }

        return $plainText;
    }

}

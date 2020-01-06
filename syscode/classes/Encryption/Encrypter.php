<?php 

/**
 * Lenevor Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file license.md.
 * It is also available through the world-wide-web at this URL:
 * https://lenevor.com/license
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@Lenevor.com so we can send you a copy immediately.
 *
 * @package     Lenevor
 * @subpackage  Base
 * @author      Javier Alexander Campo M. <jalexcam@gmail.com>
 * @link        https://lenevor.com 
 * @copyright   Copyright (c) 2019 Lenevor Framework 
 * @license     https://lenevor.com/license or see /license.md or see https://opensource.org/licenses/BSD-3-Clause New BSD license
 * @since       0.5.0
 */

namespace Syscode\Encryption;

use RuntimeException;
use Syscode\Encryption\Exceptions\DecryptException;
use Syscode\Encryption\Exceptions\EncryptException;
use Syscode\Contracts\Encryption\Encrypter as EncrypterContract;

/**
 * Lenevor Encryption Manager.
 * 
 * This class determines the cipher and mode to use of encryption.
 * 
 * @author Javier Alexander Campo M. <jalexcam@gmail.com>
 */
class Encrypter implements EncrypterContract
{
    /**
     * The algoritm used encryption.
     * 
     * @var string $cipher
     */
    protected $cipher;

    /**
     * The key / seed being used.
     * 
     * @var string $key
     */
    protected $key;

    /**
     * Constructor. Create a new Encrypter instance.
     * 
     * @param  string  $key
     * @param  string  $cipher
     * 
     * @return void
     * 
     * @throws \RuntimeException
     */
    public function __construct($key, $cipher = 'AES_128_CBC')
    {
        $this->key = (string) $key;
    }
}
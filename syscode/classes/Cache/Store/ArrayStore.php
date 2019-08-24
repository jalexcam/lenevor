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
 * @since       0.3.0
 */

namespace Syscode\Cache\Store;

use Syscode\Contracts\Cache\Store;
use Syscode\Support\InteractsWithTime;

/**
 * Array cache handler.
 * 
 * @author Javier Alexander Campo M. <jalexcam@gmail.com>
 */
class ArrayStore implements Store
{
    use InteractsWithTime;

    /**
     * The array storaged value.
     * 
     * @var array $storage
     */
    protected $storage = [];

    /**
     * Gets an item from the cache by key.
     * 
     * @param  string|array  $key
     * 
     * @return mixed
     */
    public function get($key)
    {
        if ( ! isset($this->storage[$key])) return;

        $item = $this->storage[$key];

        $expiration = $item['expiration'] ?? 0;

        if ($expiration !== 0 && $this->currenTime() > $expiration)
        {
            $this->delete($key);

            return;
        }

        return $item['value'];
    }

    /**
     * Store an item in the cache for a given number of seconds.
     * 
     * @param  string  $key
     * @param  mixed   $value
     * @param  int     $seconds
     * 
     * @return bool
     */
    public function put($key, $value, $seconds)
    {
        $this->storage[$key] = [
            'value'      => $value,
            'expiration' => $this->calcExpiration($seconds)
        ];

        return true;
    }

    /**
     * Increment the value of an item in the cache.
     * 
     * @param  string  $key
     * @param  mixed   $value  (1 by default)
     * 
     * @return int
     */
    public function increment($key, $value = 1)
    {
        if ( ! isset($this->storage[$key]))
        {
            $this->forever($key, $value);

            return $this->storage[$key]['value'];
        }

        $this->storage[$key]['value'] = ((int) $this->storage[$key]['value']) + $value;

        return $this->storage[$key]['value'];
    }

    /**
     * Decrement the value of an item in the cache.
     * 
     * @param  string  $key
     * @param  mixed   $value  (1 by default)
     * 
     * @return int
     */
    protected function decrement($key, $value = 1)
    {
        return $this->increment($key, $value * -1);
    }

    /**
     * Remove a specific item from the cache store.
     * 
     * @param  string  $key
     * 
     * @return bool
     */
    public function delete($key)
    {
        if (array_key_exists($key, $this->storage))
        {
            unset($this->storage[$key]);

            return true;
        }

        return false;
    }

    /**
     * Stores an item in the cache indefinitely.
     * 
     * @param  string  $key
     * @param  mixed   $value
     * 
     * @return bool
     */
    public function forever($key, $value)
    {
        return $this->put($key, $value, 0);
    }

    /**
     * Remove all items from the cache.
     * 
     * @return bool
     */
    public function flush()
    {
        $this->storage = [];

        return true;
    }

    /**
     * Gets the cache key prefix.
     * 
     * @return string
     */
    public function getPrefix()
    {
        return '';
    }

    /**
     * Gets the expiration time of the key.
     * 
     * @param  int  $seconds
     * 
     * @return int
     */
    protected function calcExpiration($seconds)
    {
        return $this->toTimestamp($seconds);
    }

    /**
     * Gets the UNIX timestamp for the given number of seconds.
     * 
     * @param  int  $seconds
     * 
     * @return int
     */
    protected function toTimestamp($seconds)
    {
        return $seconds > 0 ? $this->availableAt($seconds) : 0;
    }
}
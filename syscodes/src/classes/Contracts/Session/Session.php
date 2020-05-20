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
 * @copyright   Copyright (c) 2019-2020 Lenevor Framework 
 * @license     https://lenevor.com/license or see /license.md or see https://opensource.org/licenses/BSD-3-Clause New BSD license
 * @since       0.4.0
 */

namespace Syscodes\Contracts\Session;

/**
 * Expected behavior of a session container used with Lenevor.
 * 
 * @author Javier Alexander Campo M. <jalexcam@gmail.com>
 */
interface Session
{
    /**
     * Get the name of the session.
     * 
     * @return string
     */
    public function getName();

    /**
     * Start the session.
     * 
     * @return bool
     */
    public function start();

    /**
     * Get all of the session data.
     * 
     * @return array
     */
    public function all();

    /**
     * Get the current session ID.
     * 
     * @return string
     */
    public function getId();

    /**
     * Set the session ID.
     * 
     * @param  string  $id
     * 
     * @return void
     */
    public function setId($id);

    /**
     * Save the session data to storage.
     * 
     * @return void
     */
    public function save();

    /**
     * Remove one or many items from the session.
     * 
     * @param  string|array  $keys
     * 
     * @return void
     */
    public function pull($keys);

    /**
     * Push a value onto a session array.
     * 
     * @param  string  $key
     * @param  mixed  $value
     * 
     * @return void
     */
    public function push($key, $value);

    /**
     * Checks if an a key is present and not null.
     * 
     * @param  string|array  $key
     * 
     * @return void
     */
    public function has($key);

    /**
     * Get an key from the session.
     * 
     * @param  string  $key
     * @param  mixed  $default
     * 
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Put a key / value pair or array of key / value pairs in the session.
     * 
     * @param  string|array  $key
     * @param  mixed  $value
     * 
     * @return mixed
     */
    public function put($key, $value = null);

    /**
     * Remove an key from the session.
     * 
     * @param  string  $key
     * 
     * @return mixed
     */
    public function remove($key);

    /**
     * Flash a key / value pair to the session.
     * 
     * @param  string  $key
     * @param  mixed  $value  (true by default)
     * 
     * @return void
     */
    public function flash(string $key, $value = true);

    /**
     * Remove all of the keys from the session.
     * 
     * @return void
     */
    public function flush();

    /**
     * Get the CSRF token value.
     * 
     * @return string
     */
    public function token();

    /**
     * Regenerate the CSRF token value.
     * 
     * @return void
     */
    public function regenerateToken();

    /**
     * Generate a new session identifier.
     * 
     * @param  bool  $destroy
     * 
     * @return void
     */
    public function regenerate($destroy = false);

    /**
     * Generate a new session ID for the session.
     * 
     * @param  bool  $destroy
     * 
     * @return bool
     */
    public function migrate($destroy = false);

    /**
     * Determine if the session has been started.
     * 
     * @return bool
     */
    public function isStarted();
}
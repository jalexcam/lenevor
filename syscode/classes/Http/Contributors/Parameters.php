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
 * @copyright   Copyright (c) 2019 Lenevor PHP Framework 
 * @license     https://lenevor.com/license or see /license.md or see https://opensource.org/licenses/BSD-3-Clause New BSD license
 * @since       0.1.0
 */

namespace Syscode\Http\Contributors;

use Countable;
use Syscode\Support\Arr;

class Parameters implements Countable
{
	/**
	 * Array parameter from the Server global.
	 *
	 * @var array $parameter
	 */
	protected $parameters = [];

	/**
	 * Parameter Object Constructor.
	 *
	 * @param  array  $parameter
	 *
	 * @return array
	 */
	public function __construct(array $parameter = [])
	{
		$this->parameters = $parameter;
	}

	/**
	 * Get a parameter array item.
	 *
	 * @param  string       $key
	 * @param  string|null  $fallback 
	 *
	 * @return mixed
	 */
	public function get($key, $fallback = null)
	{
		if (Arr::exists($this->parameters, $key))
		{
			return $this->parameters[$key];
		}

		return $fallback;
	}

	/**
	 * Check if a parameter array item exists.
	 *
	 * @param  string  $key
	 *
	 * @return mixed
	 */
	public function has($key)
	{
		return Arr::exists($this->parameters, $key);
	}

	/**
	 * Set a parameter array item.
	 *
	 * @param  string  $key
	 * @param  string  $value 
	 *
	 * @return mixed
	 */
	public function set($key, $value)
	{
		$this->parameters[$key] = $value;
	}

	/**
	 * Remove a parameter array item.
	 *
	 * @param  string  $key 
	 *
	 * @return void
	 */
	public function remove($key)
	{
		if ($this->has($key))
		{
			unset($this->parameters[$key]);
		}
	}
	
	/**
	 * Returns the number of parameters.
	 * 
	 * @return int The number of parameters
	 */
	public function count()
	{
		return count($this->parameters);
	}
}
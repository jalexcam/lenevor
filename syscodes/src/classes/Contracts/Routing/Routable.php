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
 * @since       0.1.0
 */

namespace Syscodes\Contracts\Routing;

use Syscodes\Routing\Route;

/**
 * All Lenevor routes are defined in your route files, which are located in the routes 
 * directory and called depending on the HTTP verbs used by the user.
 * 
 * @author Javier Alexander Campo M. <jalexcam@gmail.com>
 */
interface Routable
{
	/**
	 * Add a route. 
	 *
	 * @param  \Syscodes\Routing\Route  $route
	 *
	 * @return \Syscodes\Routing\Route
	 */
	public function addRoute(Route $route);

	/**
	 * Add a route for all posible methods.
	 *
	 * @param  string  $route
	 * @param  \Closure|array|string  $action
	 *
	 * @return void
	 */
	public function any($route, $action);

	/**
	 * Add a route with delete method.
	 *
	 * @param  string  $route
	 * @param  \Closure|array|string  $action
	 *
	 * @return void
	 */
	public function delete($route, $action);

	/**
	 * Add a route with get method.
	 * 
	 * @param  string  $route
	 * @param  \Closure|array|string  $action
	 *
	 * @return void
	 */
	public function get($route, $action);

	/**
	 * Add a route with head method.
	 *
	 * @param  string  $route
	 * @param  \Closure|array|string  $action
	 *
	 * @return void
	 */
	public function head($route, $action);

	/**
	 * Add a route with options method
	 *
	 * @param  string  $route
	 * @param  \Closure|array|string  $action
	 *
	 * @return void
	 */
	public function options($route, $action);

	/**
	 * Add a route with patch method.
	 *
	 * @param  string  $route
	 * @param  \Closure|array|string  $action
	 *
	 * @return void
	 */
	public function patch($route, $action);

	/**
	 * Add a route with post method.
	 *
	 * @param  string  $route
	 * @param  \Closure|array|string  $action
	 *
	 * @return void
	 */
	public function post($route, $action);

	/**
	 * Add a route with put method.
	 *
	 * @param  string  $route
	 * @param  \Closure|array|string  $action
	 *
	 * @return void
	 */
	public function put($route, $action);
}
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

namespace Syscode\Core\Http\Exceptions;

use Throwable;

/**
 * It is activated when the multimedia format of the requested data is not supported 
 * by the server, for which reason the server rejects the request.
 * 
 * @author Javier Alexander Campo M. <jalexcam@gmail.com>
 */
class UnsupportedMediaTypeHttpException extends HttpException
{
	/**
	 * Initialize constructor. 
	 * 
	 * @param  string      $message  
	 * @param  \Throwable  $previous
	 * @param  int         $code
	 * @param  array       $headers
	 * 
	 * @return void
	 */
	public function __construct(string $message = null, Throwable $previous = null, int $code = 0, array $headers = [])
	{		
		parent::__construct(415, $message, $previous, $headers, $code);
	}
}
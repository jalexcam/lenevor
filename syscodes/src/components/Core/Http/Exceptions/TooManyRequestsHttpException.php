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
 * @copyright   Copyright (c) 2019-2021 Lenevor Framework 
 * @license     https://lenevor.com/license or see /license.md or see https://opensource.org/licenses/BSD-3-Clause New BSD license
 * @since       0.7.3
 */

namespace Syscodes\Core\Http\Exceptions;

use Throwable;

/**
 * It is activated when the user has sent too many requests in a given period of time.
 * 
 * @author Javier Alexander Campo M. <jalexcam@gmail.com>
 */
class TooManyRequestsHttpException extends HttpSpecializedException
{
	/**
	 * Get the HTTP status code.
	 * 
	 * @var int $code
	 */
	protected $code = 429;
	
	/**
	 * Get the HTTP message.
	 * 
	 * @var string $message
	 */
	protected $message = 'Too Many Requests';

	/**
	 * Get the title page exception.
	 * 
	 * @var string $title
	 */
	protected $title = 'Too Many Requests';

	/**
	 * Initialize constructor. 
	 * 
	 * @param  int|string|null  $retryAfter  The number of seconds or HTTP-date after 
	 * 										 which the request may be retried  (null by default)
	 * @param  string|null  $message  (null by default)
	 * @param  \Throwable|null  $previous  (null by default)
	 * @param  array  $headers
	 * 
	 * @return void
	 */
	public function __construct($retryAfter = null, string $message = null, Throwable $previous = null, array $headers = [])
	{		
		if ($retryAfter)
		{
			$headers['Retry-After'] = $retryAfter;
		}

		parent::__construct($this->message, $previous, $headers);
	}
}
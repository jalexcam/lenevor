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
 * HttpException.
 * 
 * @author Javier Alexander Campo M. <jalexcam@gmail.com>
 */
class HttpException extends LenevorException
{
	/**
	 * Loader the Status Code HTTP.
	 * 
	 * @var int $code
	 */
	protected $code;

	/**
	 * Loader the headers HTTP.
	 * 
	 * @var array $headers 
	 */
	protected $headers;

	/**
	 * Get the title page exception.
	 * 
	 * @var string $title
	 */
	protected $title = '';

	/**
	 * Initialize constructor. 
	 * 
	 * @param  int  $statusCode
	 * @param  string  $message  
	 * @param  \Throwable  $previous 
	 * @param  array  $headers
	 * @param  int  $code
	 * 
	 * @return void
	 * 
	 * @throws \Syscodes\Core\Http\Exceptions\LenevorException
	 */
	public function __construct(int $statusCode, string $message = null, Throwable $previous = null, array $headers = [], ?int $code = 0)
	{
		$this->headers = $headers;
		$this->code    = $statusCode;
		
		parent::__construct($message, $code, $previous);
	}

	/**
	 * Get Status Code headers.
	 * 
	 * @return int
	 */
	public function getStatusCode()
	{
		return $this->code;
	}
	
	/**
	 * Get response headers.
	 * 
	 * @return array
	 */
	public function getHeaders()
	{
		return $this->headers;
	}
	
	/**
	 * Set response headers.
	 * 
	 * @param  array  $headers  Response headers
	 * 
	 * @return mixed
	 */
	public function setHeaders(array $headers)
	{
		$this->headers = $headers;
	}

	/**
	 * Get the title page exception.
	 * 
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * Set the title page exception.
	 * 
	 * @param  string  $title
	 * 
	 * @return $this
	 */
	public function setTitle(string $title)
	{
		$this->title = $title;

		return $this;
	}
}
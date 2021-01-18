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
 * @link        https://lenevor.com
 * @copyright   Copyright (c) 2019 - 2021 Alexander Campo <jalexcam@gmail.com>
 * @license     https://opensource.org/licenses/BSD-3-Clause New BSD license or see https://lenevor.com/license or see /license.md
 * @since       0.1.2
 */

namespace Syscodes\Debug\FrameHandler;

use Throwable;

/**
 * Loads the frames to identify a possible exception.
 * 
 * @author Alexander Campo <jalexcam@gmail.com>
 */
class Supervisor
{
	/**
	 * Get exception. 
	 * 
	 * @var \Throwable $exception
	 */
	protected $exception;

	/**
	 * The frame execute errors.
	 * 
	 * @var string $frames
	 */
	protected $frames;

	/**
	 * Constructor. The Supervisor class instance.
	 * 
	 * @param  \Throwable  $exception
	 * 
	 * @return string
	 */
	public function __construct($exception)
	{
		$this->exception = $exception;
	}
	
	/**
	 * Returns an iterator for the inspected exception's frames.
	 * 
	 * @param  \Throwable  $exception
	 * 
	 * @return array 
	 */
	public function getFrames()
	{
		if ($this->frames === null)
		{
			$frames = $this->getTrace($this->exception);	

			// Fill empty line/file info for call_user_func_array usages 
			foreach ($frames as $k => $frame) 
			{
				if (empty($frame['file']))
				{
					// Default values when file and line are missing
					$file = '[PHP internal Code]';
					$line = 0;
					$next_frame = ! empty($frames[$k + 1]) ? $frames[$k + 1] : [];
					$frames[$k]['file'] = $file;
					$frames[$k]['line'] = $line;
				}
			}
			
			// Find latest non-error handling frame index ($i) used to remove error handling frames
			$i = 0;

			foreach ($frames as $k => $frame)
			{
				if ($frame['file'] == $this->exception->getFile() && $frame['line'] == $this->exception->getLine())
				{
					$i = $k;
				}
			}
			// Remove error handling frames
			if ($i > 0)
			{
				array_splice($frames, 0, $i);
			}
	
			$firstFrame = $this->getFrameFromException($this->exception);	
			array_unshift($frames, $firstFrame);

			$this->frames = new Collection($frames);
		}

		return $this->frames;
	}

	/**
	 * Given an exception, generates an array in the format generated by Exception::getTrace().
	 * 
	 * @param  \Throwable  $exception
	 * 
	 * @return array
	 */
	protected function getFrameFromException(Throwable $exception)
	{
		return [
			'file'  => $exception->getFile(),
			'line'  => $exception->getLine(),
			'class' => get_class($exception),
			'code'  => $exception->getCode(),
			'args'  => [
				$exception->getMessage(),
			],
		];
	}

	/**
	 * Gets exception already specified.
	 * 
	 * @return \Throwable
	 */
	public function getException()
	{
		return $this->exception;
	}

	/**
	 * Gets the message of exception.
	 * 
	 * @return string
	 */
	public function getExceptionMessage()
	{
		return $this->exception->getMessage();
	}

	/**
	 * Gets the class name of exception.
	 * 
	 * @return string
	 */
	public function getExceptionName()
	{
		return getClass($this->exception);
	}
	
	/**
	 * Gets the backtrace from an exception.
	 * 
	 * @param  \Throwable  $exception
	 * 
	 * @return array
	 */
	protected function getTrace($exception)
	{
		$traces = $exception->getTrace();

		if ( ! $exception instanceof ErrorException)
		{
			return $traces;
		}

		if ( ! extension_loaded('xdebug') || ! xdebug_is_enabled()) 
		{
			return [];
		}
		
		// Use xdebug to get the full stack trace and remove the shutdown handler stack trace
		$stack = array_reverse(xdebug_get_function_stack());
		$trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
		$traces = array_diff_key($stack, $trace);
		
		return $traces;
	}
}
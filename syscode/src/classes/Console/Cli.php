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
 * @since       0.1.1
 */

namespace Syscode\Console;

use Exception;
use Syscode\Support\Arr;
use Syscode\Contracts\Core\Lenevor;
use Syscode\Core\Http\Exceptions\LenevorException;

/**
 * Set of static methods useful for CLI request handling.
 * 
 * @author Javier Alexander Campo M. <jalexcam@gmail.com>
 */
class Cli
{
	/**
	 * Indicates that you do not use any color for foreground or background.
	 *
	 * @var bool $noColor
	 */
	public static $noColor = false;

	/**
	 * Readline Support for command line.
	 *
	 * @var bool $readlineSupport
	 */
	public static $readlineSupport = false;

	/**
	 * Message that tells the user that he is waiting to receive an order.
	 *
	 * @var string $waitMsg
	 */
	public static $waitMsg = 'Press any key to continue...';

	/**
	 * String of arguments to be used in console.
	 *
	 * @var array $args
	 */
	protected static $args = [];

	/**
 	 * Background color identifier.
 	 *
 	 * @var array $backgroundColor
 	 */
 	protected static $backgroundColors = [
 		'black'      => '40',
 		'red'        => '41',
 		'green'      => '42',
 		'yellow'     => '43',
 		'blue'       => '44',
 		'magenta'    => '45',
 		'cyan'       => '46',
 		'light_gray' => '47'
 	];

	/**
	 * Foreground color identifier.
 	 *
 	 * @var array $foregroundColor
	 */
	protected static $foregroundColors = [
		'black'         => '0;30',
		'dark_gray'     => '1;30',
		'blue'          => '0;34',
		'dark_blue'     => '1;34',
		'light_blue'    => '1;34',
		'green'         => '0;32',
		'light_green'   => '1;32',
		'cyan'          => '0;36', 
		'light_cyan'    => '1;36',
		'red'           => '0;31',
		'light_red'     => '1;31',
		'purple'        => '0;35',
		'light_purple'  => '1;35',
		'light_yellow'  => '0;33',
		'yellow'        => '1;33',
		'light_gray'    => '0;37',
		'white'         => '1;37'
 	];

 	/**
 	 * The standar STDERR is where the application writes its error messages.
 	 *
 	 * @var string $stderr 
 	 */
 	protected static $stderr;

 	/**
 	 * The estandar STDOUT is where the application records its output messages.
 	 *
 	 * @var string $stdout
 	 */
 	protected static $stdout;

 	/**
 	 * Beeps a certain number of times.
	 *
	 * @param  int  $num  The number of times to beep
	 *
 	 * @return int
 	 */
 	public static function bell(int $num = 1)
 	{
 		echo str_repeat("\x07", $num);
 	}

 	/**
 	 * Clears the screen of output.
 	 *
 	 * @return void
 	 */
 	public static function clearScreen()
 	{
 		static::isWindows() 

 			// Windows doesn't work for this, but their terminal is tiny so shove this in
 			? static::newLine(40)

 			// Anything with a flair of Unix will handle these magic characters
 			: fwrite(static::$stdout, chr(27)."[H".chr(27)."[2J");
 	}

 	/**
 	 * Returns the given text with the correct color codes for a foreground and
	 * optionally a background color.
 	 *
 	 * @param  string  $text  The text to color
 	 * @param  string  $foreground  The foreground color
 	 * @param  string  $background  The background color
 	 * @param  string  $format  Other formatting to apply. Currently only 'underline' is understood
 	 *
 	 * @return string  The color coded string
 	 *
 	 * @throws \Syscode\Core\Exceptions\LenevorException
 	 */
 	public static function color(string $text, string $foreground, string $background = null, string $format = null)
 	{
 		if (static::$noColor)
 		{
 			return $text;
 		}

 		if ( ! Arr::exists(static::$foregroundColors, $foreground))
 		{
 			throw new LenevorException(static::error("Invalid CLI foreground color: {$foreground}."));
 		}

 		if ( $background !== null && ! Arr::exists(static::$backgroundColors, $background))
 		{
 			throw new LenevorException(static::error("Invalid CLI background color: {$background}."));
 		}

 		$string = "\033[".static::$foregroundColors[$foreground]."m";

 		if ($background !== null)
 		{
 			$string .= "\033[".static::$backgroundColors[$background]."m";
 		}

 		if ($format === 'underline')
 		{
 			$string .= "\033[4m";
 		}

 		$string .= $text."\033[0m";

 		return $string;
 	}

 	/**
 	 * Outputs an error to the CLI using STDERR instead of STDOUT.
 	 *
 	 * @param  string|array  $text  The text to output, or array of errors
 	 * @param  string  $foreground  The foreground color
 	 * @param  string|null  $background  the background color
 	 *
 	 * @return string
 	 */
 	public static function error(string $text = '', string $foreground = 'light_red', string $background = null)
 	{
		if (is_array($text))
		{
			$text = implode(PHP_EOL, $text);
		}
		
		if ($foreground || $background)
		{
			$text = static::color($text, $foreground, $background);
		}
		
		fwrite(static::$stderr, $text.PHP_EOL);
	}

 	/**
	 * Static constructor. Parses all the CLI params.
	 * 
	 * @return string
	 * 
	 * @uses   \Syscode\Contracts\Core\Lenevor
	 * 
	 * @throws \Exception
	 */
 	public static function initialize(Lenevor $core)
 	{
 		if ( ! $core->initCli())
 		{
			throw new Exception('Cli class cannot be used outside of the command line');
 		}

 		for ($i = 1; $i < $_SERVER['argc']; $i++)
		{
			$arg = explode('=', $_SERVER['argv'][$i]);

			static::$args[$i] = $arg[0];

			if (count($arg) > 1 || strncmp($arg[0], '-', 1) === 0)
			{
				static::$args[ltrim($arg[0], '-')] = isset($arg[1]) ? $arg[1] : true;
			}
		}

 		// Readline is an extension for PHP that makes interactive the command console
 		static::$readlineSupport = extension_loaded('readline');

 		// Writes its error messages
 		static::$stderr = STDERR;

 		// Records its output messages
 		static::$stdout = STDOUT;
 	}

 	/**
 	 * Get input from the shell, using readline or the standard STDIN.
 	 *
 	 * @param  string|int  $prefix  The name of the option (int if unnamed)
 	 *
 	 * @return string
 	 */
 	public static function input($prefix = '')
 	{
 		if (static::$readlineSupport)
 		{
 			return readline($prefix);
 		}

 		echo $prefix;

 		return fgets(STDIN);
 	}

 	/**
 	 * If operating system === windows.
 	 * 
 	 * @return string
 	 */
 	public static function isWindows()
 	{
 		return 'win' === strtolower(substr(php_uname("s"), 0, 3));
 	}

 	/**
 	 * Enter a number of empty lines.
 	 * 
 	 * @param  int  $num  Number of lines to output
 	 *
 	 * @return void
 	 */
 	public static function newLine(int $num = 1)
 	{
 		for ($i = 0; $i < $num; $i++)
 		{			
 			static::write();
 		}
 	}

 	/**
	 * Returns the option with the given name. You can also give the option number.
	 *
	 * @param  string|int  $name  The name of the option (int if unnamed)
	 * @param  mixed  $default  The value to return if the option is not defined
	 *
	 * @return mixed
	 * 
	 * @use    \Syscode\Contract\Core\Lenevor
	 */
 	public static function option($name, $default = null)
 	{
 		if ( ! isset(static::$args[$name]))
 		{
 			return Lenevor::value($default);
 		}

 		return static::$args[$name];
 	}

 	/**
 	 * Asks the user for input.  This can have either 1 or 2 arguments.
	 *
	 * Usage:
	 *
	 * // Waits for any key press
	 * CLI::prompt();
	 *
	 * // Takes any input
	 * $color = CLI::prompt('What is your favorite color?');
	 *
	 * // Takes any input, but offers default
	 * $color = CLI::prompt('What is your favourite color?', 'white');
	 *
	 * // Will only accept the options in the array
	 * $ready = CLI::prompt('Are you ready?', array('y','n'));
	 *
	 * @return string The user input
	 */
 	public static function prompt()
 	{
 		$args = func_get_args();

		$options = [];
		$output  = '';
		$default = null;

		// How many we got
		$arg_count = count($args);

		// Is the last argument a boolean? True means required
		$required = end($args) === true;

		// Reduce the argument count if required was passed, we don't care about that anymore
		$required === true and --$arg_count;

		// This method can take a few crazy combinations of arguments, so lets work it out
		switch ($arg_count)
		{
			case 2:

				// E.g: $ready = CLI::prompt('Are you ready?', ['y','n']);
				if (is_array($args[1]))
				{
					list($output, $options) = $args;
				}

				// E.g: $color = CLI::prompt('What is your favourite color?', 'white');
				elseif (is_string($args[1]))
				{
					list($output, $default) = $args;
				}

			break;

			case 1:

				// No question (probably been asked already) so just show options
				// E.g: $ready = CLI::prompt(array('y','n'));
				if (is_array($args[0]))
				{
					$options = $args[0];
				}

				// Question without options
				// E.g: $ready = CLI::prompt('What did you do today?');
				elseif (is_string($args[0]))
				{
					$output = $args[0];
				}

			break;
		}

		// If a question has been asked with the read
		if ($output !== '')
		{
			$extra_output = '';

			if ($default !== null)
			{
				$extra_output = ' [ Default: "'.$default.'" ]';
			}
			elseif ($options !== [])
			{
				$extra_output = ' [ '.implode(' | ', $options).' ]';
			}

			fwrite(static::$stdout, $output.$extra_output.': ');
		}

		// Read the input from keyboard.
		$input = trim(static::input()) ?: $default;

		// No input provided and we require one (default will stop this being called)
		if (empty($input) and $required === true)
		{
			static::write('This is required.');
			static::newLine();

			$input = forward_static_call_array([__CLASS__, 'prompt'], $args);
		}

		// If options are provided and the choice is not in the array, tell them to try again
		if ( ! empty($options) and ! in_array($input, $options))
		{
			static::write('This is not a valid option. Please try again.');
			static::newLine();

			$input = forward_static_call_array([__CLASS__, 'prompt'], $args);
		}

		return $input;
 	}

 	/**
 	 * Allows you to set a commandline option from code.
 	 *
 	 * @param  string|int  $name  The name of the option (int if unnamed)
	 * @param  mixed|null  $value  The value to set, or null to delete the option
	 *
	 * @return mixed
	 */
 	public static function setOption($name, $value = null)
 	{
 		if ($value == null)
 		{
 			if (isset(static::$args[$name]))
 			{
 				unset(static::$args[$name]);
 			}
 		}
 		else
 		{
 			static::$args[$name] = $value;
 		}
 	}

 	/**
 	 * Waits a certain number of seconds, optionally showing a wait message and
	 * waiting for a key press.
 	 *
 	 * @param  int  $seconds  Number of seconds
 	 * @param  bool  $countdown  Show a countdown or not
 	 *
 	 * @return string
 	 */
 	public static function wait(int $seconds = 0, bool $countdown = false)
 	{
 		if ($countdown === true)
 		{
			$time = $seconds;

 			while ($time > 0)
 			{
 				fwrite(static::$stdout, $time.'... ');
 				sleep(1);
 				$time--;
 			}

 			static::write();
 		}
 		else
 		{
 			if ($seconds = 0)
 			{
 				sleep($seconds);
 			}
 			else
 			{
 				static::write(static::$waitMsg);
 				static::input();
 			}
 		}
 	}

 	/**
 	 * Outputs a string to the cli.	If you send an array it will implode them 
 	 * with a line break.
 	 * 
 	 * @param  string|array  $text  The text to output, or array of lines
 	 * @param  string|null  $foreground  The foreground color
 	 * @param  string|null  $background  The background color
 	 *
 	 * @return string
 	 */
 	public static function write(string $text = '', string $foreground = null, string $background = null)
 	{
 		if (is_array($text))
 		{
 			$text = implode(PHP_EOL, $text);
 		}

 		if ($foreground OR $background)
 		{
 			$text = static::color($text, $foreground, $background);
 		}

 		fwrite(static::$stdout, $text.PHP_EOL);
 	}
}
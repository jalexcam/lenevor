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

namespace Syscode\Filesystem;

/**
 * This class loads an array of mime types.
 * to help identify allowed file types.
 * 
 * @author Javier Alexander Campo M. <jalexcam@gmail.com>
 */
class FileMimeType
{
	/**
	 * Map of extensions to mime types.
	 *
	 * @var array $mimes
	 */
	public static $mimes = [];

	/**
	 * Constructor with an optional verification that the path is 
	 * really a mimes.
	 *
	 * @return mixed
	 */
	public function __construct()
	{
		static::$mimes = (array) require CON_PATH.'mimes.php';
	}

	/**
	 * Attempts to determine the best mime type for the given file extension.
	 *
	 * @param  string  $extension
	 *
	 * @return string|null  The mime type found, or none if unable to determine
	 */
	public static function guessTypeFromExtension($extension)
	{
		$extension = trim(strtolower($extension), '. ');

		if ( ! array_key_exists($extension, static::$mimes))
		{
			return null;
		}
		
		return is_array(static::$mimes[$extension]) ? static::$mimes[$extension][0] : static::$mimes[$extension];
	}

	/**
	 * Attempts to determine the best file extension for a given mime type.
	 *
	 * @param  string  $type
	 *
	 * @return string|null The extension determined, or null if unable to match
	 */
	public static function guessExtensionFromType($type)
	{
		$type = trim(strtolower($type), '. ');

		foreach (static::$mimes as $ext => $types)
		{
			if (is_string($types) && $types == $type)
			{
				return $ext;
			}
			else if (is_array($types) && in_array($type, $types))
			{
				return $ext;
			}
		}

		return null;
	}
}
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
 * @since       0.1.0
 */

namespace Syscode\Support\Facades;

use Syscode\Support\Chronos;

/**
 * Initialize the Date class facade.
 *
 * @author Javier Alexander Campo M. <jalexcam@gmail.com>
 */
class Date extends Facade
{
    const DEFAULT_FACADE = Chronos::class;

    /**
     * Get the registered name of the component.
     * 
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'date';
    }
    
    /**
     * Resolve the facade root instance from the container.
     * 
     * @param  string  $name
     * 
     * @return mixed
     */
    protected static function resolveFacadeInstance($name)
    {
        if ( ! isset(static::$resolvedInstance[$name]) && ! isset(static::$app, static::$app[$name]))
        {
            $class = static::DEFAULT_FACADE;
            static::swap(new $class);
        }
        
        return parent::resolveFacadeInstance($name);
    }
}
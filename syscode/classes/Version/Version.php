<?php 

namespace Syscode;

/**
 * Lenevor PHP Framework
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
 * @copyright   Copyright (c) 2018-2019 Lenevor Framework 
 * @license     https://lenevor.com/license or see /license.md or see https://opensource.org/licenses/BSD-3-Clause New BSD license
 * @since       0.1.0
 */
final class Version 
{
    /**
     * Product name.
     */
    const PRODUCT = 'Lenevor Framework';

    /** 
     * Version Lenevor.
     */
    const RELEASE = '0.1.0';

    /**
     * Release status.
     */
    const STATUS = 'alpha.1';

    /**
     * The codename in key.
     */
    const CODENAME = 'Polaris';

    /**
     * Data version.
     */
    const RELEASEDATE = 'Created 14-Abr-2018';

    /**
     * Copyright information.
     */
    const COPYRIGHT = 'All rights reserved';
    
    /**
     * Product copyrighting.
     */
    const COPY = '&copy';

    /**
     * Year actual.
     */
    const YEAR = '2019';

    /**
     * Gets a string version of " PHP normalized" for the Lenevor Framework.
     *
     * @return string  Short version
     */
    public static function shortVersion()
    {
        return self::COPY.' '.self::YEAR.' '.self::PRODUCT; 
    }

    /**
     * Gets a string version Lenevor under real All information Release.
     * 
     * @return string  Complete version
     */
    public static function longVersion()
    {
        return self::COPY.' '.self::YEAR.' '.self::COPYRIGHT.' - '.self::PRODUCT.' ' .self::RELEASE. ' '. 
               self::STATUS.' [ '.self::CODENAME.' ] '.self::RELEASEDATE;
    }
}
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
 */

namespace Syscodes\Support;

use DateTime;
use DateInterval;

/**
 * Interacts with time.
 * 
 * @author Alexander Campo <jalexcam@gmail.com>
 */
trait InteractsWithTime
{
    /**
     * Get the number of seconds until the given DateTime.
     * 
     * @param  \DateTime|\DateInterval|int  $delay
     * 
     * @return int
     */
    protected function secondsUntil($delay)
    {
        $delay = $this->parseDateInterval($delay);

        return $delay instanceof DateTime
                            ? max(0, $delay->getTimestamp() - $this->currentTime())
                            : (int) $delay;
    }

    /**
     * Get the "available at" UNIX timestamp.
     * 
     * @param  \DataTime|\DateInterval|int  $delay  
     * 
     * @return int
     */
    protected function availableAt($delay = 0)
    {
        $delay = $this->parseDateInterval($delay);

        return $delay instanceof DateTime
                            ? $delay->getTimestamp()
                            : $this->addRealSeconds($delay)->getTimestamp();
    }

    /**
     * If the given value is an interval, convert it to a DateTime instance.
     * 
     * @param  \DateTime|\DateInterval|int  $delay
     * 
     * @return \DateTime|int
     */
    protected function parseDateInterval($delay)
    {
        if ($delay instanceof DateInterval) {
            $delay = Chronos::now()->add($delay);
        }

        return $delay;
    }

    /**
     * Get the current system time as a UNIX timestamp.
     *
     * @return int
     */
    protected function currentTime()
    {
        return Chronos::now()->getTimestamp();
    }

    /**
     * Add seconds to the instance using timestamp.
     * 
     * @param  int  $value
     * 
     * @return static
     */
    public function addRealSeconds($value)
    {
        return Chronos::now()->setTimestamp(Chronos::now()->getTimestamp() + $value);
    }
}
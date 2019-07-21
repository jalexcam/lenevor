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
 * @since       0.1.1
 */

namespace Syscode\Routing;

use Syscode\Http\{ 
    Uri,
    RedirectResponse
};

/**
 * Returns redirect of the routes defined by the user.
 * 
 * @author Javier Alexander Campo M. <jalexcam@gmail.com>
 */
class Redirector
{
    /**
     * The URL generator instance.
     * 
     * @var string $generator
     */
    protected $generator;

    /**
     * Constructor. The Redirector class instance.
     * 
     * @param  \Syscode\Routing\UrlGenerator  $generator
     * 
     * @return void
     */
    public function __construct(UrlGenerator $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Create a new redirect response to the given path.
     * 
     * @param  string     $path
     * @param  int        $status
     * @param  array      $headers
     * @param  bool|null  $secure
     * 
     * @return \Syscode\Http\RedirectResponse
     */
    public function to($path, $status = 302, $headers = [], $secure = null)
    {
        return $this->createRedirect($this->generator->to($path, [], $secure), $status, $headers);
    }

    /**
     * Creates a new redirect response.
     * 
     * @param  string  $path
     * @param  int     $status
     * @param  array   $headers
     * 
     * @return \Syscode\Http\RedirectResponse
     */
    public function createRedirect($path, $status, $headers)
    {
        return new RedirectResponse($path, $status, $headers);
    }
}
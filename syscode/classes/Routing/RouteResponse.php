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
 * @since       0.4.0
 */

namespace Syscode\Routing;

use Syscode\Http\Response;
use Syscode\Http\JsonResponse;
use Syscode\Routing\Redirector;
use Syscode\Contracts\View\View;
use Syscode\Contracts\Routing\RouteResponse as ResponseContract;

/**
 * This class allows you to control the use of the HTTP response 
 * along with routes redirection.
 * 
 * @author Javier Alexander Campo M. <jalexcam@gmail.com>
 */
class RouteResponse implements ResponseContract
{
    /**
     * The View class instance.
     * 
     * @var Syscode\Contracts\View\View $view
     */
    protected $view;

    /**
     * The Redirector class instance.
     * 
     * @var \Syscode\Routing\Redirector $redirector
     */
    protected $redirector;

    /**
     * Constructor. Create a new RouteResponse instance.
     * 
     * @param  \Syscode\Contracts\View\View  $view
     * @param  \Syscode\Routing\Redirector  $redirector
     * 
     * @return void  
     */
    public function __construct(View $view, Redirector $redirector)
    {
        $this->view       = $view;
        $this->redirector = $redirector;
    }

    /**
     * Return a new response from the application.
     *
     * @param  string  $body
     * @param  int     $status   (200 by default)
     * @param  array   $headers
     * 
     * @return \Syscode\Http\Response
     */
    public function make($body = '', $status = 200, array $headers = [])
    {
        return new Response($body, $status, $headers);
    }

    /**
     * Creates a new 'no content' response.
     * 
     * @param  int    $status   (204 by default)
     * @param  array  $headers
     * 
     * @return \Syscode\Http\Response
     */
    public function noContent($status = 204, array $headers = [])
    {
        return $this->make('', $status, $headers);
    }

    /**
     * Return a new View Response from the application.
     *
     * @param  string  $view
     * @param  array   $data
     * @param  int     $status   (200 by default)
     * @param  array   $headers
     * 
     * @return  \Syscode\Http\Response
     */
    public function view($view, array $data = [], $status = 200, array $headers = [])
    {
        return $this->make($this->view->make($view, $data), $status, $headers);
    }

    /**
     * Create a new JSON response instance.
     * 
     * @param  mixed  $data
     * @param  int    $status   (200 by default)
     * @param  array  $headers
     * @param  int    $options  (0 by default)
     * 
     * @return \Syscode\Http\JsonResponse
     */
    public function json($data = [], $status = 200, array $headers = [], $options = 0)
    {
        return new JsonResponse($data, $status, $headers, $options);
    }

    /**
     * Create a new redirect response to the given path.
     * 
     * @param  string     $path
     * @param  int        $status   (302 by default)
     * @param  array      $headers
     * @param  bool|null  $secure   (null by default)
     * 
     * @return \Syscode\Http\RedirectResponse
     */
    public function redirectTo($path, $status = 302, $headers = [], $secure = null)
    {
        return $this->redirector->to($path, $status, $headers, $secure);
    }
}
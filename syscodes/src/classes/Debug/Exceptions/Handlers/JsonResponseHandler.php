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

namespace Syscodes\Debug\Handlers;

use Syscodes\Debug\FrameHandler\Formatter;

/**
 * Catches an exception and converts it to a JSON response.
 * 
 * @author Javier Alexander Campo M. <jalexcam@gmail.com>
 */
class JsonResponseHandler extends MainHandler
{
    /**
     * The way in which the data sender (usually the server) can tell the recipient 
     * (the browser, in general) what type of data is being sent in this case, json format.
     * 
     * @return string
     */
    public function contentType()
    {
        return 'application/json';
    }
    
    /**
     * Given an exception and status code will display the error to the client.
     * 
     * @return int
     */
    public function handle()
    {        
        $response = [
            'error' => [
                Formatter::formatExceptionAsDataArray($this->getSupervisor()),
            ]
        ];

        echo json_encode($response, defined('JSON_PARTIAL_OUTPUT_ON_ERROR') ? JSON_PARTIAL_OUTPUT_ON_ERROR : 0)."\n";

        return MainHandler::QUIT;
    }
}
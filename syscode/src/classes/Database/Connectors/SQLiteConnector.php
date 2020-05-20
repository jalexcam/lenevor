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
 * @since       0.7.0
 */

namespace Syscode\Database\Connectors;

use InvalidArgumentException;

/**
 * A PDO based SQLite Database Connector.
 * 
 * @author Javier Alexander Campo M. <jalexcam@gmail.com>
 */
class SQLiteConnector extends Connector implements ConnectorInterface
{
    /**
     * Establish a database connection.
     * 
     * @param  array  $config
     * 
     * @return \PDO
     * 
     * @throws \InvalidArgumentException
     */
    public function connect(array $config)
    {
        $options = $this->getOptions($config);

        if ($config['database'] === ':memory:')
        {
            return $this->createConnection('sqlite::memory:', $config, $options);
        }

        $path = realpath($config['path']);

        if ($path === false)
        {
            throw new InvalidArgumentException("Database [ {$config['database']} ] does not exist.");
        }

        return $this->createConnection("sqlite:{$path}", $config, $options);
    }
}
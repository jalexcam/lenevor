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
 * @copyright   Copyright (c) 2019-2021 Lenevor Framework 
 * @license     https://lenevor.com/license or see /license.md or see https://opensource.org/licenses/BSD-3-Clause New BSD license
 * @since       0.7.0
 */
 
namespace Syscodes\Database\Connectors;

use PDO;

/**
 * A PDO based MySQL Database Connector.
 * 
 * @author Javier Alexander Campo M. <jalexcam@gmail.com>
 */
class MySqlConnector extends Connector implements ConnectorInterface
{
    /**
     * Establish a database connection.
     * 
     * @param  array  $config
     * 
     * @return \PDO
     */
    public function connect(array $config)
    {
        $dsn = $this->getDsn($config);

        $options = $this->getOptions($config);

        $connection = $this->createConnection($dsn, $config, $options);

        if ( ! empty($config['database']))
        {
            $connection->exec("use `{$config['database']}`;");
        }

        $this->configureEncoding($connection, $config);

        $this->configureTimezone($connection, $config);
        
        $this->setModes($connection, $config);

        return $connection;
    }

    /**
     * Create a DSN string from a configuration. Chooses socket or host / port based on
     * the 'unix_socket' config value.
     * 
     * @param  array  $config
     * 
     * @return string
     */
    protected function getDsn(array $config)
    {
        return $this->hasSocket($config)
                    ? $this->getSocketDsn($config)
                    : $this->getHostDsn($config);
    }

    /**
     * Determine if the given configuration array has a UNIX socket value.
     * 
     * @param  array  $config
     * 
     * @return bool
     */
    protected function hasSocket(array $config)
    {
        return isset($config['unix_socket']) && ! empty($config['unix_socket']);
    }

    /**
     * Get the DSN string for a socket configuration.
     * 
     * @param  array  $config
     * 
     * @return string
     */
    protected function getSocketDsn(array $config)
    {
        return "mysql:unix_socket={$config['unix_socket']};dbname={$config['database']}";
    }

    /**
     * Get the DSN string for a host / port configuration.
     * 
     * @param  array  $config
     * 
     * @return string
     */
    protected function getHostDsn(array $config)
    {
        extract($config, EXTR_SKIP);
        
        return isset($port)
                ? "mysql:host={$host};port={$port};dbname={$database}"
                : "mysql:host={$host};dbname={$database}";
    }

    /**
     * Set the connection character set and collation.
     * 
     * @param  \PDO  $connection
     * @param  array  $config
     * 
     * @return void
     */
    protected function configureEncoding($connection, array $config)
    {
        if ( ! isset($config['charset']))
        {
            return $connection;
        }

        $connection->prepare(
            "set names '{$config['charset']}'".$this->getCollation($config)
        )->execute();
    }

    /**
     * Get the collation for the configuration.
     * 
     * @param  array  $config
     * 
     * @return string
     */
    protected function getCollation(array $config)
    {
        return isset($config['collation']) ? " collate '{$config['collation']}'" : '';
    }

    /**
     * Get the timezone on the connection.
     * 
     * @param  \PDO  $connection
     * @param  array  $config
     * 
     * @return void
     */
    protected function configureTimezone($connection, array $config)
    {
        if (isset($config['timezone']))
        {
            $connection->prepare('set time_zone="'.$config['timezone'].'"')->execute();
        }
    }

    /**
     * Set the modes for the connection.
     * 
     * @param  \PDO  $connection
     * @param  array  $config
     * 
     * @return void
     */
    protected function setModes($connection, array $config)
    {
        // If the "strict" option has been configured for the connection we'll enable
        // strict mode on all of these tables. This enforces some extra rules when
        // using the MySQL database system and is a quicker way to enforce them.
        if (isset($config['strict']) && $config['strict'])
        {
            $connection->prepare("set session sql_mode='STRICT_ALL_TABLES'")->execute();
        }
    }
}
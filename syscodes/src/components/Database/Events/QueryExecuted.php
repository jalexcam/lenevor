<?php 

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
 * @copyright   Copyright (c) 2019-2021 Lenevor Framework 
 * @license     https://lenevor.com/license or see /license.md or see https://opensource.org/licenses/BSD-3-Clause New BSD license
 * @since       0.7.3
 */
 
namespace Syscodes\Database\Events;

/**
 * Query executed event.
 * 
 * @author Javier Alexander Campo M. <jalexcam@gmail.com>
 */
class QueryExecuted
{
    /**
     * The array of query bindings.
     * 
     * @var array $bindings
     */
    public $bindings;

    /**
     * The database connection instance.
     * 
     * @var \Syscodes\Database\Connection $connection
     */
    public $connection;

    /**
     * The name of the connection.
     * 
     * @var string $ConnectionName
     */
    public $connectionName;

    /**
     * The SQL query that was executed.
     * 
     * @var string $sql
     */
    public $sql;

    /**
     * The number of milliseconds it took to execute the query.
     * 
     * @var float $time
     */
    public $time;

    /**
     * Constructor. Create a new event instance.
     * 
     * @param  string  $sql
     * @param  array  $bindings
     * @param  float|null  $time
     * @param  \Syscodes\Database\Connection  $connection
     * 
     * @return void
     */
    public function __construct($sql, $bindings, $time, $connection)
    {
        $this->sql            = $sql;
        $this->bindings       = $bindings;
        $this->time           = $time;
        $this->connection     = $connection;
        $this->connectionName = $connection->getName();
    }
}
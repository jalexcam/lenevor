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
 * @copyright   Copyright (c) 2019-2020 Lenevor PHP Framework 
 * @license     https://lenevor.com/license or see /license.md or see https://opensource.org/licenses/BSD-3-Clause New BSD license
 * @since       0.7.0
 */
 
namespace Syscode\Database\Query;

use Closure;

/**
 * Lenevor database query builder provides a convenient, fluent interface 
 * to creating and running database queries. and works on all supported 
 * database systems.
 * 
 * @author Javier Alexander Campo M. <jalexcam@gmail.com>
 */
class Builder
{
    /**
     * An aggregate function and column to be run.
     * 
     * @var array $aggregate
     */
    public $aggregate;

    /**
     * The current query value bindings.
     * 
     * @var array $bindings
     */
    public $bindings = [
        'select' => [],
        'join' => [],
        'where' => [],
        'groupBy' => [],
        'having' => [],
        'order' => [],
    ];

    /**
     * Get the columns of a table.
     * 
     * @var array $columns
     */
    public $columns;

    /**
     * The database connection instance.
     * 
     * @var \Syscode\Database\ConnectionInterface $connection
     */
    protected $connection;

    /**
     * Indicates if the query returns distinct results.
     * 
     * @var bool $distinct
     */
    public $distinct = false;

    /**
     * Get the table name for the query.
     * 
     * @var string $from
     */
    public $from;

    /**
     * The database query grammar instance.
     * 
     * @var \Syscode\Database\Query\Grammar $grammar
     */
    protected $grammar;

    /**
     * Get the grouping for the query.
     * 
     * @var array $groups
     */
    public $groups;

    /**
     * Get the having constraints for the query.
     * 
     * @var array $havings
     */
    public $havings;

    /**
     * Get the table joins for the query.
     * 
     * @var array $joins
     */
    public $joins;

    /**
     * Get the maximum number of records to return.
     * 
     * @var int $limit
     */
    public $limit;

    /**
     * Get the number of records to skip.
     * 
     * @var int $offset
     */
    public $offset;

    /**
     * Get the orderings for the query.
     * 
     * @var array $orders
     */
    public $orders;

    /**
     * Get the query union statements.
     * 
     * @var array $unions
     */
    public $unions;

    /**
     * Get the where constraints for the query.
     * 
     * @var array $wheres
     */
    public $wheres;
}
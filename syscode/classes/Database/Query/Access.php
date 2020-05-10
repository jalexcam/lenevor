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

/**
 * Allows identify the ID field and results of SELECT query in a table.
 * 
 * @author Javier Alexander Campo M. <jalexcam@gmail.com>
 */
class Access
{
    /**
     * Access the results of a "select" query.
     * 
     * @param  \Syscode\Database\Query\Builder  $builder
     * @param  array  $results
     * 
     * @return array
     */
    public function accessSelect(Builder $builder, $results)
    {
        return $results;
    }

    /**
     * Access an  "insert get ID" query.
     * 
     * @param  \Syscode\Database\Query\Builder  $builder
     * @param  string  $sql
     * @param  array  $values
     * @param  string  $sequence  (null by default)
     * 
     * @return int
     */
    public function accessInsertGetId(Builder $builder, $sql, $values, $sequence = null)
    {
        $builder->getConnection()->insert($sql, $values);

        $id = $builder->getConnection->getPdo()->lastInsertId($sequence);

        return is_numeric($id) ? (int) $id : $id;
    }

    /**
     * Access the results of a column listing query.
     * 
     * @param  array  $results
     * 
     * @return array
     */
    public function accessColumnListing($results)
    {
        return $results;
    }
}
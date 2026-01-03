<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace local_sqlquerybuilder\contracts;

use dml_exception;
use stdClass;

/**
 * The query builder interface
 *
 * @package   local_sqlquerybuilder
 * @copyright 2025 Konrad Ebel
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 * @method i_select_query limit(int $limit)
 *         Limit the number of returned records.
 * @method i_select_query offset(int $offset)
 *         Skip a specific number of records in the result set.
 * @method i_select_query page(int $pagecount, int $pagesize)
 *         Paginate results based on page number and size.
 * @method i_select_query select_all()
 *         Select all columns.
 * @method i_select_query select(string $name, ?string $alias = null)
 *         Select a specific column, optionally with an alias.
 * @method i_select_query select_count()
 *         Select a COUNT(*) aggregate.
 * @method i_select_query select_max(string $name, ?string $alias = null)
 *         Select the maximum value of a column.
 * @method i_select_query select_min(string $name, ?string $alias = null)
 *         Select the minimum value of a column.
 * @method i_select_query select_sum(string $name, ?string $alias = null)
 *         Select the sum of a column.
 * @method i_select_query distinct()
 *         Select only distinct (unique) records.
 * @method i_select_query order_asc(string ...$columns)
 *         Order results ascending by one or more columns.
 * @method i_select_query order_desc(string ...$columns)
 *         Order results descending by one or more columns.
 * @method i_select_query clear_order()
 *         Remove any ORDER BY clauses.

 */
interface i_select_query extends i_expression, i_joinable, i_conditioned {
    /**
     * Get multiple entries from the query
     *
     * @return stdClass[] Entries from the database call
     * @throws dml_exception Database is not reachable
     */
    public function get(): array;

    /**
     * Get the first entry from the query
     *
     * @return stdClass|false An entry if found one
     * @throws dml_exception Database is not reachable
     */
    public function first(): stdClass|false;

    /**
     * Returns the entry searched id
     *
     * @param int $id Search ID
     * @return stdClass|false An entry if found one
     * @throws dml_exception Database is not reachable
     */
    public function find(int $id): stdClass|false;
}

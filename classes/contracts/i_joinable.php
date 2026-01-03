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
 * @method self join(string|self $table, $conditions, string $alias = '')
 *         Join another table with INNER JOIN.
 * @method self left_join(string|self $table, $conditions, string $alias = '')
 *         Join another table with LEFT JOIN.
 * @method self right_join(string|self $table, $conditions, string $alias = '')
 *         Join another table with RIGHT JOIN.
 * @method self full_join(string|self $table, $conditions, string $alias = '')
 *         Join another table with FULL OUTER JOIN.
 * @method self group_by(string ...$column)
 *         Group results by one or more columns.
 * @method self having(string $column, string $operator, mixed $value)
 *         Add a HAVING condition for grouped queries.
 * @method self or_having(string $column, string $operator, mixed $value)
 *         Add an OR HAVING condition for grouped queries.
 */
interface i_joinable extends i_expression {
}

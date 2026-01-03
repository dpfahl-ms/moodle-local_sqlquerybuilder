<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

namespace local_sqlquerybuilder\contracts;

/**
 * Builds an where expression without WHERE
 *
 * @package     local_sqlquerybuilder
 * @copyright   2025 Konrad Ebel <despair2400@proton.me>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
interface i_condition extends i_expression {
    /**
     * Adds an AND comparison between a column and a value
     * (or a subquery returning a single value).
     *
     * Supported operators: =, <>, <, <=, >, >=, like
     *
     * @param string $column Column name to compare.
     * @param string $operator Comparison operator.
     * @param mixed $value Scalar value or query returning a value.
     * @return i_condition Returns itself.
     */
    public function where(string $column, string $operator, mixed $value): i_condition;

    /**
     * Comparison between two columns
     *
     * Supported operators: =, <>, <, <=, >, >=
     *
     * @param string $column Column name to compare.
     * @param string $operator Comparison operator.
     * @param string $othercolumn Other column name to compare.
     * @return i_condition Returns itself.
     */
    public function where_column(string $column, string $operator, string $othercolumn): i_condition;

    /**
     * Comparison between a column and a value (or query returning a value)
     * (Or combined with the last expression)
     *
     * @param string $column Column name to compare.
     * @param string $operator Supports: like, <>, <, <=, >, >=, =
     * @param mixed $value value or query returning a value
     * @return i_condition Returns itself
     */
    public function or_where(string $column, string $operator, mixed $value): i_condition;

    /**
     * Negated comparison between a column and a value (or query returning a value)
     *
     * @param string $column Column name to compare.
     * @param string $operator Supports: like, <>, <, <=, >, >=, =
     * @param mixed $value value or query returning a value
     * @return i_condition Returns itself
     */
    public function where_not(string $column, string $operator, mixed $value): i_condition;

    /**
     * Negated comparison between a column and a value (or query returning a value)
     * (Or combined with the last expression)
     *
     * @param string $column Column name to compare.
     * @param string $operator Supports: like, <>, <, <=, >, >=, =
     * @param mixed $value value or query returning a value
     * @return i_condition Returns itself
     */
    public function or_where_not(string $column, string $operator, mixed $value): i_condition;

    /**
     * Compares a text column with the value for a real fulltext search
     *
     * @param string $column Column name to compare.
     * @param string $value Value that should equal the text
     * @return i_condition Returns itself
     */
    public function where_fulltext(string $column, string $value): i_condition;

    /**
     * Compares a text column with the value for a real fulltext search (Negated)
     *
     * @param string $column Column name to compare.
     * @param string $value Value that should not equal the text
     * @return i_condition Returns itself
     */
    public function where_fulltext_not(string $column, string $value): i_condition;

    /**
     * Compares a column with the like operation
     *
     * @param string $column Column name to compare.
     * @param string $value Like expression to filter with (% and _ are wildcards)
     * @param null|like_options $options Options for the like operation
     * @return i_condition Returns itself
     */
    public function where_like(string $column, string $value, ?like_options $options = null): i_condition;

    /**
     * Compares a column with the like operation (Negated)
     *
     * @param string $column Column name to compare.
     * @param string $value Like expression to filter with (% and _ are wildcards)
     * @param null|like_options $options Options for the like operation
     * @return i_condition Returns itself
     */
    public function where_not_like(string $column, string $value, ?like_options $options = null): i_condition;

    /**
     * Filters out all null expression
     *
     * @param string $column Column name to compare.
     * @return i_condition Returns itself
     */
    public function where_null(string $column): i_condition;

    /**
     * Filters out all null expression
     * (Or combined with the last expression)
     *
     * @param string $column Column name to compare.
     * @return i_condition Returns itself
     */
    public function or_where_null(string $column): i_condition;

    /**
     * Filters out all non null expression
     *
     * @param string $column Column name to compare.
     * @return i_condition Returns itself
     */
    public function where_notnull(string $column): i_condition;

    /**
     * Filters out all non null expression
     * (Or combined with the last expression)
     *
     * @param string $column Column name to compare.
     * @return i_condition Returns itself
     */
    public function or_where_notnull(string $column): i_condition;

    /**
     * Filters out all entries not in the list
     *
     * @param string $column Column name to compare.
     * @param array|i_select_query $values List of values or query returns a list
     * @return i_condition Returns itself
     */
    public function where_in(string $column, array|i_select_query $values): i_condition;

    /**
     * Filters out all entries that are inside the list
     *
     * @param string $column Column name to compare.
     * @param array|i_select_query $values List of values or query returns a list
     * @return i_condition Returns itself
     */
    public function where_not_in(string $column, array|i_select_query $values): i_condition;

    /**
     * Filters out all entries where the current time is before the start column
     * or after the end column
     *
     * Null values wont be checked
     *
     * For example:
     * current: 100
     *
     * start | end  | exluded?  |
     * 99    | 101  | No        |
     * 101   | 103  | Yes       |
     * NULL  | 103  | No        | (Start not checked)
     * 100   | 103  | No        |
     *
     * @param string $columntimestart Columnname contain the start time
     * @param string $columntimeend Columnname contain the end time
     * @return i_condition Returns itself
     */
    public function where_currently_active(string $columntimestart, string $columntimeend): i_condition;

    /**
     * Checks whether there are no conditions set
     *
     * @return bool True if no conditions set
     */
    public function has_no_conditions(): bool;
}

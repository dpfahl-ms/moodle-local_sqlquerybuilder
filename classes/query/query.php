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

namespace local_sqlquerybuilder\query;

use BadMethodCallException;
use local_sqlquerybuilder\query\froms\from_expression;
use local_sqlquerybuilder\query\joins\joinpart;
use local_sqlquerybuilder\query\where\wherepart;
use local_sqlquerybuilder\query\grouping;


/**
 * A Query builder
 *
 * @package   local_sqlquerybuilder
 * @copyright 2025 Daniel Meißner
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
abstract class query {
    protected joinpart $joinpart;
    protected wherepart $wherepart;
    protected grouping $groupingpart;

    public function __construct(
        public from_expression $from
    ) {
        $this->joinpart = new joinpart();
        $this->wherepart = new wherepart();
        $this->groupingpart = new grouping();
    }

    public abstract function get_sql(): string;

    public function get_params(): array {
        $params = [];

        foreach ($this->get_query_parts() as $part) {
            $params[] = $part->get_params();
        }

        return array_merge(...$params);
    }

    protected function get_query_parts(): array {
        return [
            $this->from,
            $this->joinpart,
            $this->wherepart,
            $this->groupingpart,
        ];
    }

    public function __call($method, $args): self {
        $parts = $this->get_query_parts();

        foreach ($parts as $part) {
            if (method_exists($part, $method)) {
                $part->$method(...$args);
                return $this;
            }
        }

        throw new BadMethodCallException("Method $method is not defined");
    }

    public function __toString(): string {
        return $this->get_sql();
    }
}

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

use local_sqlquerybuilder\contracts\i_delete_query;
use local_sqlquerybuilder\contracts\i_select_query;
use local_sqlquerybuilder\contracts\i_update_query;
use function is_array;
use stdClass;
use local_sqlquerybuilder\contracts\i_db;
use local_sqlquerybuilder\query\froms\from_table;
use local_sqlquerybuilder\query\froms\from_query;
use local_sqlquerybuilder\query\froms\from_values;

/**
 * Syntactic sugar for the query object
 *
 * @package   local_sqlquerybuilder
 * @copyright 2025 Daniel Meißner
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class database implements i_db {
    public function table(string|i_select_query $nameorquery, ?string $alias = null): i_select_query {
        if (is_string($nameorquery)) {
            return new select_query(new from_table($nameorquery, $alias));
        }

        return new select_query(new from_query($nameorquery, $alias));
    }

    public function from_values(
        array $table,
        string $tablename,
        array $rowaliases,
    ): i_select_query {
        return new select_query(new from_values($table, $tablename, $rowaliases));
    }

    public function insert(string $name, stdClass|array $records, bool $allowsetid = false) {
        global $DB;
        if ($allowsetid) {
            if (is_array($records)) {
                foreach ($records as $record) {
                    $DB->insert_record_raw($name, $record, bulk: true);
                }
                return;
            }

            $DB->insert_record_raw($name, $records);
            return;
        }

        if (is_array($records)) {
            $DB->insert_records($name, $records);
            return;
        }

        $DB->insert_record($name, $records);
    }

    public function delete(string $table, string $tablename): i_delete_query {
        return new delete_query(new from_table($table, $tablename));
    }

    public function update(string $table, ?stdClass $record = null, ?string $tablename = null): ?i_update_query {
        global $DB;
        if ($record == null) {
            return new update_query(new from_table($table, $tablename));
        }

        $DB->update_record(
            $table,
            $record
        );
    }
}

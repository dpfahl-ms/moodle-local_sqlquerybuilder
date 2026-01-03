<?php

namespace local_sqlquerybuilder\query;

use local_sqlquerybuilder\contracts\i_update_query;#

class update_query extends query implements i_update_query {
    private array $updatesetters;

    public function update(array $updatesetters) {
        global $DB;
        $this->updatesetters = $updatesetters;
        $DB->execute($this->get_sql(), $this->get_params());
    }

    private function get_set_part(): string {
        $columns = array_keys($this->updatesetters);
        $sql = implode(" = ? ,", $columns);
        return $sql . ' = ? ';
    }

    public function get_params(): array {
        return array_values($this->updatesetters) + parent::get_params();
    }

    public function get_sql(): string {
        $sql = "UPDATE " . $this->from->get_sql()
            . "SET " . $this->get_set_part()
            . $this->joinpart->get_sql()
            . $this->wherepart->get_sql()
            . $this->groupingpart->get_sql();

        return trim(preg_replace('/\s{2,}/', ' ', $sql));
    }
}

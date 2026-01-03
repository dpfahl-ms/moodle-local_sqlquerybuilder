<?php

namespace local_sqlquerybuilder\query;

use local_sqlquerybuilder\contracts\i_delete_query;

class delete_query extends query implements i_delete_query {
    private array $updatesetters;

    public function delete() {
        global $DB;
        $DB->execute($this->get_sql(), $this->get_params());
    }

    public function get_sql(): string {
        $sql = "DELETE FROM " . $this->from->get_sql()
            . $this->joinpart->get_sql()
            . $this->wherepart->get_sql()
            . $this->groupingpart->get_sql();

        return trim(preg_replace('/\s{2,}/', ' ', $sql));
    }
}

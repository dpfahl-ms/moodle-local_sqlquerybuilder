<?php

namespace local_sqlquerybuilder\query;

use stdClass;
use local_sqlquerybuilder\contracts\i_select_query;
use local_sqlquerybuilder\query\froms\from_expression;
use local_sqlquerybuilder\query\columns\selectpart;
use local_sqlquerybuilder\query\orderings\orderby;
use local_sqlquerybuilder\query\pagination;

class select_query extends query implements i_select_query {
    protected selectpart $selectpart;

    protected orderby $orderbypart;
    protected pagination $pagination;

    public function __construct(
        from_expression $from
    ) {
        $this->selectpart = new selectpart();
        $this->orderbypart = new orderby();
        $this->pagination = new pagination();
        parent::__construct($from);
    }

    protected function get_query_parts(): array {
        return [
            $this->selectpart,
        ] + parent::get_query_parts() + [
            $this->orderbypart,
            $this->pagination,
        ];
    }

    public function get_sql(): string {
        $sql = $this->selectpart->get_sql() . " "
            . "FROM " . $this->from->get_sql()
            . $this->joinpart->get_sql()
            . $this->wherepart->get_sql()
            . $this->groupingpart->get_sql()
            . $this->orderbypart->get_sql()
            . $this->pagination->get_sql();

        return trim(preg_replace('/\s{2,}/', ' ', $sql));
    }

    public function get(): array {
        global $DB;
        return $DB->get_records_sql($this->get_sql(), $this->get_params());
    }

    public function first(): stdClass|false {
        global $DB;
        $this->limit(1);
        $record = $DB->get_records_sql($this->get_sql(), $this->get_params());
        return reset($record) ?? false;
    }

    public function find(int $id): stdClass|false {
        $this->wherepart->where('id', '=', $id);
        return $this->first();
    }
}

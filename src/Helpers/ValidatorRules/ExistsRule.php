<?php

namespace App\Helpers\ValidatorRules;

use Rakit\Validation\Rule;
use App\Models\Model;

class ExistsRule extends Rule
{
    protected $message = ":attribute does not exist";

    protected $fillableParams = ['table', 'column'];

    public function check($value): bool
    {
       
        $table = $this->parameter('table');
        $column = $this->parameter('column');

        $model = new Model;

        $count = $model->db->count($table, [$column => $value]);

        return !!$count;
    }
}

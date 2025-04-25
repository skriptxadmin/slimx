<?php
namespace App\Database\Migrations;

use App\Models\Model;

class RolesMigration extends Model
{

    protected $table = 'roles';

    protected $columns = [
        'id'   => [
            "INT",
            "NOT NULL",
            "AUTO_INCREMENT",
            "PRIMARY KEY",
        ],
        'slug' => [
            'VARCHAR(30)',
            'NOT NULL',
            'UNIQUE'
        ],
        'name' => [
            'VARCHAR(30)',
            'NOT NULL',
        ],
        
    ];

        public function __construct(){

        parent::__construct();

        $this->migrate();

    }

}




new RolesMigration;
<?php
namespace App\Database\Migrations;

use App\Models\Model;

class UsersMigration extends Model
{

    protected $table = 'users';

    protected $columns = [
        'id'   => [
            "INT",
            "NOT NULL",
            "AUTO_INCREMENT",
            "PRIMARY KEY",
        ],
        'role_id' => [
            'INT',
            'NOT NULL',
        ],
        'fullname' => [
            'VARCHAR(50)',
            'NOT NULL',
        ],
        'email' => [
            'VARCHAR(30)',
            'NOT NULL',
        ],
        'mobile' => [
            'VARCHAR(30)',
            'NOT NULL',
        ],
        'password' => [
            'TEXT',
            'NOT NULL',
        ],
        'otp' => [
            'VARCHAR(8)',
            'NULL',
        ],
        
    ];

        public function __construct(){

        parent::__construct();

        $this->migrate();

    }

}




new UsersMigration;
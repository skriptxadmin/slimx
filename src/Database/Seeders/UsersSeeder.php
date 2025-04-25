<?php
namespace App\Database\Seeders;

use App\Models\Model;

class UsersSeeder extends Model
{

    protected $table = 'users';

    protected $rows = []; // do not fill the values here

    public function __construct(){

        parent::__construct();

        $this->rows = [
            [
              'fullname' => 'Administrator',
              'role_id' => 1,
              'email' => 'administrator@example.com',
              'mobile' => '123456789',
              'password' => password_hash('Password@123', PASSWORD_DEFAULT)
            ]
          ];
    

        $this->seed();
    }

}

new UsersSeeder;
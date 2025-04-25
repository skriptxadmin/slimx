<?php
namespace App\Database\Seeders;

use App\Models\Model;

class RolesSeeder extends Model
{

    protected $table = 'roles';

    protected $rows = []; // do not fill the values here

    public function __construct(){

        parent::__construct();

        $this->rows = [
            [
                'slug' => 'administrator',
                'name' => 'Administrator',
            ],
            [
                'slug' => 'subscriber',
                'name' => 'Subscriber',
            ]];

        $this->seed();
    }

}

new RolesSeeder;
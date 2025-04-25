<?php 

namespace App\Models;
use App\Helpers\Helper;
use App\Helpers\Mailgun;

class User extends Model{

    protected $table = 'users';
    

    public function password_verify($plain_text, $hashed_password){

        return password_verify($plain_text, $hashed_password);
    }
  
}
<?php
namespace App\Helpers;

class Helper{

    public function random($characters, $length = 6){

        $charactersLength = strlen($characters);
        $randomString = '';
    
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
    
        return $randomString;
    }
   
    public function random_string($length = 6){

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        
        return $this->random($characters, $length);
    }

    public function random_number($length = 6){

        $characters = '0123456789';
        return $this->random($characters, $length);

    }
}
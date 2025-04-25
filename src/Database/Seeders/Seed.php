<?php 

namespace App\Database\Seeders;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\Controller;

class Seed extends Controller{

    public function seed(Request $request, Response $response, $args)
    {

        try{

            $files = glob(__DIR__.'/./*.php');

            foreach($files as $file){
    
                $basename = pathinfo($file, PATHINFO_FILENAME);
    
                if($basename == 'Seed'){
    
                    continue;
                }
    
               require $file;
            }
            return $this->json(['message' => 'Seeding Successful']);

        }catch(\Exception $e){

            return $this->json(['message' => 'Seeding Error', 'error' => $e->getMessage()]);


        }
     
    }
}
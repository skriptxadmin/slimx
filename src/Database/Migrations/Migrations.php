<?php 

namespace App\Database\Migrations;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Controllers\Controller;

class Migrations extends Controller{

    public function migrate(Request $request, Response $response, $args)
    {

        try{
        $files = glob(__DIR__.'/./*.php');

        foreach($files as $file){

            $basename = pathinfo($file, PATHINFO_FILENAME);

            if($basename == 'Migrations'){

                continue;
            }

           require $file;
        }
      
        return $this->json(['message' => 'Migration Successful']);

    }catch(\Exception $e){

        return $this->json(['message' => 'Seeding Error', 'error' => $e->getMessage()]);


    }
    }
}
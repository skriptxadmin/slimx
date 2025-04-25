<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Models\User;
use App\Helpers\Validator;

class HomeController extends Controller{


    public function index(Request $request, Response $response, $args)
    {

        $tpl = 'home/index';

        $data = ['name' => 'Slimx'];

        return $this->view($request, $tpl, $data);
    }

    public function users(Request $request, Response $response, $args)
    {
      
        $model = new User;

        $users = $model->select('*');

        $data = ['message' => "I am response from ajax call", 'users'=> $users];

        $statusCode = 200; // default 200 no need to pass

        // $statusCode = 422;

        return $this->json($data, $statusCode);
    }

    public function validation(Request $request, Response $response, $args){

        $validator = new Validator();

        $rules = [
            'email' => 'required|email|string|unique:users,email',
            'fullname' => 'required|min:3|max:30|regex:/^[a-zA-Z\\s]*$/',
            'mobile' => ['required','min:10', 'max:10', 'regex:/^[6-9][0-9]{9}$/', 'unique:users,mobile'],

        ];

        $valid = $validator->make($_POST, $rules);

        if($valid !== true){

            return $this->json(['errors' => $valid], 422);
        }

        $validated = $validator->valid;


        return $this->json($validated);
    }
    
}
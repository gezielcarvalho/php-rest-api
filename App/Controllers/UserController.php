<?php

namespace App\Controllers;

use Core\Controller;

class UserController extends Controller {

    public function index(){
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'status' => 200,
            'message' => 'Hello World',
            'data' => [
                'users'=> [
                    [
                    'name' => 'John Doe',
                    'age' => 25,
                    'address' => 'New York'
                ],[
                    'name' => 'Jane Doe',
                    'age' => 23,
                    'address' => 'New York'
                ]
                ]
            ]
        ]);
    }
    
    public function show($id){
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'status' => 200,
            'message' => 'Hello World',
            'data' => [
                'user'=> [
                    'name' => 'John Doe',
                    'age' => 25,
                    'address' => 'New York'
                ]
            ]
        ]);
    }

}
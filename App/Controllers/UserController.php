<?php

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
 
class UserController extends Controller {
 
    public function index(){
        $results = User::getAll();
        header('Content-Type: application/json');
        echo json_encode($results);
    }
    
    public function show($id){
        $results = User::getById($id);
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode($results);
    }

    public function store(){
        header('Content-Type: application/json');
        http_response_code(201);
        echo json_encode([
            'success' => true,
            'status' => 200,
            'message' => 'Record created successfully',
            'data' => [
                'user'=> [
                    'name' => 'John Doe',
                    'age' => 25,
                    'address' => 'New York'
                ]
            ]
        ]);
    }

    public function update($id){
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'status' => 200,
            'message' => 'Record updated successfully',
            'data' => [
                'user'=> [
                    'name' => 'John Doe',
                    'age' => 25,
                    'address' => 'New York'
                ]
            ]
        ]);
    }

    public function destroy($id){
        header('Content-Type: application/json');
        http_response_code(204);
    }

}
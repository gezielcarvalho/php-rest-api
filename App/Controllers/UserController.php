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
        echo json_encode($results);
    }

    public function store(){

        // call parent decode JSON if $_POST is empty
        if (empty($_POST)) {
            parent::decodePostFromJSON();
        }
 
        $missingFields = $this->validateRequest([
            "fullname",
            "username",
            "email",
            "password",
            "address"
        ]);   
        
        header('Content-Type: application/json');

        if(count($missingFields) > 0){
            http_response_code(400);
            $results["success"] = false;
            $results["status"] = 400;
            $results["message"] = "Error: Missing required fields";
            $results['error'] = "Missing required fields";
            $results["data"]["missing"] = $missingFields;
            echo json_encode($results);
            exit();
        }

        $results = User::create();
        echo json_encode($results);
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
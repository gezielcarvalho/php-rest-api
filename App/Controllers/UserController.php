<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;

use App\Models\User;
 
class UserController extends Controller {
 
    public function index(){
        $results = User::getAll();
        View::render('index.php', compact('results'));
    }
    
    public function show($id){
        $results = User::getById($id);
        View::render('index.php', compact('results'));
    }

    public function store(){

        // call parent decode JSON if $_POST is empty
        if (empty($_POST)) {
            $this->decodePostFromJSON();
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
            $results["success"] = false;
            $results["status"] = 400;
            $results["message"] = "Error: Missing required fields";
            $results['error'] = "Missing required fields";
            $results["data"]["missing"] = $missingFields;
            View::render('index.php', compact('results'));
            exit();
        }

        $results = User::create();
        echo json_encode($results);
    }

    public function update($id){

        // call parent decode JSON if $_POST is empty
        if (empty($_POST)) {
            $this->decodePostFromJSON();
        }

        $results = User::update($id);
        View::render('index.php', compact('results'));
    }

    public function destroy($id){
        header('Content-Type: application/json');
        http_response_code(204);
    }

}
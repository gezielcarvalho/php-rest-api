<?php
namespace Core;

class Controller {
    public function decodePostFromJSON(){
        $_POST = json_decode(file_get_contents("php://input"), true);
        if (empty($_POST)) {
            header('Content-Type: application/json');
            http_response_code(400);
            $results["success"] = false;
            $results["status"] = 400;
            $results["message"] = "Error: Empty or invalid JSON request";
            $results['error'] = "Empty or invalid JSON request";
            echo json_encode($results);
            exit();
        }
    }

    protected function validateRequest($requiredFields){
        $errors = [];
        foreach($requiredFields as $field){
            if(!isset($_POST[$field])){
                $errors[] = $field;
            }
        }
        return $errors;
    }
}
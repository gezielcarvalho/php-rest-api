<?php

namespace Core;

use Core\View;

class Controller {
    protected function decodePostFromJSON(){
        $_POST = json_decode(file_get_contents("php://input"), true);
        if (empty($_POST)) {
            $results["success"] = false;
            $results["status"] = 400;
            $results["message"] = "Error: Empty or invalid JSON request";
            $results['error'] = "Empty or invalid JSON request";
            View::render('index.php', compact('results'));
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

    public static function view($view, $args = []){
        View::render($view, $args);
    }
}
<?php

namespace App\Controllers;

use Core\Controller;

class HomeController extends Controller {

    public function index(){
        header('Content-Type: application/json');
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'status' => 200,
            'message' => 'Hello World'
        ]);
    }
}
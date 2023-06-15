<?php
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
<?php
// set content type header to return JSON data
header("Content-Type: application/json");
// return JSON data
http_response_code($results['status']);
echo json_encode($results);
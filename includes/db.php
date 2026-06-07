<?php

require_once __DIR__ . '/../load_env.php';

$host = getenv('DB_HOST');
$user = getenv('DB_USER');
$pass = getenv('DB_PASS');
$name = getenv('DB_NAME');

if (!$host || !$user || !$name) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "ENV not loaded properly",
        "debug" => [
            "host" => $host,
            "user" => $user,
            "name" => $name
        ]
    ]);
    exit;
}

$conn = new mysqli($host, $user, $pass, $name);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "DB connection failed",
        "error" => $conn->connect_error
    ]);
    exit;
}
<?php

$conn = new mysqli(
    "localhost",
    "YOUR_DB_USER",
    "YOUR_DB_PASSWORD",
    "YOUR_DB_NAME"
);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed"
    ]);
    exit;
}
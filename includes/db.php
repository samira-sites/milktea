<?php

$conn = new mysqli(
    "localhost",
    "root",
    "",
    "milktea_shop"
);

if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed",
        "error" => $conn->connect_error
    ]);
    exit;
}
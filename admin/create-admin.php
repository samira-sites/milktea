<?php

require_once '../includes/config.php';

$username = "admin";

$password = password_hash(
    "Admin123",
    PASSWORD_DEFAULT
);

$stmt = $conn->prepare("
INSERT INTO admins(username,password)
VALUES(?,?)
");

$stmt->bind_param(
    "ss",
    $username,
    $password
);

$stmt->execute();

echo "Admin created";
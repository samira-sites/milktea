<?php

header('Content-Type: application/json');
error_reporting(0);

file_put_contents("debug.txt", file_get_contents("php://input"));

require_once '../includes/db.php';

/* READ JSON */
$data = json_decode(file_get_contents("php://input"), true);

if (!$data) {
    echo json_encode([
        "success" => false,
        "message" => "No data received"
    ]);
    exit;
}

$cart = $data["cart"] ?? [];
$name = $data["name"] ?? "Guest";
$phone = $data["phone"] ?? "";

/* CALCULATE TOTAL */
$total = 0;

foreach ($cart as $item) {
    $total += $item["price"] * $item["qty"];
}

/* INSERT ORDER */
$stmt = $conn->prepare("
    INSERT INTO orders (customer_name, total, phone)
    VALUES (?, ?, ?)
");

$stmt->bind_param("sds", $name, $total, $phone);
$stmt->execute();

$orderId = $conn->insert_id;

/* INSERT ITEMS */
foreach ($cart as $item) {

    $drinkName = $item["name"];
    $price = $item["price"];
    $qty = $item["qty"];

    $stmt2 = $conn->prepare("
        INSERT INTO order_items (order_id, drink_name, price, quantity)
        VALUES (?, ?, ?, ?)
    ");

    $stmt2->bind_param("isdi", $orderId, $drinkName, $price, $qty);
    $stmt2->execute();
}

/* RESPONSE */
echo json_encode([
    "success" => true,
    "orderId" => $orderId
]);

$conn->close();
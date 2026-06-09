<?php

session_start();

require_once '../includes/config.php';

if ($conn->connect_error) {
    die("Database error");
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("
        SELECT * FROM admins
        WHERE username = ?
    ");

    $stmt->bind_param("s", $username);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $admin = $result->fetch_assoc();


    
        if (password_verify($password, $admin['password'])) {
    
            echo "Login success";
    
        } else {
    
            echo "Wrong password";
    
        }
    
    } else {
    
        echo "Admin not found";
    
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>

<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-box {
        background: #fff;
        padding: 40px;
        width: 320px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        text-align: center;
    }

    .login-box h2 {
        margin-bottom: 20px;
        color: #333;
    }

    .login-box input {
        width: 100%;
        padding: 12px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 8px;
        outline: none;
        transition: 0.3s;
    }

    .login-box input:focus {
        border-color: #2575fc;
        box-shadow: 0 0 5px rgba(37,117,252,0.3);
    }

    .login-box button {
        width: 100%;
        padding: 12px;
        background: #2575fc;
        border: none;
        color: white;
        font-weight: bold;
        border-radius: 8px;
        cursor: pointer;
        margin-top: 10px;
        transition: 0.3s;
    }

    .login-box button:hover {
        background: #1a5edb;
    }

    .error {
        color: red;
        font-size: 14px;
        margin-top: 10px;
    }
</style>

</head>
<body>

<div class="login-box">
    <h2>Admin Login</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
</div>

</body>
</html>


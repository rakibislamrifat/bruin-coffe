<?php
session_start();
require '../bruin/db/db.php';

// load cart items from database and verify with current user
$user = $_SESSION['user'] ?? null;
$email = null;

if ($user !== null) {
    // Get email of the logged-in user using prepared statement
    $stmt = $conn->prepare("SELECT email FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();

    if ($email !== null) {
        echo $email;
    } else {
        echo "User email not found.<br>";
    }
} else {
    echo "User not logged in.<br>";
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
</head>
<body>
    <h1>My Cart</h1>
    <!-- if session user and database user are same then show cart items -->
    
</body>
</html>



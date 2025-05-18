<?php
require '../db/db.php';

if (isset($_POST['submit'])) {
    // Escape input
    $order_name = mysqli_real_escape_string($conn, $_POST['order_name']);
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Create 'orders' table if it doesn't exist
    $createTableSQL = "
        CREATE TABLE IF NOT EXISTS orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            image VARCHAR(255) NOT NULL,
            order_name VARCHAR(255) NOT NULL,
            quantity INT NOT NULL,
            price DECIMAL(10,2) NOT NULL,
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ";

    if (!mysqli_query($conn, $createTableSQL)) {
        die("Error creating table: " . mysqli_error($conn));
    }

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image_name = basename($_FILES['image']['name']);
        $tmp_name = $_FILES['image']['tmp_name'];

        $upload_dir = "../uploads/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $upload_path = $upload_dir . $image_name;

        if (move_uploaded_file($tmp_name, $upload_path)) {
            $sql = "INSERT INTO orders (image, order_name, quantity, price, description) 
                    VALUES ('$image_name', '$order_name', $quantity, $price, '$description')";

            if (mysqli_query($conn, $sql)) {
                header("Location: ../dashboard/dashboard.php");
                exit;
            } else {
                echo "Error inserting data: " . mysqli_error($conn);
            }
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "Image file is required.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
        }

        .rifat-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        .rifat-title {
            text-align: center;
            color: #6F3727;
            font-size: 28px;
            margin-bottom: 25px;
        }

        .rifat-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .rifat-form label {
            font-size: 15px;
            font-weight: 500;
            color: #333;
        }

        .rifat-form input[type="file"],
        .rifat-form input[type="text"],
        .rifat-form input[type="number"] {
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: border-color 0.3s;
        }

        .rifat-form input[type="file"] {
            padding: 6px;
            border: none;
        }

        .rifat-form input:focus {
            outline: none;
            border-color: #6F3727;
        }

        .rifat-button {
            background-color: #6F3727;
            color: #fff;
            padding: 14px;
            font-size: 16px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .rifat-button:hover {
            background-color: #5c2e22;
        }

        .rifat-back-link {
            display: block;
            text-align: center;
            margin-top: 25px;
            color: #6F3727;
            text-decoration: none;
            font-weight: 500;
        }

        .rifat-back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="rifat-container">
        <h2 class="rifat-title">Create a post for Order</h2>
        <form method="POST" enctype="multipart/form-data" class="rifat-form">
            <label for="image">Image:</label>
            <input type="file" name="image" required>

            <label for="order_name">Order Name:</label>
            <input type="text" name="order_name" required>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required>
            <label for="description">Description:</label>
            <input type="text" name="description" required>

            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" required>

            <button type="submit" name="submit" class="rifat-button">Create</button>
        </form>
        <a href="index.php" class="rifat-back-link">Back to Orders</a>
    </div>
</body>
</html>

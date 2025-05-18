<?php
session_start();
require '../bruin/db/db.php';

// Initialize variables
$user = $_SESSION['user'] ?? null;
$email = null;
$cartItems = [];
$totalPrice = 0;

if ($user !== null) {
    // Get email of the logged-in user using prepared statement
    $stmt = $conn->prepare("SELECT email FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();

    if ($email !== null) {

        $cartStmt = $conn->prepare("SELECT id, product_name, product_price, product_image, product_quantity 
                                   FROM cart 
                                   WHERE email = ?");
        $cartStmt->bind_param("s", $email);
        $cartStmt->execute();
        $result = $cartStmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cartItems[] = $row;
                $totalPrice += ($row['product_price'] * $row['product_quantity']);
            }
        }
        $cartStmt->close();
    }
}

if (isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];


    if (isset($_POST['increase'])) {
        $sql = "UPDATE cart SET product_quantity = product_quantity + 1 WHERE id = ?";
    } elseif (isset($_POST['decrease'])) {
        $sql = "UPDATE cart SET product_quantity = GREATEST(product_quantity - 1, 1) WHERE id = ?";
    }

    if (isset($sql)) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cart_id);
        $stmt->execute();
        $stmt->close();
    }

    // Optional: redirect back to clear POST
    header("Location: my-cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }
        
        .rifat-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .rifat-heading {
            color: #2c3e50;
            margin-bottom: 30px;
            font-weight: 600;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        
        .rifat-cart-empty {
            background-color: #fff;
            padding: 40px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .rifat-cart-empty i {
            font-size: 48px;
            color: #bdc3c7;
            margin-bottom: 20px;
        }
        
        .rifat-cart-empty h2 {
            color: #7f8c8d;
            margin-bottom: 20px;
        }
        
        .rifat-cart-empty a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 500;
            transition: background-color 0.3s;
        }
        
        .rifat-cart-empty a:hover {
            background-color: #2980b9;
        }
        
        .rifat-cart-table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }
        
        .rifat-cart-table th {
            background-color: #3498db;
            color: white;
            text-align: left;
            padding: 15px;
            font-weight: 500;
        }
        
        .rifat-cart-table td {
            padding: 15px;
            border-bottom: 1px solid #ecf0f1;
            vertical-align: middle;
        }
        
        .rifat-cart-table tr:last-child td {
            border-bottom: none;
        }
        
        .rifat-product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }
        
        .rifat-quantity-control {
            display: flex;
            align-items: center;
        }
        
        .rifat-quantity-btn {
            background-color: #f1f1f1;
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s;
        }
        
        .rifat-quantity-btn:hover {
            background-color: #e0e0e0;
        }
        
        .rifat-quantity-input {
            width: 40px;
            height: 30px;
            text-align: center;
            border: 1px solid #ddd;
            margin: 0 8px;
            border-radius: 4px;
        }
        
        .rifat-remove-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .rifat-remove-btn:hover {
            background-color: #c0392b;
        }
        
        .rifat-cart-summary {
            margin-top: 30px;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .rifat-summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #ecf0f1;
        }
        
        .rifat-summary-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
            font-weight: bold;
            font-size: 1.2em;
            color: #2c3e50;
        }
        
        .rifat-checkout-btn {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #2ecc71;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        
        .rifat-checkout-btn:hover {
            background-color: #27ae60;
        }
        
        .rifat-user-info {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #e8f4fc;
            border-radius: 8px;
            border-left: 4px solid #3498db;
        }
        
        .rifat-back-to-shop {
            display: inline-block;
            margin-top: 20px;
            color: #3498db;
            text-decoration: none;
            font-weight: 500;
        }
        
        .rifat-back-to-shop:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 768px) {
            .rifat-product-img {
                width: 60px;
                height: 60px;
            }
            
            .rifat-cart-table th, .rifat-cart-table td {
                padding: 10px;
            }
            
            .rifat-quantity-btn, .rifat-quantity-input {
                width: 25px;
                height: 25px;
            }
            
            .rifat-remove-btn {
                padding: 6px 10px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="rifat-container">
        <h1 class="rifat-heading">My Cart</h1>
        
        <?php if ($user !== null && $email !== null): ?>
            <div class="rifat-user-info">
                <p><strong>Logged in as:</strong> <?php echo htmlspecialchars($user); ?> (<?php echo htmlspecialchars($email); ?>)</p>
            </div>
            
            <?php if (empty($cartItems)): ?>
                <div class="rifat-cart-empty">
                    <i class="fas fa-shopping-cart"></i>
                    <h2>Your cart is empty</h2>
                    <p>Looks like you haven't added any products to your cart yet.</p>
                    <a href="shop-details.php">Continue Shopping</a>
                </div>
            <?php else: ?>
                <table class="rifat-cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $item): ?>
                            <tr>
                                <td>
                                    
                                    <img src="<?php echo htmlspecialchars($item['product_image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="rifat-product-img">
                                    <!-- after that product image not showing -->
                                    

                                </td>
                                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                <td>$<?php echo number_format($item['product_price'], 2); ?></td>
                                <td>
                                    <div class="rifat-quantity-control">
                                        <form method="post" action="my-cart.php">
                                            <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                                            <button type="submit" name="decrease" class="rifat-quantity-btn">-</button>
                                            <input type="text" class="rifat-quantity-input" value="<?php echo $item['product_quantity']; ?>" readonly>
                                            <button type="submit" name="increase" class="rifat-quantity-btn">+</button>
                                        </form>
                                    </div>
                                </td>
                                <td>$<?php echo number_format($item['product_price'] * $item['product_quantity'], 2); ?></td>
                                <td>
                                    <form method="post" action="remove_from_cart.php">
                                        <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                                        <button type="submit" class="rifat-remove-btn">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <div class="rifat-cart-summary">
                    <div class="rifat-summary-row">
                        <span>Subtotal</span>
                        <span>$<?php echo number_format($totalPrice, 2); ?></span>
                    </div>
                    <div class="rifat-summary-row">
                        <span>Shipping</span>
                        <span>Free</span>
                    </div>
                    <div class="rifat-summary-row">
                        <span>Total</span>
                        <span>$<?php echo number_format($totalPrice, 2); ?></span>
                    </div>
                    
                    <button class="rifat-checkout-btn">Proceed to Checkout</button>
                </div>
            <?php endif; ?>
            
            <a href="../products.php" class="rifat-back-to-shop">
                <i class="fas fa-arrow-left"></i> Continue Shopping
            </a>
            
        <?php else: ?>
            <div class="rifat-cart-empty">
                <i class="fas fa-exclamation-circle"></i>
                <h2>Please log in to view your cart</h2>
                <p>You need to be logged in to access your shopping cart.</p>
                <a href="../login.php">Log In</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
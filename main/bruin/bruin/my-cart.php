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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6f3727;
            --primary-light: #8a5142;
            --primary-dark: #5a2c1f;
            --accent: #c87d4d;
            --light: #f8f5f3;
            --dark: #2c2521;
            --gray: #7d7d7d;
            --light-gray: #e9e9e9;
            --white: #ffffff;
            --shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }
        
        .rifat-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .rifat-page-header {
            margin-bottom: 2.5rem;
        }
        
        .rifat-page-title {
            font-size: 2rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
            position: relative;
            display: inline-block;
        }
        
        .rifat-page-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 60px;
            height: 3px;
            background-color: var(--primary);
            border-radius: 2px;
        }
        
        .rifat-user-info-card {
            background-color: var(--white);
            border-radius: 10px;
            padding: 1.25rem;
            margin-bottom: 2rem;
            box-shadow: var(--shadow);
            border-left: 4px solid var(--primary);
            display: flex;
            align-items: center;
        }
        
        .rifat-user-info-card i {
            font-size: 1.5rem;
            color: var(--primary);
            margin-right: 1rem;
        }
        
        .rifat-user-info-card p {
            margin: 0;
            font-size: 0.95rem;
        }
        
        .rifat-user-info-card strong {
            color: var(--primary);
        }
        
        .rifat-empty-cart {
            background-color: var(--white);
            border-radius: 10px;
            padding: 3rem 2rem;
            text-align: center;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }
        
        .rifat-empty-cart i {
            font-size: 3.5rem;
            color: var(--gray);
            margin-bottom: 1.5rem;
        }
        
        .rifat-empty-cart h2 {
            color: var(--primary);
            margin-bottom: 1rem;
            font-weight: 600;
        }
        
        .rifat-empty-cart p {
            color: var(--gray);
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }
        
        .rifat-btn {
            display: inline-block;
            padding: 0.8rem 1.8rem;
            background-color: var(--primary);
            color: var(--white);
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            text-align: center;
        }
        
        .rifat-btn:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(111, 55, 39, 0.15);
        }
        
        .rifat-btn-outline {
            background-color: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }
        
        .rifat-btn-outline:hover {
            background-color: var(--primary);
            color: var(--white);
        }
        
        .rifat-cart-table-container {
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: var(--shadow);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .rifat-cart-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .rifat-cart-table th {
            background-color: var(--primary);
            color: var(--white);
            text-align: left;
            padding: 1rem 1.5rem;
            font-weight: 500;
            font-size: 0.95rem;
        }
        
        .rifat-cart-table td {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--light-gray);
            vertical-align: middle;
            font-size: 0.95rem;
        }
        
        .rifat-cart-table tr:last-child td {
            border-bottom: none;
        }
        
        .rifat-product-cell {
            display: flex;
            align-items: center;
        }
        
        .rifat-product-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        
        .rifat-product-name {
            font-weight: 500;
            color: var(--dark);
        }
        
        .rifat-price-cell {
            font-weight: 500;
            color: var(--primary);
        }
        
        .rifat-quantity-control {
            display: flex;
            align-items: center;
            background-color: var(--light);
            border-radius: 6px;
            padding: 0.2rem;
            width: fit-content;
        }
        
        .rifat-quantity-btn {
            background-color: var(--white);
            border: 1px solid var(--light-gray);
            width: 30px;
            height: 30px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            font-size: 1rem;
        }
        
        .rifat-quantity-btn:hover {
            background-color: var(--primary-light);
            color: var(--white);
            border-color: var(--primary-light);
        }
        
        .rifat-quantity-input {
            width: 40px;
            height: 30px;
            text-align: center;
            border: 1px solid var(--light-gray);
            margin: 0 0.5rem;
            border-radius: 4px;
            font-weight: 500;
            color: var(--dark);
        }
        
        .rifat-total-cell {
            font-weight: 600;
            color: var(--primary);
        }
        
        .rifat-remove-btn {
            background-color: #f8e9e7;
            color: var(--primary);
            border: 1px solid var(--primary);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .rifat-remove-btn:hover {
            background-color: var(--primary);
            color: var(--white);
        }
        
        .rifat-cart-summary {
            background-color: var(--white);
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }
        
        .rifat-summary-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--light-gray);
        }
        
        .rifat-summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--light-gray);
            font-size: 0.95rem;
        }
        
        .rifat-summary-row:last-of-type {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid var(--light-gray);
            font-weight: 700;
            font-size: 1.1rem;
            color: var(--primary);
        }
        
        .rifat-summary-label {
            color: var(--gray);
        }
        
        .rifat-summary-value {
            font-weight: 500;
        }
        
        .rifat-checkout-btn {
            display: block;
            width: 100%;
            padding: 1rem;
            background-color: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
        }
        
        .rifat-checkout-btn:hover {
            background-color: var(--primary-dark);
        }
        
        .rifat-back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            margin-top: 1rem;
        }
        
        .rifat-back-link:hover {
            color: var(--primary-dark);
        }
        
        .rifat-back-link i {
            font-size: 0.9rem;
        }
        
        .rifat-badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            background-color: #f3f3f3;
            color: var(--gray);
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        
        .rifat-badge-free {
            background-color: #e7f5eb;
            color: #28a745;
        }
        
        @media (max-width: 992px) {
            .rifat-container {
                padding: 1.5rem;
            }
        }
        
        @media (max-width: 768px) {
            .rifat-cart-table thead {
                display: none;
            }
            
            .rifat-cart-table tbody, .rifat-cart-table tr, .rifat-cart-table td {
                display: block;
                width: 100%;
            }
            
            .rifat-cart-table tr {
                margin-bottom: 1rem;
                border-bottom: 2px solid var(--light-gray);
                padding-bottom: 1rem;
            }
            
            .rifat-cart-table tr:last-child {
                margin-bottom: 0;
                border-bottom: none;
            }
            
            .rifat-cart-table td {
                text-align: right;
                padding: 0.75rem 1rem;
                position: relative;
                border-bottom: 1px solid var(--light-gray);
            }
            
            .rifat-cart-table td:last-child {
                border-bottom: none;
            }
            
            .rifat-cart-table td::before {
                content: attr(data-label);
                position: absolute;
                left: 1rem;
                width: 45%;
                white-space: nowrap;
                font-weight: 600;
                text-align: left;
            }
            
            .rifat-product-cell {
                justify-content: flex-end;
            }
            
            .rifat-quantity-control {
                margin-left: auto;
            }
            
            .rifat-remove-btn {
                margin-left: auto;
            }
        }
        
        @media (max-width: 576px) {
            .rifat-container {
                padding: 1rem;
            }
            
            .rifat-page-title {
                font-size: 1.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="rifat-container">
        <div class="rifat-page-header">
            <h1 class="rifat-page-title">Shopping Cart</h1>
        </div>
        
        <?php if ($user !== null && $email !== null): ?>
            <div class="rifat-user-info-card">
                <i class="fas fa-user-circle"></i>
                <p><strong>Welcome, <?php echo htmlspecialchars(strtoupper($user)); ?></strong></p>
            </div>
            
            <?php if (empty($cartItems)): ?>
                <div class="rifat-empty-cart">
                    <i class="fas fa-shopping-basket"></i>
                    <h2>Your cart is empty</h2>
                    <p>Looks like you haven't added any products to your cart yet.</p>
                    <a href="shop-details.php" class="rifat-btn">Explore Products</a>
                </div>
            <?php else: ?>
                <div class="rifat-cart-table-container">
                    <table class="rifat-cart-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr>
                                    <td data-label="Product" class="rifat-product-cell">
                                        <img src="<?php echo htmlspecialchars($item['product_image']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" class="rifat-product-img">
                                        <span class="rifat-product-name" style="margin-left:15px;"><?php echo htmlspecialchars($item['product_name']); ?></span>
                                    </td>
                                    <td data-label="Price" class="rifat-price-cell">$<?php echo number_format($item['product_price'], 2); ?></td>
                                    <td data-label="Quantity">
                                        <form method="post" action="my-cart.php" class="rifat-quantity-control">
                                            <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                                            <button type="submit" name="decrease" class="rifat-quantity-btn">-</button>
                                            <input type="text" class="rifat-quantity-input" value="<?php echo $item['product_quantity']; ?>" readonly>
                                            <button type="submit" name="increase" class="rifat-quantity-btn">+</button>
                                        </form>
                                    </td>
                                    <td data-label="Total" class="rifat-total-cell">$<?php echo number_format($item['product_price'] * $item['product_quantity'], 2); ?></td>
                                    <td data-label="Action">
                                        <form method="post" action="remove_from_cart.php">
                                            <input type="hidden" name="cart_id" value="<?php echo $item['id']; ?>">
                                            <button type="submit" class="rifat-remove-btn"><i class="fas fa-trash-alt"></i> Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="rifat-cart-summary">
                    <h3 class="rifat-summary-title">Order Summary</h3>
                    <div class="rifat-summary-row">
                        <span class="rifat-summary-label">Subtotal</span>
                        <span class="rifat-summary-value">$<?php echo number_format($totalPrice, 2); ?></span>
                    </div>
                    <div class="rifat-summary-row">
                        <span class="rifat-summary-label">Shipping</span>
                        <span class="rifat-summary-value"><span class="rifat-badge rifat-badge-free">Free</span></span>
                    </div>
                    <div class="rifat-summary-row">
                        <span class="rifat-summary-label">Total</span>
                        <span class="rifat-summary-value">$<?php echo number_format($totalPrice, 2); ?></span>
                    </div>
                    
                    <button class="rifat-checkout-btn">
                        <i class="fas fa-lock" style="margin-right:8px;"></i> Secure Checkout
                    </button>
                </div>
            <?php endif; ?>
            
            <a href="../products.php" class="rifat-back-link">
                <i class="fas fa-arrow-left"></i> Continue Shopping
            </a>
            
        <?php else: ?>
            <div class="rifat-empty-cart">
                <i class="fas fa-user-lock"></i>
                <h2>Please log in to view your cart</h2>
                <p>You need to be logged in to access your shopping cart.</p>
                <a href="../login.php" class="rifat-btn">Log In</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php 
session_start();
include '../bruin/db/db.php';
$user = $_SESSION['user'] ?? null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products | Premium Collections</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Raleway:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background-color: #f9f6f2;
            font-family: 'Raleway', sans-serif;
            color: #2c2418;
        }
        
        .rifat-main-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .rifat-products-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            padding: 40px 20px;
            margin: 110px auto 60px;
        }
        
        .rifat-product-card {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(111, 55, 39, 0.08);
            transition: all 0.3s ease;
            position: relative;
        }
        
        .rifat-product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(111, 55, 39, 0.15);
        }
        
        .rifat-product-img-container {
            position: relative;
            overflow: hidden;
            height: 250px;
        }
        
        .rifat-product-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }
        
        .rifat-product-card:hover .rifat-product-img {
            transform: scale(1.05);
        }
        
        .rifat-product-category {
            position: absolute;
            top: 15px;
            left: 0;
            background-color: #6f3727;
            color: #ffffff;
            padding: 6px 14px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.2);
        }
        
        .rifat-product-details {
            padding: 25px 20px;
        }
        
        .rifat-product-title {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            margin-bottom: 12px;
            color: #5a2c1b;
            position: relative;
            padding-bottom: 10px;
        }
        
        .rifat-product-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: #d3b292;
        }
        
        .rifat-product-description {
            font-size: 14px;
            line-height: 1.6;
            color: #665852;
            margin-bottom: 18px;
            height: 67px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
        
        .rifat-product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #efe6dc;
        }
        
        .rifat-product-price {
            font-size: 22px;
            font-weight: 600;
            color: #6f3727;
            font-family: 'Playfair Display', serif;
        }
        
        .rifat-product-stock {
            background-color: #eee8e0;
            color: #6f3727;
            padding: 5px 12px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 500;
        }
        
        .rifat-product-stock.low {
            background-color: #f4e9e6;
            color: #a94534;
        }
        
        .rifat-product-btn {
            display: block;
            width: 100%;
            background-color: #6f3727;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 14px;
            text-align: center;
            font-weight: 600;
            cursor: pointer;
            margin-top: 20px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 14px;
            text-decoration: none;
        }
        
        .rifat-product-btn:hover {
            background-color: #8a4531;
            letter-spacing: 1.5px;
        }
        

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .rifat-products-container {
                grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
                gap: 20px;
                margin-top: 80px;
            }
            
        
        @media (max-width: 480px) {
            .rifat-products-container {
                grid-template-columns: 1fr;
                gap: 25px;
            }
            
            .rifat-product-img-container {
                height: 220px;
            }
            
            
            
        }
    </style>
</head>

<body>

<?php include 'header.php'; ?>

  <!-- breadcrumb-area -->
  <section class="breadcrumb-area d-flex align-items-center" style="background-image:url(img/bg/bdrc-bg.jpg)">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-12 col-lg-12">
                            <div class="breadcrumb-wrap text-center">
                                <div class="breadcrumb-title">
                                    <h2>Products</h2>    
                                    <div class="breadcrumb-wrap">
                              
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Products</li>
                                        <li class="breadcrumb-item"><a href="../bruin/dashboard/dashboard.php">Dashboard</a></li>
                                        
                                        <li class="breadcrumb-item"><a href="my-cart.php">My Cart</a></li>
                                    </ol>
                                </nav>
                            </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </section>

<?php 
// get all products from the database
$sql = "SELECT * FROM orders";
$result = mysqli_query($conn, $sql);

echo "<div class='rifat-main-container'>";
echo "<div class='rifat-products-container'>";

// display all products
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    $image = $row['image'];
    $product = $row['order_name'];
    $quantity = $row['quantity'];
    $price = $row['price'];
    $description = $row['description'];
    $product_category = $row['product_category'];
    
    // Determine stock status
    $stock_class = ($quantity < 10) ? "low" : "";
    $stock_text = ($quantity < 10) ? "Low Stock" : "In Stock";

    echo "<div class='rifat-product-card'>";
    echo "<div class='rifat-product-img-container'>";
    echo "<img class='rifat-product-img' src='uploads/".$image."' alt='".$product."'>";
    echo "<div class='rifat-product-category'>".$product_category."</div>";
    echo "</div>";
    echo "<div class='rifat-product-details'>";
    echo "<h3 class='rifat-product-title'>".$product."</h3>";
    echo "<p class='rifat-product-description'>".$description."</p>";
    echo "<div class='rifat-product-footer'>";
    echo "<div class='rifat-product-price'>$".$price."</div>";
    echo "<div class='rifat-product-stock ".$stock_class."'>".$stock_text." (".$quantity.")</div>";
    echo "</div>";
    echo "<a href='shop-details.php?id=".$id."' class='rifat-product-btn'>View Details</a>";
    echo "</div>";
    echo "</div>";
}

echo "</div>";
echo "</div>";
?>

<?php include 'footer.php'; ?>
</body>
</html>
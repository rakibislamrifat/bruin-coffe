<?php 
session_start();
include '../bruin/db/db.php';
$user = $_SESSION['user'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Products</title>
    <style>
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Georgia', 'Times New Roman', Times, serif;
        }
        
        body {
            background-color: #f8f4f1;
            
        }
        
        .products-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            padding: 20px;
            max-width: auto;
            margin: 110px auto;
        }
        
        .product {
            background-color: white;
            border: 1px solid #e0d6d0;
            border-radius: 0;
            box-shadow: 2px 2px 10px rgba(111, 55, 39, 0.1);
            overflow: hidden;
            transition: box-shadow 0.3s ease;
        }
        
        .product:hover {
            box-shadow: 3px 3px 15px rgba(111, 55, 39, 0.2);
        }
        
        .product-img-container {
            position: relative;
            overflow: hidden;
            height: 220px;
            border-bottom: 2px solid #6f3727;
        }
        
        .product img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .product:hover img {
            transform: scale(1.02);
        }
        
        .product-category {
            position: absolute;
            bottom: 0;
            left: 0;
            background-color: #6f3727;
            color: #f8f4f1;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: normal;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        .product-details {
            padding: 20px;
        }
        
        .product h3 {
            font-size: 18px;
            font-weight: normal;
            margin-bottom: 10px;
            color: #6f3727;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e0d6d0;
            padding-bottom: 8px;
        }
        
        .product .description {
            font-size: 14px;
            color: #665852;
            margin-bottom: 15px;
            height: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            font-style: italic;
        }
        
        .product-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
            border-top: 1px solid #e0d6d0;
            padding-top: 12px;
        }
        
        .price {
            font-size: 18px;
            font-weight: bold;
            color: #6f3727;
        }
        
        .stock {
            background-color: #f0ebe5;
            color: #6f3727;
            padding: 4px 10px;
            border: 1px solid #d6c8bf;
            font-size: 13px;
            font-style: italic;
        }
        
        .stock.low {
            background-color: #f4e9e6;
            color: #873e2c;
            border-color: #d9b6aa;
        }
        
        .add-to-cart {
            display: block;
            width: 100%;
            background-color: #6f3727;
            color: white;
            border: none;
            padding: 12px;
            font-weight: normal;
            cursor: pointer;
            margin-top: 15px;
            transition: background-color 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 14px;
        }
        
        .add-to-cart:hover {
            background-color: #8a4531;
        }
    </style>
</head>

<body>

<?php include 'header.php'; ?>

<section class="breadcrumb-area d-flex align-items-center" style="background-image:url(img/bg/bdrc-bg.jpg)">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-12 col-lg-12">
                            <div class="breadcrumb-wrap text-center">
                                <div class="breadcrumb-title">
                                    <h2>All Product</h2>    
                                    <div class="breadcrumb-wrap">
                              
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">About</li>
                                        <li class="breadcrumb-item"><a href="../bruin/dashboard/dashboard.php">Dashboard</a></li>
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



echo "<div class='products-container'>";


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

    echo "<div class='product'>";
    echo "<div class='product-img-container'>";
    echo "<img src='uploads/".$image."' alt='".$product."'>";
    echo "<div class='product-category'>".$product_category."</div>";
    echo "</div>";
    echo "<div class='product-details'>";
    echo "<h3>".$product."</h3>";
    echo "<p class='description'>".$description."</p>";
    echo "<div class='product-footer'>";
    echo "<div class='price'>$".$price."</div>";
    echo "<div class='stock ".$stock_class."'>".$stock_text." (".$quantity.")</div>";
    echo "</div>";
    echo "<a href='shop-details.php?id=".$id."' class='add-to-cart'>Details Product</a>";
    echo "</div>";
    echo "</div>";
}

echo "</div>";

?>

<?php include 'footer.php'; ?>
</body>
</html>
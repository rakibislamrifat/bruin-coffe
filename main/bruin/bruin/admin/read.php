<?php require '../db/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }
        .rifat-card {
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            background-color: #ffffff;
        }
        .rifat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.12) !important;
        }
        .rifat-card-img-container {
            position: relative;
            height: 220px;
            overflow: hidden;
            background-color: #f5f5f5;
        }
        .rifat-card-img-top {
            transition: transform 0.5s ease;
        }
        .rifat-card:hover .rifat-card-img-top {
            transform: scale(1.05);
        }
        .rifat-card-body {
            padding: 1.8rem;
        }
        .rifat-card-title {
            font-weight: 600;
            margin-bottom: 1rem;
            color: #2c3e50;
            font-size: 1.25rem;
            border-bottom: 2px solid #f0f2f5;
            padding-bottom: 10px;
        }
        .rifat-price-tag {
            background: #6F3727;
            color: white;
            position: absolute;
            bottom: 15px;
            right: 15px;
            padding: 8px 15px;
            border-radius: 30px;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            letter-spacing: 0.5px;
        }
        .rifat-badge {
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }
        .rifat-description {
            color: #6c757d;
            height: 60px;
            overflow: hidden;
            margin-bottom: 20px;
            line-height: 1.6;
            font-size: 0.95rem;
        }
        .rifat-order-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid #eef2f7;
            margin-top: 15px;
        }
        .rifat-section-title {
            position: relative;
            margin-bottom: 2.5rem;
            padding-bottom: 1rem;
            color: #6F3727;
            font-weight: 600;
        }
        .rifat-section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: #6F3727;
        }
        .rifat-qty {
            display: inline-flex;
            align-items: center;
            background-color: #f0f2f7;
            color: #495057;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 500;
        }
        .rifat-details-btn {
            border-radius: 6px;
            font-weight: 500;
            padding: 8px 16px;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #6F3727 0%, #8e44ad 100%);
            border: none;
            color: white;
        }
        .rifat-details-btn:hover {
            box-shadow: 0 4px 10px rgba(78, 115, 223, 0.3);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
<div class="container my-5">
    <h2 class="mb-4 text-center rifat-section-title">Order Management System</h2>
    
    <div class="row g-4">
        <?php
        $sql = "SELECT * FROM orders ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-md-4 mb-4">
                    <div class="rifat-card shadow h-100">
                        <div class="rifat-card-img-container">
                            <img src="../uploads/<?php echo htmlspecialchars($row['image']); ?>" 
                                 class="rifat-card-img-top" 
                                 alt="<?php echo htmlspecialchars($row['order_name']); ?>" 
                                 style="height: 100%; width: 100%; object-fit: cover;">
                            <div class="rifat-price-tag">
                                $<?php echo number_format($row['price'], 2); ?>
                            </div>
                        </div>
                        <div class="rifat-card-body d-flex flex-column">
                            <h5 class="rifat-card-title"><?php echo htmlspecialchars($row['order_name']); ?></h5>
                            <div class="rifat-description">
                                <?php echo htmlspecialchars($row['description']); ?>
                            </div>
                            
                            <div class="mt-auto">
                                <div class="d-flex align-items-center mb-3">
                                    <span class="rifat-qty me-2">
                                        <i class="fas fa-box me-1"></i> Qty: <?php echo $row['quantity']; ?>
                                    </span>
                                    
                                </div>
                                
                                <div class="d-flex justify-content-between">
                                <div class="rifat-order-meta">
                                    <a href="update.php?id=<?php echo $row['id']; ?>" class="rifat-details-btn btn">
                                        <i class="fas fa-eye me-1"></i> Update Product
                                    </a>
                                </div>
                                <!-- delete button -->
                                
                                <div class="rifat-order-meta">
                                <a href="delete.php?id=<?php echo $row['id']; ?>" class="rifat-details-btn btn">
                                    <i class="fas fa-trash me-1"></i> Delete Product
                                </a>
                                </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="col-12 text-center">
                <div class="alert alert-info shadow-sm rifat-no-orders">
                    <i class="fas fa-info-circle me-2"></i> No orders found in the system.
                </div>
            </div>
            <?php
        }
        
        mysqli_close($conn);
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
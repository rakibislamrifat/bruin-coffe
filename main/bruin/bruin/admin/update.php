<?php
require '../db/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Handle update form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_name = mysqli_real_escape_string($conn, $_POST['order_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);
    
    // Handle image upload if provided
    $image = $_POST['existing_image']; // default to existing image
    
    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
        $targetDir = "../uploads/";
        
        // Create directory if it doesn't exist
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        
        $fileName = time() . '_' . basename($_FILES["image"]["name"]); // Add timestamp to avoid name conflicts
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        $allowedTypes = ['jpg', 'png', 'jpeg', 'gif', 'webp'];
        if (in_array(strtolower($fileType), $allowedTypes)) {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                // If upload successful, update the image name
                $image = $fileName;
            } else {
                $uploadError = "Sorry, there was an error uploading your file.";
            }
        } else {
            $uploadError = "Sorry, only JPG, JPEG, PNG, GIF & WEBP files are allowed.";
        }
    }

    $updateSql = "UPDATE orders SET 
                    order_name = '$order_name', 
                    description = '$description',
                    quantity = $quantity,
                    price = $price,
                    image = '$image'
                  WHERE id = $id";

    if (mysqli_query($conn, $updateSql)) {
        // Set success message and redirect
        header("Location: read.php?updated=true");
        exit();
    } else {
        $error = "Error updating record: " . mysqli_error($conn);
    }
}

// Fetch current order data
$sql = "SELECT * FROM orders WHERE id = $id";
$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) === 0) {
    die("Order not found.");
}
$order = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
        }
        .rifat-container {
            max-width: 900px;
            margin: 0 auto;
        }
        .rifat-card {
            border-radius: 12px;
            overflow: hidden;
            border: none;
            background-color: #ffffff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            padding: 2rem;
        }
        .rifat-section-title {
            position: relative;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            color: #2c3e50;
            font-weight: 600;
        }
        .rifat-section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 80px;
            height: 3px;
            background: #6F3727;
        }
        .rifat-form-label {
            color: #2c3e50;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        .rifat-form-control {
            border-radius: 8px;
            border: 1px solid #e1e5eb;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }
        .rifat-form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.25rem rgba(78, 115, 223, 0.25);
        }
        .rifat-textarea {
            min-height: 120px;
            resize: vertical;
        }
        .rifat-btn {
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            margin-right: 10px;
        }
        .rifat-btn-primary {
            background: #6F3727;
            border: none;
            color: white;
        }
        .rifat-btn-primary:hover {
            box-shadow: 0 4px 10px rgba(78, 115, 223, 0.3);
            transform: translateY(-2px);
        }
        .rifat-btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            border: none;
            color: white;
        }
        .rifat-btn-secondary:hover {
            box-shadow: 0 4px 10px rgba(108, 117, 125, 0.3);
            transform: translateY(-2px);
        }
        .rifat-img-preview {
            border-radius: 8px;
            border: 2px solid #e1e5eb;
            padding: 3px;
            max-width: 150px;
            height: auto;
            transition: all 0.3s ease;
        }
        .rifat-img-preview:hover {
            border-color: #4e73df;
        }
        .rifat-file-upload {
            border: 2px dashed #e1e5eb;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
            cursor: pointer;
            position: relative;
        }
        .rifat-file-upload:hover {
            border-color: #4e73df;
            background-color: #eef2ff;
        }
        .rifat-file-upload input[type="file"] {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
        .rifat-file-upload-label {
            color: #4e73df;
            font-weight: 500;
            display: block;
            margin-bottom: 5px;
        }
        .rifat-file-upload-icon {
            font-size: 1.5rem;
            color: #4e73df;
            margin-bottom: 10px;
        }
        .rifat-form-group {
            margin-bottom: 1.5rem;
        }
        .rifat-current-img-container {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        .alert {
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }
    </style>
</head>
<body>
<div class="container my-5 rifat-container">
    <div class="rifat-card">
        <h2 class="rifat-section-title">Update Order</h2>
        
        <?php if(isset($error)): ?>
        <div class="alert alert-danger mb-4">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo $error; ?>
        </div>
        <?php endif; ?>
        
        <?php if(isset($uploadError)): ?>
        <div class="alert alert-warning mb-4">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?php echo $uploadError; ?>
        </div>
        <?php endif; ?>
        
        <?php if(isset($_GET['success'])): ?>
        <div class="alert alert-success mb-4">
            <i class="fas fa-check-circle me-2"></i>
            Order updated successfully!
        </div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="rifat-form-group">
                        <label class="rifat-form-label">Order Name</label>
                        <input type="text" name="order_name" class="form-control rifat-form-control" 
                               value="<?php echo htmlspecialchars($order['order_name']); ?>" required>
                    </div>
                    
                    <div class="rifat-form-group">
                        <label class="rifat-form-label">Description</label>
                        <textarea name="description" class="form-control rifat-form-control rifat-textarea" 
                                  rows="4" required><?php echo htmlspecialchars($order['description']); ?></textarea>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="rifat-form-group">
                                <label class="rifat-form-label">Quantity</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-boxes"></i></span>
                                    <input type="number" name="quantity" class="form-control rifat-form-control" 
                                           value="<?php echo $order['quantity']; ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="rifat-form-group">
                                <label class="rifat-form-label">Price ($)</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    <input type="text" name="price" class="form-control rifat-form-control" 
                                           value="<?php echo $order['price']; ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="rifat-form-group">
                        <label class="rifat-form-label">Current Image</label>
                        <div class="rifat-current-img-container">
                            <?php if(isset($order['image']) && !empty($order['image'])): ?>
                                <img src="../uploads/<?php echo htmlspecialchars($order['image']); ?>" alt="Current Image" class="rifat-img-preview">
                            <?php else: ?>
                                <p class="text-muted">No image available</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="rifat-form-group">
                        <label class="rifat-form-label mb-2">Upload New Image (optional)</label>
                        <div class="rifat-file-upload">
                            <i class="fas fa-cloud-upload-alt rifat-file-upload-icon"></i>
                            <span class="rifat-file-upload-label">Click or drag file to upload</span>
                            <small class="text-muted">Supported formats: JPG, PNG, JPEG, GIF, WEBP</small>
                            <input type="file" name="image" class="form-control" id="imageUpload">
                        </div>
                        <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($order['image']); ?>">
                    </div>
                </div>
            </div>
            
            <div class="d-flex mt-4">
                <button type="submit" class="btn rifat-btn rifat-btn-primary">
                    <i class="fas fa-save me-2"></i> Update Order
                </button>
                <a href="read.php" class="btn rifat-btn rifat-btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Back
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('imageUpload').addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        let fileName = e.target.files[0].name;
        let fileLabel = document.querySelector('.rifat-file-upload-label');
        fileLabel.textContent = fileName;
    }
});
</script>
</body>
</html>
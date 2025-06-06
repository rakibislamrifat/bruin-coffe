<?php 
session_start();
include '../bruin/db/db.php';  // This should set $conn as your mysqli connection

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$product_query = "SELECT * FROM orders WHERE id = $id";
$result = mysqli_query($conn, $product_query);

$user = $_SESSION['user'] ?? null;
$email = null;

if ($user !== null) {
    // Get email of the logged in user using prepared statement
    $stmt = $conn->prepare("SELECT email FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->bind_result($email);
    $stmt->fetch();
    $stmt->close();

    if ($email !== null) {
        // echo " " ."<br>";
    } else {
        echo "User email not found.<br>";
    }
} else {
    echo "User not logged in.<br>";
}

if (!$result || mysqli_num_rows($result) === 0) {
    die("Product not found.");
}

$product = mysqli_fetch_assoc($result);

if (isset($_POST['add_cart'])) {
    // Sanitize inputs using mysqli_real_escape_string
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = floatval($_POST['product_price']);
    $product_quantity = intval($_POST['product_quantity']);
    $product_image = mysqli_real_escape_string($conn, $_POST['product_image']);
    $product_category = mysqli_real_escape_string($conn, $_POST['product_category']);
    $email_safe = mysqli_real_escape_string($conn, $email ?? '');

    if (empty($email_safe)) {
        echo "<script>alert('You must be logged in to add to cart.');</script>";
        exit;
    }

    // Create cart table if not exists
    $create_table_sql = "CREATE TABLE IF NOT EXISTS cart (
        id INT AUTO_INCREMENT PRIMARY KEY,
        product_id INT NOT NULL,
        product_name VARCHAR(255) NOT NULL,
        product_price FLOAT NOT NULL,
        product_quantity INT NOT NULL,
        product_image VARCHAR(255) NOT NULL,
        product_category VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if (!mysqli_query($conn, $create_table_sql)) {
        echo "<script>alert('Error creating cart table: " . mysqli_error($conn) . "');</script>";
    } else {
        // Check if product already exists in cart for this user (email)
        $check_sql = "SELECT * FROM cart WHERE product_id = '$product_id' AND email = '$email_safe'";
        $check_result = mysqli_query($conn, $check_sql);

        if (mysqli_num_rows($check_result) > 0) {
            // Update quantity if product already in cart
            $update_sql = "UPDATE cart SET product_quantity = product_quantity + $product_quantity 
                          WHERE product_id = '$product_id' AND email = '$email_safe'";
            if (mysqli_query($conn, $update_sql)) {
                echo "<script>alert('Product quantity updated in cart!');</script>";
            } else {
                echo "<script>alert('Failed to update cart: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            // Insert new product to cart
            $insert_sql = "INSERT INTO cart 
                (product_id, product_name, product_price, product_quantity, product_image, product_category, email) 
                VALUES 
                ('$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image', '$product_category', '$email_safe')";

            if (mysqli_query($conn, $insert_sql)) {
                echo "<script>alert('Product added to cart successfully!');</script>";
            } else {
                echo "<script>alert('Failed to add product to cart: " . mysqli_error($conn) . "');</script>";
            }
        }
    }
}
?>

<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Bruin - Coffee Shop HTML Template</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
        <!-- Place favicon.ico in the root directory -->

		<!-- CSS here -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/animate.min.css">
        <link rel="stylesheet" href="css/magnific-popup.css">
        <link rel="stylesheet" href="fontawesome/css/all.min.css">
        
        <link rel="stylesheet" href="css/dripicons.css">
        <link rel="stylesheet" href="css/slick.css">
        <link rel="stylesheet" href="css/meanmenu.css">
        <link rel="stylesheet" href="css/default.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/responsive.css">
        <style>
            
            .product-large-img img{
                height: 100%;
                width: 100%;
                object-fit: cover;
            }
        </style>
    </head>
    <body>
          <!-- header -->
        <header class="header-area header-three">
            <div class="header-top second-header d-none d-md-block">
                <div class="container">
                    <div class="row align-items-center">      
                        <div class="col-lg-6 col-md-6 d-none d-lg-block">
                             <div class="header-cta">
                               <ul>                                   
                                    <li>
                                       <i class="fas fa-clock"></i>
                                        <span>Mon - Fri: 9:00 - 19:00/ Closed on Weekends</span>
                                    </li>
                                  
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 d-none d-lg-block text-right">
                           <div class="header-social">
                                <span>
                                    
                                   
                                   </span>                    
                                   <!--  /social media icon redux -->                               
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 d-none d-lg-block mt-10 mb-10 text-right">
                           <div class="header-social">
                                        <span>
                                            <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                                            <a href="#" title="LinkedIn"><i class="fab fa-instagram"></i></a>               
                                            <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                                            <a href="#" title="Twitter"><i class="fab fa-youtube"></i></a>
                                           </span>                    
                                           <!--  /social media icon redux -->                               
                                    </div>
                        </div>
                         
                        
                    </div>
                </div>
            </div>		
			  <div id="header-sticky" class="menu-area">
                <div class="container">
                    <div class="second-menu">
                        <div class="row align-items-center">
                            <div class="col-xl-2 col-lg-2">
                                <div class="logo">
                                    <a href="index.php"><img src="img/logo/logo.png" alt="logo"></a>
                                </div>
                            </div>
                           <div class="col-xl-8 col-lg-8">
                              
                                <div class="main-menu text-right text-xl-right">
                                    <nav id="mobile-menu">
                                          <ul>
                                            <li class="has-sub">
                                                <a href="index.php">Home</a>
                                                
                                            </li>
                                            <li><a href="about.html">About</a></li>        
                                            <li><a href="menu.html">Menu</a></li>     
                                              <li class="has-sub">
                                                <a href="services.html">Services</a>
                                                <ul>													
													<li> <a href="services.html">Services</a></li>
                                                    <li> <a href="single-service.html">Services Details</a></li>
												</ul>
                                            </li>  
                                              <li class="has-sub"><a href="#">Pages</a>
												<ul>
                                                    <li><a href="projects.html">Gallery</a></li>
                                                    <li><a href="faq.html">Faq</a></li>
                                                    <li><a href="team.html">Team</a></li>
                                                    
                                                    <li><a href="shop.html">Shop</a></li>
													<li><a href="shop-details.php?id=<?php echo $product['id']; ?>">Shop Details</a>
                                                  </ul>
											</li>
                                            <li class="has-sub"> 
                                                <a href="blog.html">Blog</a>
                                                <ul>
                                                    <li><a href="blog.html">Blog</a></li>
                                                    <li><a href="blog-details.html">Blog Details</a></li>
                                                </ul>
                                            </li>


                                            <li><a href="contact.html">Contact</a></li>                                               
                                        </ul>
                                    </nav>
                                </div>
                            </div>   
                             <div class="col-xl-2 col-lg-2 text-right d-none d-lg-block mt-15 mb-15 text-right text-xl-right">
                               <div class="login">
                                    <ul>
                                        <li>
                                            <div class="second-header-btn">
                                               <a href="contact.html" class="btn">Book A Table</a>
                                            </div>
                                        </li>
                                    </ul>
                                
                                </div>
                            </div>
                            
                                <div class="col-12">
                                    <div class="mobile-menu"></div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- header-end -->
        <!-- main-area -->
        <main>
            
           <!-- breadcrumb-area -->
            <section class="breadcrumb-area d-flex align-items-center" style="background-image:url(img/bg/bdrc-bg.jpg)">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-12 col-lg-12">
                            <div class="breadcrumb-wrap text-center">
                                <div class="breadcrumb-title">
                                    <h2>Shop Details</h2>    
                                    <div class="breadcrumb-wrap">
                              
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Shop Details </li>
                                    </ol>
                                </nav>
                            </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </section>
            <!-- breadcrumb-area-end -->
            
			<!-- shop-banner-area start -->
        <section class="shop-banner-area pt-120 pb-90 " data-animation="fadeInUp animated" data-delay=".2s">
            <div class="container">
                <div class="row">
                    <div class="col-xl-7">
                        <div class="shop-thumb-tab mb-30">
                            <ul class="nav" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                                        aria-selected="true"><img src="uploads/<?php echo $product['image']; ?>" alt=""> </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                                        aria-selected="false"><img src="uploads/<?php echo $product['image']; ?>" alt=""></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab2" data-bs-toggle="tab" href="#profile1" role="tab"
                                        aria-selected="false"><img src="uploads/<?php echo $product['image']; ?>" alt=""></a>
                                </li>
                            </ul>
                        </div>
                        <div class="product-details-img mb-30">
                            <div class="tab-content" id="myTabContent2">
                                <div class="tab-pane fade show active" id="home" role="tabpanel">
                                    <div class="product-large-img">
                                        <img src="uploads/<?php echo $product['image']; ?>" alt="">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile" role="tabpanel">
                                    <div class="product-large-img">
                                        <img src="uploads/<?php echo $product['image']; ?>" alt="">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="profile1" role="tabpanel">
                                    <div class="product-large-img">
                                        <img src="uploads/<?php echo $product['image']; ?>" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5">
                        <div class="product-details mb-30">
                            <div class="product-details-title">
                                <p>Workstead</p>
                                <h1><?php echo $product['order_name']; ?></h1>
                                <div class="price details-price pb-30 mb-20">
                                    <span>$<?php echo $product['price']; ?></span>
                                    
                                </div>
                            </div>
                            <p><?php echo $product['description']; ?></p>
                            <div class="product-cat mt-30 mb-30">
                                <span>Category: </span>
                                <span><?php echo $product['product_category']; ?></span>
                                
                            </div>                            
                            <div class="product-details-action">
                            <form action="shop-details.php?id=<?php echo $product['id']; ?>" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <input type="hidden" name="product_name" value="<?php echo $product['order_name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo $product['image']; ?>">
                                <input type="hidden" name="product_category" value="Furniture"> <!-- or dynamic -->
                                <input type="hidden" name="email" value="<?php echo $email; ?>">
                                <div class="quantity-input mb-3">
                                    <label for="quantity">Quantity:</label>
                                    <input type="number" id="quantity" name="product_quantity" value="1" min="1" class="form-control" style="width: 100px; display: inline-block;">
                                </div>

                                <button type="submit" name="add_cart" class="btn btn-black">Add to Cart</button>
                            </form>
                            </div>
							<div class="product-social mt-45">
                                <a href="#"><i class="fab fa-facebook-f"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-behance"></i></a>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#"><i class="fab fa-youtube"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- shop-banner-area end -->
        <!-- product-desc-area start -->
        <section class="product-desc-area pb-55">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="bakix-details-tab">
                            <ul class="nav text-center justify-content-center pb-30 mb-50" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="desc-tab" data-bs-toggle="tab" href="#id-desc" role="tab"
                                        aria-bs-controls="home" aria-selected="true">Description </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="id-add-in" data-bs-toggle="tab" href="#id-add" role="tab"
                                        aria-bs-controls="profile" aria-selected="false">Additional Information</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="id-r" data-bs-toggle="tab" href="#id-rev" role="tab"
                                        aria-bs-controls="profile" aria-selected="false">Reviews(10)</a>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="id-desc" role="tabpanel" aria-labelledby="desc-tab">
                                <div class="event-text mb-40">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna
                                        aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi
                                        ut aliquip ex ea commodo consequat.
                                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                                        fugiat nulla pariatur. Excepteur sint
                                        occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim
                                        id est laborum. Sed ut perspiciatis
                                        unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
                                        totam rem aperiam, eaque ipsa quae ab
                                        illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                                        Nemo enim ipsam voluptatem quia
                                        voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores
                                        eos qui ratione voluptatem sequi
                                        nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet,
                                        consectetur, adipisci velit, sed quia non
                                        numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat
                                        voluptatem.</p>
                                    <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                                        deserunt mollit anim id est laborum. Sed ut
                                        perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                        laudantium, totam rem aperiam, eaque
                                        ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta
                                        sunt explicabo. Nemo enim ipsam voluptatem
                                        quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni
                                        dolores eos qui ratione voluptatem sequi
                                        nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet,
                                        consectetur, adipisci velit, sed quia non
                                        numquam eius modi tempora.</p>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="id-add" role="tabpanel" aria-labelledby="id-add-in">
                                <div class="additional-info">
                                    <div class="table-responsive">
                                        <h4>Additional information</h4>
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th>Weight</th>
                                                    <td class="product_weight">1.4 oz</td>
                                                </tr>
                                                <tr>
                                                    <th>Dimensions</th>
                                                    <td class="product_dimensions">62 × 56 × 12 in</td>
                                                </tr>
                                                <tr>
                                                    <th>Size</th>
                                                    <td class="product_dimensions">XL, XXL, LG, SM, MD</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="id-rev" role="tabpanel" aria-labelledby="id-r">
                                <div class="additional-info">
                                    <div class="event-text mb-40">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                            incididunt ut labore et dolore magna
                                            aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi
                                            ut aliquip ex ea commodo consequat.
                                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                                            fugiat nulla pariatur. Excepteur sint
                                            occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim
                                            id est laborum. Sed ut perspiciatis
                                            unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
                                            totam rem aperiam, eaque ipsa quae ab
                                            illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                                            Nemo enim ipsam voluptatem quia
                                            voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores
                                            eos qui ratione voluptatem sequi
                                            nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet,
                                            consectetur, adipisci velit, sed quia non
                                            numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat
                                            voluptatem.</p>
                                        <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia
                                            deserunt mollit anim id est laborum. Sed ut
                                            perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
                                            laudantium, totam rem aperiam, eaque
                                            ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta
                                            sunt explicabo. Nemo enim ipsam voluptatem
                                            quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni
                                            dolores eos qui ratione voluptatem sequi
                                            nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet,
                                            consectetur, adipisci velit, sed quia non
                                            numquam eius modi tempora.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- product-desc-area end -->
        
        </main>
        <!-- main-area-end -->
         <!-- footer -->
        <footer class="footer-bg footer-p">
         <div class="footer-top  pt-90 pb-40" style="background-color: #3f271e; background-image: url(img/bg/footer-bg.png);">
                <div class="container">
                    <div class="row justify-content-between">
                        
                          <div class="col-xl-4 col-lg-4 col-sm-6">
                            <div class="footer-widget mb-30">
                                <div class="f-widget-title mb-30">
                                   <img src="img/logo/logo.png" alt="img">
                                </div>
                                <div class="f-contact">
                                    <ul>
                                    <li>
                                        <i class="icon fal fa-phone"></i>
                                        <span>1800-121-3637<br>+91-7052-101-786</span>
                                    </li>
                                   <li><i class="icon fal fa-envelope"></i>
                                        <span>
                                            <a href="mailto:info@example.com">info@example.com</a>
                                       <br>
                                       <a href="mailto:help@example.com">help@example.com</a>
                                       </span>
                                    </li>
                                    <li>
                                        <i class="icon fal fa-map-marker-check"></i>
                                        <span>1247/Plot No. 39, 15th Phase,<br> LHB Colony, Kanpur</span>
                                    </li>
                                    
                                </ul>
                                    
                                    </div>
                            </div>
                        </div>
						<div class="col-xl-2 col-lg-2 col-sm-6">
                            <div class="footer-widget mb-30">
                                <div class="f-widget-title">
                                    <h2>Our Links</h2>
                                </div>
                                <div class="footer-link">
                                    <ul>                                        
                                        <li><a href="index.php">Home</a></li>
                                        <li><a href="about.html"> About Us</a></li>
                                        <li><a href="services.html"> Services </a></li>
                                        <li><a href="contact.html"> Contact Us</a></li>
                                        <li><a href="blog.html">Blog </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-sm-6">
                            <div class="footer-widget mb-30">
                                <div class="f-widget-title">
                                    <h2>Our Shop Location</h2>
                                </div>
                                <div class="footer-link">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d212867.83634504632!2d-112.24455686962897!3d33.52582710700138!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x872b743829374b03%3A0xabaac255b1e43fbe!2sPlexus%20Worldwide!5e0!3m2!1sen!2sin!4v1618567685329!5m2!1sen!2sin" width="600" height="190" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                                </div>
                            </div>
                        </div>  
                       
                    </div>
                </div>
            </div>
            <div class="copyright-wrap">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">                         
                           Copyright &copy; Bruin 2022 . All rights reserved.         
                        </div>
                        <div class="col-lg-6 text-right text-xl-right">                       
                           <div class="footer-social">                                    
                                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-instagram"></i></a>
                                </div>        
                        </div>
                        
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer-end -->
		<!-- JS here -->
        <script src="js/vendor/modernizr-3.5.0.min.js"></script>
        <script src="js/vendor/jquery-3.6.0.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/slick.min.js"></script>
        <script src="js/ajax-form.js"></script>
        <script src="js/paroller.js"></script>
        <script src="js/wow.min.js"></script>
        <script src="js/js_isotope.pkgd.min.js"></script>
        <script src="js/imagesloaded.min.js"></script>
        <script src="js/parallax.min.js"></script>
        <script src="js/jquery.waypoints.min.js"></script>
        <script src="js/jquery.counterup.min.js"></script>
        <script src="js/jquery.scrollUp.min.js"></script>
        <script src="js/jquery.meanmenu.min.js"></script>
        <script src="js/parallax-scroll.js"></script>
        <script src="js/jquery.magnific-popup.min.js"></script>
        <script src="js/element-in-view.js"></script>
        <script src="js/main.js"></script>
    </body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/meanmenu.css">
    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">   
</head>
<body>
    <!-- header -->
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
                                    <a href="index.html"><img src="img/logo/logo.png" alt="logo"></a>
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
                                            <li><a href="all-product.php">Products</a></li>  
                                            <li><a href="my-cart.php">Cart</a></li>

                                            <li><a href="contact.html">Contact</a></li> 
                                            <!-- if user is exist then show logout button or else show login button -->
                                         
                                            
                                            <?php if(isset($_SESSION['user'])){ ?>
                                                <li><a href="../bruin/auth/logout.php" <?php echo $user; ?>>
                                                    Logout</a></li>
                                            <?php } else { ?>
                                                <li><a href="../bruin/auth/login.php">Login</a></li>
                                            <?php } ?>
                                            <!-- show user name in a button -->
                                            <li><a <?php echo $user; ?>>
                                                <?php echo $user; ?></a></li>
                                                
                                            <!-- if user is logged in, show go to dashboard button -->
                                        

                                            
                                            <?php if ($user) { ?>
    <li><a href="../bruin/dashboard/dashboard.php">Dashboard</a></li>
<?php } ?>
                                           
                                            
                                                
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
</body>
</html>


<?php
include 'db/db.php';
session_start();
$user = $_SESSION['user'] ?? null;
$products = "SELECT * FROM orders";
$result = mysqli_query($conn, $products);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Bruin - Coffe Shop HTML Template</title>
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
        
        <!-- main-area -->
        <main>
           <!-- slider-area -->
            <section id="home" class="slider-area fix p-relative">
               
                <div class="slider-active" style="background: #101010;">
				<div class="single-slider slider-bg d-flex align-items-center" style="background-image: url(img/slider/cofee-1.jpg); background-size: cover;">
                        <div class="container">
                           <div class="row justify-content-center align-items-center">
                              
                                <div class="col-lg-7 col-md-7">
                                    <div class="slider-content s-slider-content mt-100">
                                         <h5 data-animation="fadeInUp" data-delay=".4s">Welcome To Bruin Cafe</h5>
                                         <h2 data-animation="fadeInUp" data-delay=".4s">Enjoy Your Morning Coffee Shot</h2>
                                        <p data-animation="fadeInUp" data-delay=".6s">Donec vitae libero non enim placerat eleifend aliquam erat volutpat. Curabitur diam ex, dapibus purus sapien, cursus sed nisl tristique, commodo gravida lectus non.</p>
                                        
                                          <div class="slider-btn mt-30 mb-105">     
                                            <a href="contact.html" class="btn ss-btn mr-15" data-animation="fadeInLeft" data-delay=".4s">Book  A Table</a>
                                              <a href="contact.html" class="btn ss-btn active" data-animation="fadeInLeft" data-delay=".4s">Visit Our Shop</a>
                                        </div>        
                                                              
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 p-relative">
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="single-slider slider-bg d-flex align-items-center" style="background-image: url(img/slider/slider-rifat.jpg); background-size: cover;">
                        <div class="container">
                           <div class="row justify-content-center align-items-center">
                              
                                <div class="col-lg-7 col-md-7">
                                    <div class="slider-content s-slider-content mt-100">
                                         <h5 data-animation="fadeInUp" data-delay=".4s">Welcome To Bruin Cafe</h5>
                                         <h2 data-animation="fadeInUp" data-delay=".4s">Enjoy Your Morning Coffee Shot</h2>
                                        <p data-animation="fadeInUp" data-delay=".6s">Donec vitae libero non enim placerat eleifend aliquam erat volutpat. Curabitur diam ex, dapibus purus sapien, cursus sed nisl tristique, commodo gravida lectus non.</p>
                                        
                                          <div class="slider-btn mt-30 mb-105">     
                                            <a href="contact.html" class="btn ss-btn mr-15" data-animation="fadeInLeft" data-delay=".4s">Book  A Table</a>
                                              <a href="contact.html" class="btn ss-btn active" data-animation="fadeInLeft" data-delay=".4s">Visit Our Shop</a>
                                        </div>        
                                                              
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-5 p-relative">
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    </div>
                    
               
            </section>
            <!-- slider-area-end -->
             <!-- brand-area -->
            <div class="brand-area pt-60 pb-60" style="background:#3f271e">
                <div class="container">
                    <div class="row brand-active">
                        <div class="col-xl-2">
                            <div class="single-brand">
                                <img src="img/brand/b-logo1.png" alt="img">
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="single-brand">
                                 <img src="img/brand/b-logo2.png" alt="img">
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="single-brand">
                                 <img src="img/brand/b-logo3.png" alt="img">
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="single-brand">
                                  <img src="img/brand/b-logo4.png" alt="img">
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="single-brand">
                                 <img src="img/brand/b-logo5.png" alt="img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- brand-area-end -->
             <!-- about-area -->
            <section class="about-area about-p pt-120 pb-120 p-relative fix">
               
                <div class="animations-02"><img src="img/bg/an-img-02.png" alt="contact-bg-an-01"></div>
                <div class="container">
                    <div class="row justify-content-center align-items-center">
                         <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="s-about-img p-relative  wow fadeInLeft animated" data-animation="fadeInLeft" data-delay=".4s">
                                <img src="img/features/about_img_02.png" alt="img">   
                               <div class="about-icon">
                                     <img src="img/features/about_img_03.png" alt="img">   
                                </div>
                            </div>
                          
                        </div>
                        
					<div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="about-content s-about-content  wow fadeInRight  animated pl-30" data-animation="fadeInRight" data-delay=".4s">
                                <div class="about-title second-title pb-25">  
                                    <h5><span class="circle-left"><img src="img/bg/circle-left.png" alt="img"></span> About Us</h5>
                                    <h2>Would You Like Delicious Coffee</h2>                                   
                                </div>
                                   <p>Morbi tortor urna, placerat vel arcu quis, fringilla egestas neque. Morbi sit amet porta erat, quis rutrum risus. Vivamus et gravida nibh, quis posuere felis. In commodo mi lectus, Integer ligula lorem, finibus vitae lorem vitae tincidunt dolor consequat quis.</p>
                                    <p>Cras finibus laoreet felis et hendrerit. Integer ligula lorem, finibus vitae lorem at, egestas consectetur urna. Integer id ultricies elit. Maecenas sodales nibh, quis posuere felis. In commodo mi lectus venenatis metus eget fringilla. Suspendisse varius ante eget lorem tempus blandit. Aenean eu vulputate lorem, quis auctor lectus.</p>
                                    <div class="about-content3 mt-30">
                                    <div class="row justify-content-center align-items-center">
                                    <div class="col-md-6">
                                        <div class="signature">
                                            <img src="img/features/signature.png" alt="img">   
                                            <h3 class="mt-10">Vincent Smith</h3>
                                        </div>
                                     
                                    </div>
                                         <div class="col-md-6 text-right">
                                              <div class="slider-btn">                                          
                                                     <a href="about.html" class="btn ss-btn smoth-scroll">Discover More</a>				
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                     
                    </div>
                </div>
            </section>
            <!-- about-area-end -->
            <!-- service-details2-area -->
            <section id="service-details2" class="pt-120 pb-380 p-relative" style="background-color: #f7f5f1;">
                 <div class="animations-01"><img src="img/bg/an-img-01.png" alt="an-img-01"></div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <div class="section-title center-align mb-50 text-center">
                                <h5><span class="circle-left"><img src="img/bg/circle-left.png" alt="img"></span> Our Features</h5>
                                <h2>
                                  What We Provide You
                                </h2>
                                <p>Proin consectetur non dolor vitae pulvinar. Pellentesque sollicitudin dolor eget neque viverra, sed interdum metus interdum. Cras lobortis pulvinar dolor, sit amet ullamcorper dolor iaculis vel</p>
                            </div>
                           
                        </div>
                         <div class="col-lg-3 col-md-3">
                                <div class="services-08-item">
                                    <div class="services-08-thumb">
                                     <img src="img/icon/fe-icon01.png" alt="img">
                                    </div>
                                    <div class="services-08-content">
                                        <h3><a href="single-service.html"> High Quality Coffee</a></h3>
                                        <p>Nullam molestie lacus sit amet velit fermentum feugiat. Mauris auctor eget nunc sit amet.</p>
                                        <a href="single-service.html">Read More <i class="fal fa-long-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                              <div class="col-lg-3 col-md-3">
                                <div class="services-08-item">
                                    <div class="services-08-thumb">
                                   <img src="img/icon/fe-icon04.png" alt="img">
                                    </div>
                                    <div class="services-08-content">
                                        <h3><a href="single-service.html">Barista Coffee Shops</a></h3>
                                       <p>Nullam molestie lacus sit amet velit fermentum feugiat. Mauris auctor eget nunc sit amet.</p>
                                         <a href="single-service.html">Read More <i class="fal fa-long-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                             <div class="col-lg-3 col-md-3">
                                <div class="services-08-item">
                                    <div class="services-08-thumb">
                                     <img src="img/icon/fe-icon05.png" alt="img">
                                    </div>
                                    <div class="services-08-content">
                                        <h3><a href="single-service.html">Shop Coffee Online</a></h3>
                                        <p>Nullam molestie lacus sit amet velit fermentum feugiat. Mauris auctor eget nunc sit amet.</p>
                                         <a href="single-service.html">Read More <i class="fal fa-long-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                              <div class="col-lg-3 col-md-3">
                                <div class="services-08-item">
                                    <div class="services-08-thumb">
                                    <img src="img/icon/fe-icon06.png" alt="img">
                                    </div>
                                    <div class="services-08-content">
                                        <h3><a href="single-service.html">Best Coffe Machine</a></h3>
                                        <p>Nullam molestie lacus sit amet velit fermentum feugiat. Mauris auctor eget nunc sit amet.</p>
                                         <a href="single-service.html">Read More <i class="fal fa-long-arrow-right"></i></a>
                                       
                                    </div>
                                </div>
                            </div>
                     
                    </div>
                </div>
            </section>
            <!-- service-details2-area-end -->
            
            <!-- booking-area -->
            <section class="booking pb-70">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                             <div class="contact-bg02">
                                <div class="section-title center-align">
                                    <h5><span class="circle-left"><img src="img/bg/circle-left-w.png" alt="img"></span> Contact Us</h5>
                                    <h2>
                                       Book Your Table Now !
                                    </h2>
                                </div>                                
                                <form action="mail.php" method="post" class="contact-form mt-30">
                                    <div class="row">
                                    <div class="col-lg-12">
                                        <div class="contact-field p-relative c-name mb-20">                                    
                                            <input type="text" id="firstn" name="firstn" placeholder="First Name" required>
                                        </div>                               
                                    </div>

                                    <div class="col-lg-6">                               
                                        <div class="contact-field p-relative c-subject mb-20">                                   
                                            <input type="text" id="email" name="email" placeholder="Eamil" required>
                                        </div>
                                    </div>		
                                    <div class="col-lg-6">                               
                                        <div class="contact-field p-relative c-subject mb-20">                                   
                                            <input type="text" id="phone" name="phone" placeholder="Phone No." required>
                                        </div>
                                    </div>	
                                    
                                    <div class="col-lg-6">                               
                                        <div class="contact-field p-relative c-option mb-20">                                   
                                            <input type="date" id="date" name="date">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">                               
                                        <div class="contact-field p-relative c-option mb-20">                                   
                                            <select name="services" id="sr">
                                              <option value="sports-massage">Time</option>
                                              <option value="hot-stone-message">9:30 PM</option>
                                                <option value="hot-stone-message">10:30 PM</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="slider-btn mt-15">                                          
                                                    <button class="btn ss-btn" data-animation="fadeInRight" data-delay=".8s"><span>Book Table Now</span></button>				
                                                </div>                             
                                    </div>
                                    </div>
                            </form>                            
                            </div>  
                                             
                        </div>
                        <div class="col-lg-6">
                             <div class="booking-img">
                                 <img src="img/bg/booking-img.png" alt="img">
                            </div>
                        </div>
					   <div class="booking-img2">
                                 <img src="img/bg/booking-img-2.png" alt="img">
                            </div>
                    </div>
                </div>
            </section>
            <!-- booking-area-end -->	
            <!-- Meal-area-start -->
            <section class="meal-select-section pt-120 pb-120 p-relative">
              <div class="animations-02"><img src="img/bg/an-img-04.png" alt="contact-bg-an-01"></div>
             <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title center-align mb-50 text-center">
                                <h5><span class="circle-left"><img src="img/bg/circle-left.png" alt="img"></span> Our Menu</h5>
                                <h2>
                                 What We Have In Here
                                </h2>
                                <p>Proin consectetur non dolor vitae pulvinar. Pellentesque sollicitudin dolor eget neque viverra, sed interdum metus interdum. Cras lobortis pulvinar dolor, sit amet ullamcorper dolor iaculis vel</p>
                            </div>
                           
                        </div>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-lg-12 col-md-12">
                            <div class="populer-meal">
                                <ul>
                                    <li>
                                        <div class="meal-container">
                                            <div class="meal-img">
                                                <img src="img/shop/img1.jpg" alt="img">
                                            </div>
                                            <div class="meal-content">
                                                <h5>
                                                    Coffe Latte
                                                </h5>   
                                                <p>Espresso and Light Layer of Crema</p>
                                            </div>
                                            <div class="line">
                                                <hr>
                                            </div>
                                             <div class="meal-price">
                                                  <strong>$12.90</strong>
                                             </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="meal-container">
                                            <div class="meal-img">
                                                <img src="img/shop/img2.jpg" alt="img">
                                            </div>
                                            <div class="meal-content">
                                                <h5>
                                                    Coffe Americano
                                                </h5>   
                                               <p>Espresso and Light Layer of Crema</p>
                                            </div>
                                            <div class="line">
                                                <hr>
                                            </div>
                                             <div class="meal-price">
                                                 <strong>$13.00</strong>
                                             </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="meal-container">
                                            <div class="meal-img">
                                                <img src="img/shop/img3.jpg" alt="img">
                                            </div>
                                            <div class="meal-content">
                                                <h5>
                                                    Macchiato
                                                </h5>   
                                                <p>Espresso and Light Layer of Crema</p>
                                            </div>
                                            <div class="line">
                                                <hr>
                                            </div>
                                             <div class="meal-price">
                                                 <strong>$13.00</strong>
                                             </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="meal-container">
                                            <div class="meal-img">
                                                <img src="img/shop/img4.jpg" alt="img">
                                            </div>
                                            <div class="meal-content">
                                                <h5>
                                                    Coffe Mocha
                                                </h5>   
                                                 <p>Espresso and Light Layer of Crema</p>
                                            </div>
                                            <div class="line">
                                                <hr>
                                            </div>
                                             <div class="meal-price">
                                                 <strong>$13.00</strong>
                                             </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="meal-container">
                                            <div class="meal-img">
                                                <img src="img/shop/img5.jpg" alt="img">
                                            </div>
                                            <div class="meal-content">
                                                <h5>
                                                   Cappuccino
                                                </h5>   
                                                 <p>Espresso and Light Layer of Crema</p>
                                            </div>
                                            <div class="line">
                                                <hr>
                                            </div>
                                             <div class="meal-price">
                                                 <strong>$13.00</strong>
                                             </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="meal-container">
                                            <div class="meal-img">
                                                <img src="img/shop/img6.jpg" alt="img">
                                            </div>
                                            <div class="meal-content">
                                                <h5>
                                                    Iced Coffe
                                                </h5>   
                                               <p>Espresso and Light Layer of Crema</p>
                                            </div>
                                            <div class="line">
                                                <hr>
                                            </div>
                                             <div class="meal-price">
                                                 <strong>$13.00</strong>
                                             </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="meal-container">
                                            <div class="meal-img">
                                                <img src="img/shop/img7.jpg" alt="img">
                                            </div>
                                            <div class="meal-content">
                                                <h5>
                                                    Chocolate Mocha
                                                </h5>   
                                                <p>Espresso and Light Layer of Crema</p>
                                            </div>
                                            <div class="line">
                                                <hr>
                                            </div>
                                             <div class="meal-price">
                                                 <strong>$13.00</strong>
                                             </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="meal-container">
                                            <div class="meal-img">
                                                <img src="img/shop/img8.jpg" alt="img">
                                            </div>
                                            <div class="meal-content">
                                                <h5>
                                                    Vanilla Latte
                                                </h5>   
                                                <p>Espresso and Light Layer of Crema</p>
                                            </div>
                                            <div class="line">
                                                <hr>
                                            </div>
                                             <div class="meal-price">
                                                 <strong>$13.00</strong>
                                             </div>
                                        </div>
                                    </li>
                                     <li>
                                        <div class="meal-container">
                                            <div class="meal-img">
                                                <img src="img/shop/img1.jpg" alt="img">
                                            </div>
                                            <div class="meal-content">
                                                <h5>
                                                    Iced Latte
                                                </h5>   
                                                <p>Espresso and Light Layer of Crema</p>
                                            </div>
                                            <div class="line">
                                                <hr>
                                            </div>
                                             <div class="meal-price">
                                                 <strong>$13.00</strong>
                                             </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="meal-container">
                                            <div class="meal-img">
                                                <img src="img/shop/img3.jpg" alt="img">
                                            </div>
                                            <div class="meal-content">
                                                <h5>
                                                   Espresso
                                                </h5>   
                                                <p>Espresso and Light Layer of Crema</p>
                                            </div>
                                            <div class="line">
                                                <hr>
                                            </div>
                                             <div class="meal-price">
                                                 <strong>$13.00</strong>
                                             </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="meal-container">
                                            <div class="meal-img">
                                                <img src="img/shop/img5.jpg" alt="img">
                                            </div>
                                            <div class="meal-content">
                                                <h5>
                                                   Caramel Latte
                                                </h5>   
                                                <p>Espresso and Light Layer of Crema</p>
                                            </div>
                                            <div class="line">
                                                <hr>
                                            </div>
                                             <div class="meal-price">
                                                 <strong>$13.00</strong>
                                             </div>
                                        </div>
                                    </li>
                                     <li>
                                        <div class="meal-container">
                                            <div class="meal-img">
                                                <img src="img/shop/img7.jpg" alt="img">
                                            </div>
                                            <div class="meal-content">
                                                <h5>
                                                    <strong> Cortado </strong>
                                                </h5>   
                                                <p>Espresso and Light Layer of Crema</p>
                                            </div>
                                            <div class="line">
                                                <hr>
                                            </div>
                                             <div class="meal-price">
                                                 <strong>$13.00</strong>
                                             </div>
                                        </div>
                                    </li>
                                </ul>
                                
                            </div>
                        </div>        
                        <div class="col-md-12 text-center">
                              <div class="slider-btn">                                          
                                     <a href="menu.html" class="btn ss-btn smoth-scroll">Discover More</a>				
                                </div>
                        </div>
                    </div>
                    
                </div>
        </section>
        <!-- Meal-area-end -->
             <!-- product-slider -->          
            <section  class="product-slider pt-120 pb-90 p-relative fix" style="background-color: #f7f5f1; ">
                 <div class="animations-01"><img src="img/bg/an-img-04.png" alt="contact-bg-an-01"></div>
                <div class="container">
                    <div class="row">   
                        <div class="col-lg-12">
                            <div class="section-title center-align mb-50 text-center">
                                <h5><span class="circle-left"><img src="img/bg/circle-left.png" alt="img"></span> Our Online Shop</h5>
                                <h2>
                                    Buy Our Featured Products
                                </h2>
                                <p>Proin consectetur non dolor vitae pulvinar. Pellentesque sollicitudin dolor eget neque viverra, sed interdum metus interdum. Cras lobortis pulvinar dolor, sit amet ullamcorper dolor iaculis vel</p>
                            </div>
                           
                        </div>
                         
                    </div>
                    <div class="row home-blog-active">
    <?php foreach ($products as $product): ?>
        <div class="col-lg-4 col-md-12">
            <div class="product mb-40">
                <div class="product__img">
                    <a href="shop-details.php?id=<?php echo $product['id']; ?>">
                        <img src="uploads/<?php echo $product['image']; ?>" alt="">
                    </a>
                    <div class="product-action text-center">
                        <a href="shop-details.php?id=<?php echo $product['id']; ?>">Add Cart</a>
                    </div>
                </div>
                <div class="product__content pt-30">
                    <h4 class="pro-title">
                        <a href="shop-details.php?id=<?php echo $product['id']; ?>"><?php echo $product['order_name']; ?></a>
                    </h4>
                    <div class="price">
                        <span>$<?php echo $product['price']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

                </div>
            </section>
            <!-- product-slider-end -->
               <!-- testimonial-area -->
            <section class="testimonial-area pt-120 pb-90 p-relative fix">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-title center-align mb-50 text-center">
                                <h5><span class="circle-left"><img src="img/bg/circle-left.png" alt="img"></span> Our Online Shop</h5>
                                <h2>
                                   What Our Clients Says
                                </h2>
                                <p>Proin consectetur non dolor vitae pulvinar. Pellentesque sollicitudin dolor eget neque viverra, sed interdum metus interdum. Cras lobortis pulvinar dolor, sit amet ullamcorper dolor iaculis vel</p>
                            </div>
                           
                        </div>
                        <div class="col-lg-12">
                            <div class="testimonial-active">
                                <div class="single-testimonial">
                                     <div class="testi-author">
                                        <img src="img/testimonial/testi_avatar.png" alt="img">
                                        <div class="ta-info">
                                            <h6>Jina Nilson</h6>
                                            <span>Client</span>
                                        </div>
                                    </div>
                                    <div class="review-icon">
                                        <img src="img/testimonial/review-icon.png" alt="img">
                                     </div>
                                    <p>“Phasellus aliquam quis lorem amet dapibus feugiat vitae purus vitae efficitur. Vestibulum sed elit id orci rhoncus ultricies. Morbi vitae semper consequat ipsum semper quam”.</p>
                                    
                                    <div class="qt-img">
                                    <img src="img/testimonial/qt-icon.png" alt="img">
                                    </div>
                                </div>
                               <div class="single-testimonial">
                                     <div class="testi-author">
                                        <img src="img/testimonial/testi_avatar_02.png" alt="img">
                                        <div class="ta-info">
                                            <h6>Braitly Dcosta</h6>
                                            <span>Client</span>
                                        </div>
                                    </div>
                                   <div class="review-icon">
                                        <img src="img/testimonial/review-icon.png" alt="img">
                                     </div>
                                      <p>“Phasellus aliquam quis lorem amet dapibus feugiat vitae purus vitae efficitur. Vestibulum sed elit id orci rhoncus ultricies. Morbi vitae semper consequat ipsum semper quam”.</p>
                                    
                                    <div class="qt-img">
                                    <img src="img/testimonial/qt-icon.png" alt="img">
                                    </div>
                                </div>
                               <div class="single-testimonial">
                                     <div class="testi-author">
                                        <img src="img/testimonial/testi_avatar.png" alt="img">
                                        <div class="ta-info">
                                            <h6>Jina Nilson</h6>
                                            <span>Client</span>
                                        </div>
                                    </div>
                                    <div class="review-icon">
                                        <img src="img/testimonial/review-icon.png" alt="img">
                                     </div>
                                    <p>“Phasellus aliquam quis lorem amet dapibus feugiat vitae purus vitae efficitur. Vestibulum sed elit id orci rhoncus ultricies. Morbi vitae semper consequat ipsum semper quam”.</p>
                                    
                                    <div class="qt-img">
                                    <img src="img/testimonial/qt-icon.png" alt="img">
                                    </div>
                                </div>
                               <div class="single-testimonial">
                                     <div class="testi-author">
                                        <img src="img/testimonial/testi_avatar_02.png" alt="img">
                                        <div class="ta-info">
                                            <h6>Braitly Dcosta</h6>
                                            <span>Client</span>
                                        </div>
                                    </div>
                                   <div class="review-icon">
                                        <img src="img/testimonial/review-icon.png" alt="img">
                                     </div>
                                      <p>“Phasellus aliquam quis lorem amet dapibus feugiat vitae purus vitae efficitur. Vestibulum sed elit id orci rhoncus ultricies. Morbi vitae semper consequat ipsum semper quam”.</p>
                                    
                                    <div class="qt-img">
                                    <img src="img/testimonial/qt-icon.png" alt="img">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </section>
            <!-- testimonial-area-end -->
            <!-- skill-area -->
            <section id="skill" class="skill-area p-relative fix" style="background: #3f271e;">
                 <div class="animations-01"><img src="img/bg/an-img-05.png" alt="contact-bg-an-05"></div>
                <div class="container">
                    <div class="row justify-content-center align-items-center">
					   <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="skills-content s-about-content">
                                <div class="skills-title pb-20">                               
                                    <h5><span class="circle-left"><img src="img/bg/circle-left-w.png" alt="img"></span> Coffee We Use</h5>
                                <h2>
                                 We Offer Wide Selection of Coffee
                                </h2>                             
                                </div>
                                <p>Vestibulum non ornare nunc. Maecenas a metus in est iaculis pretium. Aliquam ullamcorper nibh lacus, ac suscipit ipsum consequat porttitor.</p>
                                 <div class="skills-content s-about-content mt-20">
                                <div class="skills">
                                    <div class="skill mb-30">
                                      <div class="skill-name">Qulity Production</div>
                                      <div class="skill-bar">
                                        <div class="skill-per" id="80"></div>
                                      </div>
                                    </div>
                                     <div class="skill mb-30">
                                      <div class="skill-name">Maintenance Services</div>
                                      <div class="skill-bar">
                                        <div class="skill-per" id="90"></div>
                                      </div>
                                    </div>
                                      <div class="skill mb-30">
                                      <div class="skill-name">Product Managment</div>
                                      <div class="skill-bar">
                                        <div class="skill-per" id="70"></div>
                                      </div>
                                    </div>

                                </div>


                                
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 col-sm-12 pr-30">
                           <div class="skills-img">                               
                                  <img src="img/bg/skills-img.png" alt="img" class="img">              
                                </div>
                        </div>
                     
                    </div>
                </div>
            </section>
            <!-- skill-area-end -->
          
              <!-- blog-area -->
            <section id="blog" class="blog-area p-relative fix pt-90 pb-90">
                 <div class="animations-02"><img src="img/bg/an-img-06.png" alt="contact-bg-an-05"></div>
                <div class="container">
                    <div class="row align-items-center"> 
                        <div class="col-lg-12">
                            <div class="section-title center-align mb-50 text-center wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
                                 <h5><span class="circle-left"><img src="img/bg/circle-left.png" alt="img"></span> Our Blog</h5>
                                <h2>
                                    Latest Blog & News
                                </h2>
                                <p>Proin consectetur non dolor vitae pulvinar. Pellentesque sollicitudin dolor eget neque viverra, sed interdum metus interdum. Cras lobortis pulvinar dolor, sit amet ullamcorper dolor iaculis vel</p>
                            </div>
                           
                        </div>
                    </div>
                    <div class="row">
                       <div class="col-lg-4 col-md-6">
                            <div class="single-post2 hover-zoomin mb-30 wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                                <div class="blog-thumb2">
                                    <a href="blog-details.html"><img src="img/blog/inner_b1.jpg" alt="img"></a>
                                </div>                    
                                <div class="blog-content2">    
                                    <div class="date-home">
                                        24th March 2022
                                    </div>
                                    <h4><a href="blog-details.html">Cras accumsan nulla nec lacus ultricies placerat.</a></h4> 
                                    <p>Curabitur sagittis libero tincidunt tempor finibus. Mauris at dignissim ligula, nec tristique orci.</p>
                                    <div class="blog-btn"><a href="blog-details.html">Read More</a></div>
                                     
                                </div>
                            </div>
                        </div>
                         <div class="col-lg-4 col-md-6">
                            <div class="single-post2 mb-30 hover-zoomin wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                                <div class="blog-thumb2">
                                    <a href="blog-details.html"><img src="img/blog/inner_b2.jpg" alt="img"></a>
                                </div>
                                <div class="blog-content2">                                    
                                    <div class="date-home">
                                       24th March 2022
                                    </div>
                                    <h4><a href="blog-details.html">Dras accumsan nulla nec lacus ultricies placerat.</a></h4> 
                                    <p>Curabitur sagittis libero tincidunt tempor finibus. Mauris at dignissim ligula, nec tristique orci.</p>
                                    <div class="blog-btn"><a href="blog-details.html">Read More</a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="single-post2 mb-30 hover-zoomin wow fadeInUp animated" data-animation="fadeInUp" data-delay=".4s">
                                <div class="blog-thumb2">
                                    <a href="blog-details.html"><img src="img/blog/inner_b3.jpg" alt="img"></a>
                                </div>
                                <div class="blog-content2">                                    
                                    <div class="date-home">
                                        24th March 2022
                                    </div>
                                    <h4><a href="blog-details.html">Seas accumsan nulla nec lacus ultricies placerat.</a></h4> 
                                    <p>Curabitur sagittis libero tincidunt tempor finibus. Mauris at dignissim ligula, nec tristique orci.</p>
                                    <div class="blog-btn"><a href="blog-details.html">Read More</a></div>
                                </div>
                            </div>
                        </div>
                
                        
                    </div>
                </div>
            </section>
            <!-- blog-area-end -->
            <!-- newslater-area -->
            <section class="newslater-area p-relative pt-120 pb-120" style="background-color: #f7f5f1;">
                <div class="animations-01"><img src="img/bg/an-img-07.png" alt="contact-bg-an-05"></div>
                <div class="container">
                    <div class="row justify-content-center align-items-center text-center">
                        <div class="col-xl-9 col-lg-9">
                            <div class="section-title center-align mb-40 text-center wow fadeInDown animated" data-animation="fadeInDown" data-delay=".4s">
                                 <h5><span class="circle-left"><img src="img/bg/circle-left.png" alt="img"></span> Newsletter</h5>
                                <h2>
                                    Get Best Offers On The Coffee
                                </h2>
                                <p>With the subscription, enjoy your favourite coffees without having to think about it</p>
                            </div>
                            <form name="ajax-form" id="contact-form4" action="#" method="post" class="contact-form newslater">
                               <div class="form-group">
                                  <input class="form-control" id="email2" name="email" type="email" placeholder="Your Email Address" value="" required=""> 
                                  <button type="submit" class="btn btn-custom" id="send2">Subscribe Now</button>
                               </div>
                               <!-- /Form-email -->	
                            </form>
                        </div>
                       
                    </div>
                   
                </div>
            </section>
            <!-- newslater-aread-end -->
         <!-- gallery-area -->
            <section class="profile fix">
                <div class="container-fluid"> 
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="masonry-gallery-huge">
                        <div class="grid col2">

                            <div class="grid-item financial">   
                                <a class="popup-image" href="img/gallery/protfolio-img01.png">
                                    <figure class="gallery-image">
                                      <img src="img/gallery/protfolio-img01.png" alt="img" class="img">   
                                    </figure>
                                </a>

                            </div>
                            <div class="grid-item banking">
                                  <a class="popup-image" href="img/gallery/protfolio-img02.png">
                                        <figure class="gallery-image">
                                          <img src="img/gallery/protfolio-img02.png" alt="img" class="img"> 
                                        </figure>
                                    </a>


                            </div>
                             <div class="grid-item insurance">
                               <a class="popup-image" href="img/gallery/protfolio-img03.png">
                                        <figure class="gallery-image">
                                          <img src="img/gallery/protfolio-img03.png" alt="img" class="img">     
                                        </figure>
                                    </a>

                            </div>
                                <div class="grid-item family">    
                                    <a class="popup-image" href="img/gallery/protfolio-img04.png">
                                        <figure class="gallery-image">
                                          <img src="img/gallery/protfolio-img04.png" alt="img" class="img">    
                                        </figure>
                                    </a>
                            </div>
                            <div class="grid-item business">
                             <a class="popup-image" href="img/gallery/protfolio-img05.png">
                                        <figure class="gallery-image">
                                          <img src="img/gallery/protfolio-img05.png" alt="img" class="img">
                                        </figure>
                                    </a>

                            </div>
                            
                            </div>
                    </div>
                        
                        </div>
                    
                    </div>
					
                </div>
            </section>
             <!-- gallery-area-end -->
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
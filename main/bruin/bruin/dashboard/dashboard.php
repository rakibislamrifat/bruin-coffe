<?php
/* Template Name: My Dashboard */
require '../db/db.php';
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}
// load all the data from the database
$sql = "SELECT * FROM orders";
$result = mysqli_query($conn, $sql);
$orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
$users = "SELECT * FROM users";
$result = mysqli_query($conn, $users);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegant Dashboard</title>
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Raleway:wght@300;400;500;600&display=swap">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #2c3e50;
            --primary-light: #6F3727;
            --accent: #9b59b6;
            --text: #6F3727;
            --text-light: #7f8c8d;
            --bg-light: #f8f9fa;
            --white: #ffffff;
            --shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            --shadow-hover: 0 8px 25px rgba(0, 0, 0, 0.1);
            --gradient: linear-gradient(135deg, #6F3727, #8e44ad);
            --gradient-light: linear-gradient(135deg, #6F3727, rgba(142, 68, 173, 0.8));
            --border-radius: 12px;
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Raleway', sans-serif;
            background-color: var(--bg-light);
            color: var(--text);
            line-height: 1.6;
            font-weight: 400;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
        }
        
        .rifat-dashboard {
            display: flex;
            min-height: 100vh;
        }
        
        .rifat-sidebar {
            width: 280px;
            background-color: var(--white);
            padding: 40px 25px;
            color: var(--text);
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
        }
        
        .rifat-logo {
            display: flex;
            align-items: center;
            margin-bottom: 50px;
        }
        
        .rifat-logo-icon {
            font-size: 28px;
            margin-right: 15px;
            color: var(--accent);
        }
        
        .rifat-logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
        }
        
        .rifat-menu {
            list-style-type: none;
            margin-bottom: auto;
        }
        
        .rifat-menu-item {
            padding: 15px;
            border-radius: var(--border-radius);
            margin-bottom: 10px;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            align-items: center;
            color: var(--text);
            position: relative;
            overflow: hidden;
        }
        
        /* .rifat-menu-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 0;
            background: var(--gradient-light);
            transition: var(--transition);
            opacity: 0;
            z-index: -1;
        } */
        
        .rifat-menu-item:hover {
            color: #6F3727;
        }
        
        .rifat-menu-item:hover::before {
            width: 100%;
            opacity: 1;
        }
        
        .rifat-menu-item.active {
            background: var(--gradient);
            color: white;
            box-shadow: 0 4px 15px ;
        }
        .rifat-menu-text{
            color: #6F3727 !important;
            text-decoration: none;
        }
        
        .rifat-menu-icon {
            margin-right: 15px;
            font-size: 18px;
            width: 20px;
            text-align: center;
        }
        
        .rifat-user-profile {
            display: flex;
            align-items: center;
            padding-top: 20px;
            border-top: 1px solid rgba(0,0,0,0.05);
            margin-top: 20px;
        }
        
        .rifat-user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gradient);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 12px;
        }
        
        .rifat-user-info {
            font-size: 14px;
        }
        
        .rifat-user-name {
            font-weight: 600;
            color: var(--primary);
        }
        
        .rifat-user-role {
            font-size: 12px;
            color: var(--text-light);
        }
        
        .rifat-main-content {
            flex: 1;
            padding: 40px 50px;
        }
        
        .rifat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }
        
        .rifat-welcome {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            color: var(--primary);
        }
        
        .rifat-logout-button {
            display: inline-block;
            padding: 10px 24px;
            background: linear-gradient(135deg, #6F3727, #8e44ad);
            color: #ffffff;
            text-decoration: none;
            border: none;
            border-radius: 30px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            box-shadow: 0 6px 12px rgba(0, 114, 255, 0.25);
            transition: all 0.3s ease;
        }

        .rifat-logout-button:hover {
            background: linear-gradient(135deg, #0072ff, #00c6ff);
            box-shadow: 0 8px 16px rgba(0, 114, 255, 0.35);
            transform: translateY(-3px);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }
        
        .rifat-cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .rifat-card {
            background-color: var(--white);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }
        
        .rifat-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 0;
            height: 5px;
            background: var(--gradient);
            transition: var(--transition);
        }
        
        .rifat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }
        
        .rifat-card:hover::after {
            width: 100%;
        }
        
        .rifat-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            margin-bottom: 20px;
            color: var(--primary);
            position: relative;
            display: inline-block;
        }
        
        .rifat-card-content {
            margin-bottom: 25px;
            color: var(--text-light);
            font-size: 15px;
            line-height: 1.7;
        }
        
        .rifat-card-content ul {
            list-style-position: inside;
            margin-left: 5px;
        }
        
        .rifat-card-content li {
            margin-bottom: 8px;
            position: relative;
        }
        
        .rifat-btn {
            display: inline-block;
            background: var(--gradient);
            color: var(--white);
            padding: 12px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            text-align: center;
            font-family: 'Raleway', sans-serif;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(155, 89, 182, 0.3);
        }
        
        .rifat-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(155, 89, 182, 0.4);
        }
        
        .rifat-btn-large {
            font-family: 'Raleway', sans-serif;
            font-size: 16px;
            padding: 15px 35px;
        }
        
        .rifat-highlight-card {
            grid-column: span 2;
            background: linear-gradient(135deg, rgba(155, 89, 182, 0.05), rgba(142, 68, 173, 0.1));
            border: 1px solid rgba(155, 89, 182, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 50px;
        }
        
        .rifat-highlight-card .rifat-card-title {
            color: var(--primary);
            font-size: 28px;
            margin-bottom: 25px;
        }
        
        .rifat-highlight-card .rifat-card-content {
            margin-bottom: 30px;
            font-size: 16px;
            max-width: 700px;
            color: var(--text);
        }
        
        .rifat-stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .rifat-stat-card {
            background-color: var(--white);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
        }
        
        .rifat-stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #6F3727;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            color: white;
            font-size: 24px;
        }
        
        .rifat-stat-info {
            flex: 1;
        }
        
        .rifat-stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            font-family: 'Playfair Display', serif;
        }
        
        .rifat-stat-label {
            font-size: 14px;
            color: var(--text-light);
        }
        
        .rifat-mobile-menu-toggle {
            display: none;
            font-size: 24px;
            color: var(--primary);
            background: none;
            border: none;
            cursor: pointer;
            margin-right: 15px;
        }
        
        .rifat-mobile-menu-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 99;
            display: none;
        }
        
        .rifat-mobile-menu-backdrop.active {
            display: block;
        }
        
        @media (max-width: 992px) {
            .rifat-stats-row {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .rifat-dashboard {
                flex-direction: column;
            }
            
            .rifat-sidebar {
                width: 100%;
                padding: 20px;
                position: fixed;
                top: 0;
                left: -100%;
                height: 100%;
                z-index: 100;
                transition: var(--transition);
            }
            
            .rifat-sidebar.active {
                left: 0;
            }
            
            .rifat-main-content {
                padding: 30px 20px;
                margin-top: 60px;
            }
            
            .rifat-mobile-menu-toggle {
                display: block;
                position: fixed;
                top: 15px;
                left: 15px;
                z-index: 101;
                background: var(--white);
                width: 45px;
                height: 45px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: var(--shadow);
            }
            
            .rifat-cards-container {
                grid-template-columns: 1fr;
            }
            
            .rifat-highlight-card {
                grid-column: span 1;
                padding: 30px 20px;
            }
            
            .rifat-stats-row {
                grid-template-columns: 1fr;
            }
            
            .rifat-welcome {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <?php
    // PHP code to handle form redirect
    function redirect_to_form() {
        // You can change this URL to your form's actual location
        $form_url = "form.php";
        header("Location: " . $form_url);
        exit();
    }

    // If the button is clicked, redirect to the form
    if(isset($_POST['go_to_form'])) {
        redirect_to_form();
    }

    // Get current user info (replace with your actual user data retrieval)
    $user_role = isset($_SESSION['role']) ? $_SESSION['role'] : 'user';
    $user_initials = "RF";
    ?>

    <div class="rifat-dashboard">
        <!-- Mobile Menu Toggle -->
        <button id="rifat-mobile-menu-toggle" class="rifat-mobile-menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Mobile Menu Backdrop -->
        <div id="rifat-mobile-menu-backdrop" class="rifat-mobile-menu-backdrop"></div>
        
        <div id="rifat-sidebar" class="rifat-sidebar">
            <div class="rifat-logo">
                <div class="rifat-logo-icon">
                    <i class="fas fa-crown"></i>
                </div>
                <div class="rifat-logo-text">Elegance</div>
            </div>
            
            <ul class="rifat-menu">
                <li class="rifat-menu-item ">
                    <span class="rifat-menu-icon"><i class="fas fa-home"></i></span>
                    <span class="rifat-menu-text">Dashboard</span>
                </li>
                
                
            </ul>
            
            <div class="rifat-user-profile">
                <div class="rifat-user-avatar"><?php echo substr($user_initials, 0, 2); ?></div>
                <div class="rifat-user-info">
                    <div class="rifat-user-name"><?= htmlspecialchars($_SESSION['user']); ?>!</div>
                    <!-- get user role from database -->
                    <?php
                    $user_role = "user";
                    ?>
                    <div class="rifat-user-role"><?= htmlspecialchars($user_role); ?>!</div>
                </div>
            </div>
        </div>
        
        <div class="rifat-main-content">
            <div class="rifat-header">
                <div class="rifat-welcome">Welcome, <?= htmlspecialchars($_SESSION['user']); ?>! 😊</div>
                <div>
                    <a class="rifat-logout-button" href="../auth/logout.php">Logout</a>
                </div>
            </div>
            
            <div class="rifat-stats-row">
                <div class="rifat-stat-card">
                    <div class="rifat-stat-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="rifat-stat-info">
                        <div class="rifat-stat-value"><?php echo count($orders); ?></div>
                        <div class="rifat-stat-label">Total Products</div>
                    </div>
                </div>
                
                <div class="rifat-stat-card">
                    <div class="rifat-stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="rifat-stat-info">
                        <div class="rifat-stat-value">28</div>
                        <div class="rifat-stat-label">Total Orders</div>
                    </div>
                </div>
                
                <div class="rifat-stat-card">
                    <div class="rifat-stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="rifat-stat-info">
                        <div class="rifat-stat-value"><?php echo count($users); ?></div>
                        <div class="rifat-stat-label">Total Users</div>
                    </div>
                </div>
            </div>
            
            <div class="rifat-cards-container">
               
                
                <div class="rifat-card rifat-highlight-card">
                    <div class="rifat-card-title">You can do anything</div>
                    <div class="rifat-card-content">
                        Our intuitive forms make it easy to submit your information quickly and efficiently. Click below to start the submission process and take the first step towards your goals.
                    </div>
                    <div style="display: flex; gap: 20px;">
                        <form method="post">
                        <a href="../admin/create.php" class="rifat-btn rifat-btn-large">Post Data</a>   
                        </form>
                        <a href="../admin/read.php" class="rifat-btn rifat-btn-large">See Products</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle functionality
            const mobileMenuToggle = document.getElementById('rifat-mobile-menu-toggle');
            const sidebar = document.getElementById('rifat-sidebar');
            const backdrop = document.getElementById('rifat-mobile-menu-backdrop');
            
            mobileMenuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('active');
                backdrop.classList.toggle('active');
                
                // Toggle icon between bars and times
                const icon = this.querySelector('i');
                if (icon.classList.contains('fa-bars')) {
                    icon.classList.remove('fa-bars');
                    icon.classList.add('fa-times');
                } else {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
            
            // Close sidebar when backdrop is clicked
            backdrop.addEventListener('click', function() {
                sidebar.classList.remove('active');
                backdrop.classList.remove('active');
                
                const icon = mobileMenuToggle.querySelector('i');
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            });
            
            // Add click event listeners to menu items
            const menuItems = document.querySelectorAll('.rifat-menu-item');
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Remove active class from all menu items
                    menuItems.forEach(i => i.classList.remove('active'));
                    
                    // Add active class to clicked item
                    this.classList.add('active');
                    
                    // If clicked on Forms menu item, redirect to form
                    if(this.querySelector('span:last-child').textContent === 'Forms') {
                        document.querySelector('button[name="go_to_form"]').click();
                    }
                    
                    // Close mobile menu if open
                    if(window.innerWidth <= 768) {
                        sidebar.classList.remove('active');
                        backdrop.classList.remove('active');
                        
                        const icon = mobileMenuToggle.querySelector('i');
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                });
            });
            
            // Animated counters for stat values (optional enhancement)
            const statValues = document.querySelectorAll('.rifat-stat-value');
            statValues.forEach(value => {
                const finalValue = parseInt(value.textContent);
                value.textContent = '0';
                
                let counter = 0;
                const interval = setInterval(() => {
                    counter += Math.ceil(finalValue / 20);
                    if(counter > finalValue) {
                        value.textContent = finalValue.toString();
                        clearInterval(interval);
                    } else {
                        value.textContent = counter.toString();
                    }
                }, 50);
            });
        });
    </script>
</body>
</html>
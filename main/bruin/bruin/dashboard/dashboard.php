<?php
/* Template Name: My Dashboard */
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../auth/login.php");
    exit;
}
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
            --primary-light: #34495e;
            --accent: #9b59b6;
            --text: #2c3e50;
            --text-light: #7f8c8d;
            --bg-light: #f8f9fa;
            --white: #ffffff;
            --shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            --shadow-hover: 0 8px 25px rgba(0, 0, 0, 0.1);
            --gradient: linear-gradient(135deg, #9b59b6, #8e44ad);
            --gradient-light: linear-gradient(135deg, rgba(155, 89, 182, 0.8), rgba(142, 68, 173, 0.8));
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
        
        .jahbulonn-dashboard {
            display: flex;
            min-height: 100vh;
        }
        
        .jahbulonn-sidebar {
            width: 280px;
            background-color: var(--white);
            padding: 40px 25px;
            color: var(--text);
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
        }
        
        .jahbulonn-logo {
            display: flex;
            align-items: center;
            margin-bottom: 50px;
        }
        
        .jahbulonn-logo-icon {
            font-size: 28px;
            margin-right: 15px;
            color: var(--accent);
        }
        
        .jahbulonn-logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
        }
        
        .jahbulonn-menu {
            list-style-type: none;
            margin-bottom: auto;
        }
        
        .jahbulonn-menu-item {
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
        
        .jahbulonn-menu-item::before {
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
        }
        
        .jahbulonn-menu-item:hover {
            color: rgba(142, 68, 173, 0.8);
        }
        
        .jahbulonn-menu-item:hover::before {
            width: 100%;
            opacity: 1;
        }
        
        .jahbulonn-menu-item.active {
            background: var(--gradient);
            color: var(--white);
            box-shadow: 0 4px 15px rgba(155, 89, 182, 0.3);
        }
        
        .jahbulonn-menu-icon {
            margin-right: 15px;
            font-size: 18px;
            width: 20px;
            text-align: center;
        }
        
        .jahbulonn-user-profile {
            display: flex;
            align-items: center;
            padding-top: 20px;
            border-top: 1px solid rgba(0,0,0,0.05);
            margin-top: 20px;
        }
        
        .jahbulonn-user-avatar {
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
        
        .jahbulonn-user-info {
            font-size: 14px;
        }
        
        .jahbulonn-user-name {
            font-weight: 600;
            color: var(--primary);
        }
        
        .jahbulonn-user-role {
            font-size: 12px;
            color: var(--text-light);
        }
        
        .jahbulonn-main-content {
            flex: 1;
            padding: 40px 50px;
        }
        
        .jahbulonn-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }
        
        .jahbulonn-welcome {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            color: var(--primary);
        }
        
        .jahbulonn-logout-button {
            display: inline-block;
            padding: 10px 24px;
            background: linear-gradient(135deg, #00c6ff, #0072ff);
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

        .jahbulonn-logout-button:hover {
            background: linear-gradient(135deg, #0072ff, #00c6ff);
            box-shadow: 0 8px 16px rgba(0, 114, 255, 0.35);
            transform: translateY(-3px);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }
        
        .jahbulonn-cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .jahbulonn-card {
            background-color: var(--white);
            border-radius: var(--border-radius);
            padding: 30px;
            box-shadow: var(--shadow);
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }
        
        .jahbulonn-card::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 0;
            height: 5px;
            background: var(--gradient);
            transition: var(--transition);
        }
        
        .jahbulonn-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }
        
        .jahbulonn-card:hover::after {
            width: 100%;
        }
        
        .jahbulonn-card-title {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            margin-bottom: 20px;
            color: var(--primary);
            position: relative;
            display: inline-block;
        }
        
        .jahbulonn-card-content {
            margin-bottom: 25px;
            color: var(--text-light);
            font-size: 15px;
            line-height: 1.7;
        }
        
        .jahbulonn-card-content ul {
            list-style-position: inside;
            margin-left: 5px;
        }
        
        .jahbulonn-card-content li {
            margin-bottom: 8px;
            position: relative;
        }
        
        .jahbulonn-btn {
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
        
        .jahbulonn-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(155, 89, 182, 0.4);
        }
        
        .jahbulonn-btn-large {
            font-size: 16px;
            padding: 15px 35px;
        }
        
        .jahbulonn-highlight-card {
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
        
        .jahbulonn-highlight-card .jahbulonn-card-title {
            color: var(--primary);
            font-size: 28px;
            margin-bottom: 25px;
        }
        
        .jahbulonn-highlight-card .jahbulonn-card-content {
            margin-bottom: 30px;
            font-size: 16px;
            max-width: 700px;
            color: var(--text);
        }
        
        .jahbulonn-stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .jahbulonn-stat-card {
            background-color: var(--white);
            border-radius: var(--border-radius);
            padding: 25px;
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
        }
        
        .jahbulonn-stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(155, 89, 182, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
            color: var(--accent);
            font-size: 24px;
        }
        
        .jahbulonn-stat-info {
            flex: 1;
        }
        
        .jahbulonn-stat-value {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary);
            font-family: 'Playfair Display', serif;
        }
        
        .jahbulonn-stat-label {
            font-size: 14px;
            color: var(--text-light);
        }
        
        .jahbulonn-mobile-menu-toggle {
            display: none;
            font-size: 24px;
            color: var(--primary);
            background: none;
            border: none;
            cursor: pointer;
            margin-right: 15px;
        }
        
        .jahbulonn-mobile-menu-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 99;
            display: none;
        }
        
        .jahbulonn-mobile-menu-backdrop.active {
            display: block;
        }
        
        @media (max-width: 992px) {
            .jahbulonn-stats-row {
                grid-template-columns: 1fr 1fr;
            }
        }
        
        @media (max-width: 768px) {
            .jahbulonn-dashboard {
                flex-direction: column;
            }
            
            .jahbulonn-sidebar {
                width: 100%;
                padding: 20px;
                position: fixed;
                top: 0;
                left: -100%;
                height: 100%;
                z-index: 100;
                transition: var(--transition);
            }
            
            .jahbulonn-sidebar.active {
                left: 0;
            }
            
            .jahbulonn-main-content {
                padding: 30px 20px;
                margin-top: 60px;
            }
            
            .jahbulonn-mobile-menu-toggle {
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
            
            .jahbulonn-cards-container {
                grid-template-columns: 1fr;
            }
            
            .jahbulonn-highlight-card {
                grid-column: span 1;
                padding: 30px 20px;
            }
            
            .jahbulonn-stats-row {
                grid-template-columns: 1fr;
            }
            
            .jahbulonn-welcome {
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

    <div class="jahbulonn-dashboard">
        <!-- Mobile Menu Toggle -->
        <button id="jahbulonn-mobile-menu-toggle" class="jahbulonn-mobile-menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Mobile Menu Backdrop -->
        <div id="jahbulonn-mobile-menu-backdrop" class="jahbulonn-mobile-menu-backdrop"></div>
        
        <div id="jahbulonn-sidebar" class="jahbulonn-sidebar">
            <div class="jahbulonn-logo">
                <div class="jahbulonn-logo-icon">
                    <i class="fas fa-crown"></i>
                </div>
                <div class="jahbulonn-logo-text">Elegance</div>
            </div>
            
            <ul class="jahbulonn-menu">
                <li class="jahbulonn-menu-item active">
                    <span class="jahbulonn-menu-icon"><i class="fas fa-home"></i></span>
                    <span>Dashboard</span>
                </li>
                <li class="jahbulonn-menu-item">
                    <span class="jahbulonn-menu-icon"><i class="fas fa-file-alt"></i></span>
                    <span>Forms</span>
                </li>
                <li class="jahbulonn-menu-item">
                    <span class="jahbulonn-menu-icon"><i class="fas fa-chart-pie"></i></span>
                    <span>Reports</span>
                </li>
                <li class="jahbulonn-menu-item">
                    <span class="jahbulonn-menu-icon"><i class="fas fa-calendar-alt"></i></span>
                    <span>Calendar</span>
                </li>
                <li class="jahbulonn-menu-item">
                    <span class="jahbulonn-menu-icon"><i class="fas fa-cog"></i></span>
                    <span>Settings</span>
                </li>
                <li class="jahbulonn-menu-item">
                    <span class="jahbulonn-menu-icon"><i class="fas fa-question-circle"></i></span>
                    <span>Help</span>
                </li>
            </ul>
            
            <div class="jahbulonn-user-profile">
                <div class="jahbulonn-user-avatar"><?php echo substr($user_initials, 0, 2); ?></div>
                <div class="jahbulonn-user-info">
                    <div class="jahbulonn-user-name"><?= htmlspecialchars($_SESSION['user']); ?>!</div>
                    <!-- get user role from database -->
                    <?php
                    $user_role = "user";
                    ?>
                    <div class="jahbulonn-user-role"><?= htmlspecialchars($user_role); ?>!</div>
                </div>
            </div>
        </div>
        
        <div class="jahbulonn-main-content">
            <div class="jahbulonn-header">
                <div class="jahbulonn-welcome">Welcome, <?= htmlspecialchars($_SESSION['user']); ?>! 😊</div>
                <div>
                    <a class="jahbulonn-logout-button" href="http://localhost/wordpress/">Logout</a>
                </div>
            </div>
            
            <div class="jahbulonn-stats-row">
                <div class="jahbulonn-stat-card">
                    <div class="jahbulonn-stat-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="jahbulonn-stat-info">
                        <div class="jahbulonn-stat-value">12</div>
                        <div class="jahbulonn-stat-label">Pending Forms</div>
                    </div>
                </div>
                
                <div class="jahbulonn-stat-card">
                    <div class="jahbulonn-stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="jahbulonn-stat-info">
                        <div class="jahbulonn-stat-value">28</div>
                        <div class="jahbulonn-stat-label">Completed Forms</div>
                    </div>
                </div>
                
                <div class="jahbulonn-stat-card">
                    <div class="jahbulonn-stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="jahbulonn-stat-info">
                        <div class="jahbulonn-stat-value">5</div>
                        <div class="jahbulonn-stat-label">Days Remaining</div>
                    </div>
                </div>
            </div>
            
            <div class="jahbulonn-cards-container">
                <div class="jahbulonn-card">
                    <div class="jahbulonn-card-title">Quick Access</div>
                    <div class="jahbulonn-card-content">
                        Access your frequently used tools and resources with a single click. Streamline your workflow and increase productivity.
                    </div>
                    <form method="post">
                        <button type="submit" name="go_to_form" class="jahbulonn-btn">Go to Form</button>
                    </form>
                </div>
                
                <div class="jahbulonn-card">
                    <div class="jahbulonn-card-title">Recent Activity</div>
                    <div class="jahbulonn-card-content">
                        <ul>
                            <li>Form submission completed on May 14</li>
                            <li>New report generated on May 12</li>
                            <li>Profile settings updated on May 10</li>
                            <li>Document uploaded on May 8</li>
                        </ul>
                    </div>
                </div>
                
                <div class="jahbulonn-card jahbulonn-highlight-card">
                    <div class="jahbulonn-card-title">Begin Your Journey</div>
                    <div class="jahbulonn-card-content">
                        Our intuitive forms make it easy to submit your information quickly and efficiently. Click below to start the submission process and take the first step towards your goals.
                    </div>
                    <form method="post">
                        <a href="http://localhost/wordpress/form/" class="jahbulonn-btn jahbulonn-btn-large">Start Your Application</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle functionality
            const mobileMenuToggle = document.getElementById('jahbulonn-mobile-menu-toggle');
            const sidebar = document.getElementById('jahbulonn-sidebar');
            const backdrop = document.getElementById('jahbulonn-mobile-menu-backdrop');
            
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
            const menuItems = document.querySelectorAll('.jahbulonn-menu-item');
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
            const statValues = document.querySelectorAll('.jahbulonn-stat-value');
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

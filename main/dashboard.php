<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

// Get user info from session
$userId = $_SESSION['user_id'];
$userEmail = $_SESSION['user_email'];
$userName = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Catering Service</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .dashboard-header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            z-index: 1030;
            position: relative;
        }
        .dashboard-content {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            margin-top: 20px;
        }
        .stat-card {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            transition: transform 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .text-white-custom {
            color: white !important;
        }
        .navbar-nav .dropdown-menu {
            z-index: 1031;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        .dropdown-item {
            color: #333 !important;
            transition: all 0.3s ease;
        }
        .dropdown-item:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea !important;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg dashboard-header">
        <div class="container">
            <a class="navbar-brand text-white-custom fw-bold" href="#">
                <i class="fas fa-utensils me-2"></i>Catering Service
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white-custom active" href="#"><i class="fas fa-tachometer-alt me-1"></i>Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white-custom" href="#"><i class="fas fa-shopping-cart me-1"></i>Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white-custom" href="#"><i class="fas fa-utensils me-1"></i>Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white-custom" href="#"><i class="fas fa-user me-1"></i>Profile</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white-custom" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i><?php echo htmlspecialchars($userName); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#" id="logoutBtn"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Welcome Section -->
        <div class="row">
            <div class="col-12">
                <div class="dashboard-content p-4 text-white-custom">
                    <h1 class="mb-3">
                        <i class="fas fa-home me-2"></i>Welcome back, <?php echo htmlspecialchars(explode(' ', $userName)[0]); ?>!
                    </h1>
                    <p class="lead mb-0">Manage your catering orders and explore our delicious menu options.</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row mt-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card p-4 text-white-custom text-center">
                    <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                    <h4>0</h4>
                    <p class="mb-0">Active Orders</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card p-4 text-white-custom text-center">
                    <i class="fas fa-history fa-3x mb-3"></i>
                    <h4>0</h4>
                    <p class="mb-0">Order History</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card p-4 text-white-custom text-center">
                    <i class="fas fa-heart fa-3x mb-3"></i>
                    <h4>0</h4>
                    <p class="mb-0">Favorites</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card p-4 text-white-custom text-center">
                    <i class="fas fa-star fa-3x mb-3"></i>
                    <h4>0</h4>
                    <p class="mb-0">Reviews</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mt-4">
            <div class="col-md-6 mb-4">
                <div class="dashboard-content p-4 text-white-custom">
                    <h4><i class="fas fa-plus-circle me-2"></i>Quick Actions</h4>
                    <div class="d-grid gap-2 mt-3">
                        <button class="btn btn-light btn-lg">
                            <i class="fas fa-shopping-cart me-2"></i>Browse Menu
                        </button>
                        <button class="btn btn-outline-light btn-lg">
                            <i class="fas fa-clock me-2"></i>View Order History
                        </button>
                        <button class="btn btn-outline-light btn-lg">
                            <i class="fas fa-user-edit me-2"></i>Update Profile
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="dashboard-content p-4 text-white-custom">
                    <h4><i class="fas fa-bullhorn me-2"></i>Latest Updates</h4>
                    <div class="mt-3">
                        <div class="border-bottom border-light pb-2 mb-3">
                            <h6><i class="fas fa-utensils me-2"></i>New Menu Items Added</h6>
                            <small class="opacity-75">Check out our fresh seasonal dishes!</small>
                        </div>
                        <div class="border-bottom border-light pb-2 mb-3">
                            <h6><i class="fas fa-truck me-2"></i>Free Delivery This Week</h6>
                            <small class="opacity-75">Orders over $50 qualify for free delivery.</small>
                        </div>
                        <div>
                            <h6><i class="fas fa-percent me-2"></i>Special Discounts</h6>
                            <small class="opacity-75">Save 15% on weekend catering packages.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.all.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Logout functionality
            $('#logoutBtn').on('click', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You will be logged out of your account.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#667eea',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, logout',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading
                        Swal.fire({
                            title: 'Logging out...',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            showConfirmButton: false,
                            willOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        // Call logout API
                        $.ajax({
                            url: '../api/login.php',
                            type: 'POST',
                            data: { action: 'logout' },
                            dataType: 'json',
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Logged Out',
                                    text: response.message,
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = '../index.php';
                                });
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Failed to logout. Please try again.',
                                    confirmButtonColor: '#667eea'
                                });
                            }
                        });
                    }
                });
            });

            // Welcome animation
            $('.dashboard-content, .stat-card').addClass('animate__animated animate__fadeInUp');
        });
    </script>
</body>
</html>

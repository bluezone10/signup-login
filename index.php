<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Catering Service</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.1/dist/sweetalert2.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            overflow-x: hidden;
        }
    </style>
</head>
<body>
    <div class="container-fluid vh-100">
        <div class="row h-100">
            <!-- Left side - Image/Branding -->
            <div class="col-lg-6 d-none d-lg-block p-0">
                <div class="signup-image-section h-100 d-flex align-items-center justify-content-center">
                    <div class="text-center text-white">
                        <i class="fas fa-utensils fa-5x mb-4"></i>
                        <h2 class="mb-3">Welcome Back!</h2>
                        <p class="lead">Sign in to access your catering account</p>
                    </div>
                </div>
            </div>
            
            <!-- Right side - Login Form -->
            <div class="col-lg-6 d-flex align-items-center">
                <div class="w-100 px-4 px-lg-5">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="text-center mb-5">
                                <h1 class="h3 mb-3 font-weight-normal">Sign In</h1>
                                <p class="text-muted">Please enter your credentials to continue</p>
                            </div>

                            <!-- Login Form -->
                            <form id="loginForm" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label for="email" class="form-label">
                                        <i class="fas fa-envelope me-2"></i>Email Address
                                    </label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid email address.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-2"></i>Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback">
                                        Password is required.
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">
                                                Remember me
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <a href="forgot-password" class="text-decoration-none">
                                            Forgot password?
                                        </a>
                                    </div>
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg" id="loginBtn">
                                        <span class="btn-text">
                                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                        </span>
                                        <span class="btn-loading d-none">
                                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                            Signing In...
                                        </span>
                                    </button>
                                </div>

                                <div class="text-center">
                                    <p class="mb-0">Don't have an account? 
                                        <a href="signup" class="text-decoration-none">Create one here</a>
                                    </p>
                                </div>
                            </form>
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
    <!-- Custom JS -->
    <script src="assets/js/login.js"></script>
</body>
</html> 
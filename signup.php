<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Catering Service</title>
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
                        <h2 class="mb-3">Welcome to Our Catering Service</h2>
                        <p class="lead">Join us and experience the finest culinary delights</p>
                    </div>
                </div>
            </div>
            
            <!-- Right side - Signup Form -->
            <div class="col-lg-6 d-flex align-items-center">
                <div class="w-100 px-4 px-lg-5">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="text-center mb-5">
                                <h1 class="h3 mb-3 font-weight-normal">Create Account</h1>
                                <p class="text-muted">Please fill in the details to create your account</p>
                            </div>

                            <!-- Alert container for messages -->
                            <div id="alertContainer"></div>

                            <!-- Signup Form -->
                            <form id="signupForm" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstName" class="form-label">
                                            <i class="fas fa-user me-2"></i>First Name
                                        </label>
                                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                                        <div class="invalid-feedback">
                                            Please provide a valid first name.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastName" class="form-label">
                                            <i class="fas fa-user me-2"></i>Last Name
                                        </label>
                                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                                        <div class="invalid-feedback">
                                            Please provide a valid last name.
                                        </div>
                                    </div>
                                </div>

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
                                    <label for="phone" class="form-label">
                                        <i class="fas fa-phone me-2"></i>Phone Number
                                    </label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid phone number.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        <i class="fas fa-lock me-2"></i>Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" required minlength="8">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback">
                                        Password must be at least 8 characters long.
                                    </div>
                                    <div class="form-text">
                                        Password must be at least 8 characters long and contain letters and numbers.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">
                                        <i class="fas fa-lock me-2"></i>Confirm Password
                                    </label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                    <div class="invalid-feedback">
                                        Passwords do not match.
                                    </div>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="termsCheck" required>
                                    <label class="form-check-label" for="termsCheck">
                                        I agree to the <a href="#" class="text-decoration-none">Terms and Conditions</a>
                                    </label>
                                    <div class="invalid-feedback">
                                        You must agree to the terms and conditions.
                                    </div>
                                </div>

                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-primary btn-lg" id="signupBtn">
                                        <span class="btn-text">
                                            <i class="fas fa-user-plus me-2"></i>Create Account
                                        </span>
                                        <span class="btn-loading d-none">
                                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                            Creating Account...
                                        </span>
                                    </button>
                                </div>

                                <div class="text-center">
                                    <p class="mb-0">Already have an account? 
                                        <a href="index.php" class="text-decoration-none">Sign in here</a>
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
    <script src="assets/js/script.js"></script>
</body>
</html>


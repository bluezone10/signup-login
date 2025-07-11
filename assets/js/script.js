$(document).ready(function() {
    // Password toggle functionality
    $('#togglePassword').click(function() {
        const passwordField = $('#password');
        const icon = $(this).find('i');
        
        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Real-time password confirmation validation
    $('#confirmPassword').on('input', function() {
        const password = $('#password').val();
        const confirmPassword = $(this).val();
        
        if (confirmPassword !== '' && password !== confirmPassword) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Email validation
    $('#email').on('blur', function() {
        const email = $(this).val();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email !== '' && !emailRegex.test(email)) {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });

    // Phone number formatting and validation
    $('#phone').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length >= 6) {
            value = value.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
        } else if (value.length >= 3) {
            value = value.replace(/(\d{3})(\d{0,3})/, '($1) $2');
        }
        $(this).val(value);
    });

    // Form submission with AJAX
    $('#signupForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate form
        if (!this.checkValidity()) {
            e.stopPropagation();
            $(this).addClass('was-validated');
            return;
        }

        // Additional password confirmation check
        const password = $('#password').val();
        const confirmPassword = $('#confirmPassword').val();
        
        if (password !== confirmPassword) {
            Swal.fire({
                icon: 'warning',
                title: 'Password Mismatch',
                text: 'Passwords do not match! Please check and try again.',
                confirmButtonColor: '#667eea'
            });
            $('#confirmPassword').addClass('is-invalid');
            return;
        }

        // Show loading state
        const submitBtn = $('#signupBtn');
        const btnText = submitBtn.find('.btn-text');
        const btnLoading = submitBtn.find('.btn-loading');
        
        btnText.addClass('d-none');
        btnLoading.removeClass('d-none');
        submitBtn.prop('disabled', true);

        // Prepare form data
        const formData = {
            firstName: $('#firstName').val(),
            lastName: $('#lastName').val(),
            email: $('#email').val(),
            phone: $('#phone').val(),
            password: password,
            action: 'signup'
        };

        // AJAX request
        $.ajax({
            url: 'api/signup.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            timeout: 10000,
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Account Created!',
                        text: response.message,
                        confirmButtonColor: '#667eea',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    }).then(() => {
                        // Reset form and redirect
                        $('#signupForm')[0].reset();
                        $('#signupForm').removeClass('was-validated');
                        window.location.href = response.data.redirect || 'index.php';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Signup Failed',
                        text: response.message,
                        confirmButtonColor: '#667eea'
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                let errorMessage = 'An error occurred. Please try again.';
                
                if (status === 'timeout') {
                    errorMessage = 'Request timed out. Please check your connection.';
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Connection Error',
                    text: errorMessage,
                    confirmButtonColor: '#667eea'
                });
            },
            complete: function() {
                // Reset button state
                btnText.removeClass('d-none');
                btnLoading.addClass('d-none');
                submitBtn.prop('disabled', false);
            }
        });
    });

    // Function to show SweetAlert messages
    function showAlert(message, type) {
        const config = {
            text: message,
            confirmButtonColor: '#667eea',
            customClass: {
                popup: 'fade-in'
            }
        };

        if (type === 'success') {
            config.icon = 'success';
            config.title = 'Success!';
            config.timer = 3000;
            config.timerProgressBar = true;
            config.showConfirmButton = false;
        } else {
            config.icon = 'error';
            config.title = 'Error';
        }

        Swal.fire(config);
    }

    // Add smooth scrolling for better UX
    $('html').css('scroll-behavior', 'smooth');

    // Add input focus effects
    $('.form-control').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });

    // Check if email already exists (debounced)
    let emailCheckTimeout;
    $('#email').on('input', function() {
        const email = $(this).val();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        clearTimeout(emailCheckTimeout);
        
        if (email && emailRegex.test(email)) {
            emailCheckTimeout = setTimeout(function() {
                checkEmailExists(email);
            }, 1000);
        }
    });

    function checkEmailExists(email) {
        $.ajax({
            url: 'api/signup.php',
            type: 'POST',
            data: {
                action: 'check_email',
                email: email
            },
            dataType: 'json',
            success: function(response) {
                if (response.exists) {
                    $('#email').addClass('is-invalid');
                    $('#email').siblings('.invalid-feedback').text('This email is already registered.');
                } else {
                    $('#email').removeClass('is-invalid');
                    $('#email').siblings('.invalid-feedback').text('Please provide a valid email address.');
                }
            }
        });
    }
}); 
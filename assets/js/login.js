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

    // Form submission with AJAX and SweetAlert
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        
        // Validate form
        if (!this.checkValidity()) {
            e.stopPropagation();
            $(this).addClass('was-validated');
            
            Swal.fire({
                icon: 'warning',
                title: 'Validation Error',
                text: 'Please fill in all required fields correctly.',
                confirmButtonColor: '#667eea'
            });
            return;
        }

        // Show loading state
        const submitBtn = $('#loginBtn');
        const btnText = submitBtn.find('.btn-text');
        const btnLoading = submitBtn.find('.btn-loading');
        
        btnText.addClass('d-none');
        btnLoading.removeClass('d-none');
        submitBtn.prop('disabled', true);

        // Prepare form data
        const formData = {
            email: $('#email').val(),
            password: $('#password').val(),
            rememberMe: $('#rememberMe').is(':checked'),
            action: 'login'
        };

        // AJAX request
        $.ajax({
            url: 'api/login.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            timeout: 10000,
            success: function(response) {
                if (response.success) {
                    // Success with SweetAlert
                    Swal.fire({
                        icon: 'success',
                        title: 'Welcome Back!',
                        text: response.message,
                        confirmButtonColor: '#667eea',
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    }).then(() => {
                        // Redirect after SweetAlert closes
                        window.location.href = response.data.redirect || 'main/dashboard.php';
                    });
                } else {
                    // Error with SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
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

    // Add smooth scrolling for better UX
    $('html').css('scroll-behavior', 'smooth');

    // Add input focus effects
    $('.form-control').on('focus', function() {
        $(this).parent().addClass('focused');
    }).on('blur', function() {
        $(this).parent().removeClass('focused');
    });



    // Auto-focus email field on page load
    setTimeout(function() {
        $('#email').focus();
    }, 500);
}); 
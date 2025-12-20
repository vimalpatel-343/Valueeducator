 $(document).ready(function() {
    // Show/hide modal content
    function showContent(contentId) {
        $('.hide-content').hide();
        $('#' + contentId).show();
    }
    
    // Show loader
    function showLoader() {
        $('.loader-overlay').show();
    }
    
    // Hide loader
    function hideLoader() {
        $('.loader-overlay').hide();
    }
    
    // Show error message
    function showError(elementId, message) {
        $('#' + elementId).html(message).show();
    }
    
    // Hide error message
    function hideError(elementId) {
        $('#' + elementId).html('').hide();
    }
    
    // Initialize modal - show login form by default
    $('#search-modal').on('show.bs.modal', function() {
        showContent('new-content-6'); // Show login form by default
        // Reset all forms
        resetAllForms();
    });
    
    // Reset all forms
    function resetAllForms() {
        // Clear all input fields
        $('input[type="text"], input[type="tel"], input[type="email"]').val('');
        $('input[type="file"]').val('');
        
        // Clear error messages
        $('.group[id*="error"]').html('').hide();
        
        // Reset OTP fields
        $('.signup-otp, .login-otp').val('');
        
        // Reset profile picture preview
        $('.picture__image').css('background-image', '');
        
        // Disable confirm buttons
        $('.confirm-signup-otp-btn, .confirm-login-otp-btn, .save-profile-btn').prop('disabled', true);
    }
    
    // Switch to signup form
    $(document).on('click', '.signup-link', function(e) {
        e.preventDefault();
        showContent('new-content');
    });
    
    // Switch to login form
    $(document).on('click', '.login-link', function(e) {
        e.preventDefault();
        showContent('new-content-6');
    });
    
    // Send signup OTP
    $(document).on('click', '.signup-btn', function(e) {
        e.preventDefault();
        const button = $(this);
        const email = $('#signup_email').val();
        
        if (!email) {
            showError('error-message-signup', 'Please enter your email address');
            return;
        }
        
        hideError('error-message-signup');
        showLoader();
        
        $.ajax({
            url: base_url + 'auth/send-signup-otp',
            type: 'POST',
            data: { email: email },
            dataType: 'json',
            success: function(response) {
                hideLoader();
                
                if (response.success) {
                    showContent('new-content-3');
                } else {
                    showError('error-message-signup', response.message);
                }
            },
            error: function() {
                hideLoader();
                showError('error-message-signup', 'An error occurred. Please try again.');
            }
        });
    });
    
    // Verify signup OTP
    $(document).on('click', '.confirm-signup-otp-btn', function(e) {
        e.preventDefault();
        const button = $(this);
        
        // Get OTP from all inputs
        let otp = '';
        $('.signup-otp').each(function() {
            otp += $(this).val();
        });
        
        if (otp.length !== 6) {
            showError('error-otp-message-signup', 'Please enter the complete OTP');
            return;
        }
        
        hideError('error-otp-message-signup');
        showLoader();
        
        $.ajax({
            url: base_url + 'auth/verify-signup-otp',
            type: 'POST',
            data: { otp: otp },
            dataType: 'json',
            success: function(response) {
                hideLoader();
                
                if (response.success) {
                    showContent('new-content-4');
                } else {
                    showError('error-otp-message-signup', response.message);
                }
            },
            error: function() {
                hideLoader();
                showError('error-otp-message-signup', 'An error occurred. Please try again.');
            }
        });
    });
    
    // Resend signup OTP
    $(document).on('click', '.resend-signup-otp', function(e) {
        e.preventDefault();
        const button = $(this);
        const email = $('#signup_email').val();
        
        if (!email) {
            showError('error-message-signup', 'Please enter your email address');
            return;
        }
        
        hideError('error-message-signup');
        showLoader();
        
        $.ajax({
            url: base_url + 'auth/send-signup-otp',
            type: 'POST',
            data: { email: email },
            dataType: 'json',
            success: function(response) {
                hideLoader();
                
                if (response.success) {
                    showError('error-otp-message-signup', 'OTP has been resent to your email');
                } else {
                    showError('error-otp-message-signup', response.message);
                }
            },
            error: function() {
                hideLoader();
                showError('error-otp-message-signup', 'An error occurred. Please try again.');
            }
        });
    });
    
    // Save user profile
    $(document).on('click', '.save-profile-btn', function(e) {
        e.preventDefault();
        const button = $(this);
        const firstName = $('#user_f_name').val();
        const lastName = $('#user_l_name').val();
        const mobile = $('#user_mobile').val();
        
        if (!firstName || !lastName || !mobile) {
            showError('error-insert', 'All fields are required');
            return;
        }
        
        hideError('error-insert');
        showLoader();
        
        $.ajax({
            url: base_url + 'auth/save-profile',
            type: 'POST',
            data: { 
                first_name: firstName,
                last_name: lastName,
                mobile: mobile
            },
            dataType: 'json',
            success: function(response) {
                hideLoader();
                
                if (response.success) {
                    showContent('new-content-5');
                } else {
                    showError('error-insert', response.message);
                }
            },
            error: function() {
                hideLoader();
                showError('error-insert', 'An error occurred. Please try again.');
            }
        });
    });
    
    // Upload profile picture
    $(document).on('click', '.upload-profile-btn', function(e) {
        e.preventDefault();
        const button = $(this);
        const fileInput = $('#picture__input')[0];
        
        if (fileInput.files.length === 0) {
            showError('error-image', 'Please select a profile picture');
            return;
        }
        
        // Check file size (max 5MB)
        const maxSize = 5 * 1024 * 1024; // 5MB in bytes
        if (fileInput.files[0].size > maxSize) {
            showError('error-image', 'File size must be less than 5MB');
            return;
        }
        
        // Check file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(fileInput.files[0].type)) {
            showError('error-image', 'Only JPEG, PNG, and GIF images are allowed');
            return;
        }
        
        hideError('error-image');
        showLoader();
        
        const formData = new FormData();
        formData.append('profile_picture', fileInput.files[0]);
        
        $.ajax({
            url: base_url + 'auth/upload-profile-picture',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                hideLoader();
                
                if (response.success) {
                    showContent('new-content-99');
                } else {
                    showError('error-image', response.message);
                }
            },
            error: function(xhr, status, error) {
                hideLoader();
                let errorMessage = 'An error occurred. Please try again.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                showError('error-image', errorMessage);
            }
        });
    });
    
    // Skip profile picture upload
    $(document).on('click', '.skip-image-btn', function(e) {
        e.preventDefault();
        showContent('new-content-99');
    });
    
    // Complete signup (skip ebook download)
    $(document).on('click', '.skip-download-btn', function(e) {
        e.preventDefault();
        const button = $(this);
        showLoader();
        
        $.ajax({
            url: base_url + 'auth/complete-signup',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                hideLoader();
                
                if (response.success) {
                    window.location.href = response.redirect;
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                hideLoader();
                alert('An error occurred. Please try again.');
            }
        });
    });
    
    // Download ebook
    $(document).on('click', '.download-ebook-btn', function(e) {
        e.preventDefault();
        const button = $(this);
        showLoader();
        
        $.ajax({
            url: base_url + 'auth/complete-signup',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                hideLoader();
                
                if (response.success) {
                    // Redirect to ebook download
                    window.location.href = base_url + 'download-ebook';
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                hideLoader();
                alert('An error occurred. Please try again.');
            }
        });
    });
    
    // Send login OTP
    $(document).on('click', '.login-btn', function(e) {
        e.preventDefault();
        const button = $(this);
        const email = $('#email').val();
        
        if (!email) {
            showError('error-message', 'Please enter your email address');
            return;
        }
        
        hideError('error-message');
        showLoader();
        
        $.ajax({
            url: base_url + 'auth/send-login-otp',
            type: 'POST',
            data: { email: email },
            dataType: 'json',
            success: function(response) {
                hideLoader();
                
                if (response.success) {
                    showContent('new-content-7');
                } else {
                    showError('error-message', response.message);
                }
            },
            error: function() {
                hideLoader();
                showError('error-message', 'An error occurred. Please try again.');
            }
        });
    });
    
    // Verify login OTP
    $(document).on('click', '.confirm-login-otp-btn', function(e) {
        e.preventDefault();
        const button = $(this);
        
        // Get OTP from all inputs
        let otp = '';
        $('.login-otp').each(function() {
            otp += $(this).val();
        });
        
        if (otp.length !== 6) {
            showError('error-otp-message', 'Please enter the complete OTP');
            return;
        }
        
        hideError('error-otp-message');
        showLoader();
        
        $.ajax({
            url: base_url + 'auth/verify-login-otp',
            type: 'POST',
            data: { otp: otp },
            dataType: 'json',
            success: function(response) {
                hideLoader();
                
                if (response.success) {
                    window.location.href = response.redirect;
                } else {
                    showError('error-otp-message', response.message);
                }
            },
            error: function() {
                hideLoader();
                showError('error-otp-message', 'An error occurred. Please try again.');
            }
        });
    });
    
    // Resend login OTP
    $(document).on('click', '.resend-login-otp', function(e) {
        e.preventDefault();
        const button = $(this);
        const email = $('#email').val();
        
        if (!email) {
            showError('error-message', 'Please enter your email address');
            return;
        }
        
        hideError('error-message');
        showLoader();
        
        $.ajax({
            url: base_url + 'auth/send-login-otp',
            type: 'POST',
            data: { email: email },
            dataType: 'json',
            success: function(response) {
                hideLoader();
                
                if (response.success) {
                    showError('error-otp-message', 'OTP has been resent to your email');
                } else {
                    showError('error-otp-message', response.message);
                }
            },
            error: function() {
                hideLoader();
                showError('error-otp-message', 'An error occurred. Please try again.');
            }
        });
    });
    
    // Handle OTP input auto-focus
    $('.signup-otp, .login-otp').on('keyup', function() {
        if (this.value.length === this.maxLength) {
            const $next = $(this).data('next');
            if ($next) {
                $('#' + $next).focus();
            }
        }
    });
    
    // Handle OTP input backspace
    $('.signup-otp, .login-otp').on('keydown', function(e) {
        if (e.key === 'Backspace' && this.value.length === 0) {
            const $prev = $(this).data('previous');
            if ($prev) {
                $('#' + $prev).focus();
            }
        }
    });
    
    // Enable/disable confirm OTP button based on input
    $('.signup-otp').on('input', function() {
        let allFilled = true;
        $('.signup-otp').each(function() {
            if ($(this).val().length !== 1) {
                allFilled = false;
            }
        });
        
        $('.confirm-signup-otp-btn').prop('disabled', !allFilled);
    });
    
    $('.login-otp').on('input', function() {
        let allFilled = true;
        $('.login-otp').each(function() {
            if ($(this).val().length !== 1) {
                allFilled = false;
            }
        });
        
        $('.confirm-login-otp-btn').prop('disabled', !allFilled);
    });
    
    // Enable/disable save profile button based on input
    $('#user_f_name, #user_l_name, #user_mobile').on('input', function() {
        const firstName = $('#user_f_name').val();
        const lastName = $('#user_l_name').val();
        const mobile = $('#user_mobile').val();
        
        $('.save-profile-btn').prop('disabled', !(firstName && lastName && mobile));
    });
    
    // Handle profile picture preview
    $('#picture__input').on('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                $('.picture__image').css('background-image', 'url(' + event.target.result + ')');
            };
            reader.readAsDataURL(file);
        }
    });
});
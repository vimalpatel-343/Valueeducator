/* auth-modal.js (complete rewrite)
   Requires: jQuery, Bootstrap 5
   Ensure `base_url` is available globally (same as your original code)
*/
 $(function () {
    // --- Global AJAX Setup for Session Handling ---
    $.ajaxSetup({
        xhrFields: {
            withCredentials: true
        },
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    // --- Cache DOM elements (get by ID) ---
    const $authModalEl = $('#authModal');
    const authForms = {
        loginForm: document.getElementById('loginForm'),
        loginOtpForm: document.getElementById('loginOtpForm'),
        signupForm: document.getElementById('signupForm'),
        signupOtpForm: document.getElementById('signupOtpForm'),
        profileForm: document.getElementById('profileForm'),
        profilePictureForm: document.getElementById('profilePictureForm'),
        welcomeForm: document.getElementById('welcomeForm')
    };

    // jQuery-wrapped elements used frequently
    const $loginFormElement = $('#loginFormElement');
    const $loginOtpFormElement = $('#loginOtpFormElement');
    const $signupFormElement = $('#signupFormElement');
    const $signupOtpFormElement = $('#signupOtpFormElement');
    const $profileFormElement = $('#profileFormElement');

    const $sendLoginOtpBtn = $('#sendLoginOtpBtn');
    const $verifyLoginOtpBtn = $('#verifyLoginOtpBtn');
    const $sendSignupOtpBtn = $('#sendSignupOtpBtn');
    const $verifySignupOtpBtn = $('#verifySignupOtpBtn');
    const $saveProfileBtn = $('#saveProfileBtn');
    const $uploadProfileBtn = $('#uploadProfileBtn');
    const $downloadEbookBtn = $('#downloadEbookBtn');

    const $loginEmail = $('#loginEmail');
    const $signupEmail = $('#signupEmail');
    const $firstName = $('#firstName');
    const $lastName = $('#lastName');
    const $phoneNumber = $('#phoneNumber');
    const $countryCode = $('#countryCode');
    const $profilePictureInput = $('#profilePictureInput');

    const $loginEmailError = $('#loginEmailError');
    const $loginOtpError = $('#loginOtpError');
    const $signupEmailError = $('#signupEmailError');
    const $signupOtpError = $('#signupOtpError');
    const $firstNameError = $('#firstNameError');
    const $lastNameError = $('#lastNameError');
    const $phoneNumberError = $('#phoneNumberError');
    const $profilePictureError = $('#profilePictureError');

    const $loginOtpSuccess = $('#loginOtpSuccess');
    const $signupOtpSuccess = $('#signupOtpSuccess');

    const $authLoader = $('.auth-loader');

    // Store the signup token globally
    let signupToken = null;
    let openForm = 'signup';
    let loginOtpTimer = null;
    let signupOtpTimer = null;

    // Phone patterns & examples (kept from your original)
    const phonePatterns = {
        '+1': /^\d{10}$/, '+44': /^\d{10}$/, '+91': /^\d{10}$/, '+61': /^\d{9}$/,
        '+86': /^\d{11}$/, '+81': /^\d{10}$/, '+49': /^\d{10,11}$/, '+33': /^\d{9}$/,
        '+7': /^\d{10}$/, '+82': /^\d{9,10}$/, '+39': /^\d{9,10}$/, '+34': /^\d{9}$/,
        '+31': /^\d{9}$/, '+41': /^\d{9}$/, '+43': /^\d{10}$/, '+45': /^\d{8}$/,
        '+46': /^\d{7,9}$/, '+47': /^\d{8}$/, '+358': /^\d{9}$/, '+351': /^\d{9}$/,
        '+353': /^\d{9}$/, '+352': /^\d{8,9}$/, '+32': /^\d{9}$/
    };

    const phoneExamples = {
        '+1': 'e.g., 1234567890', '+44': 'e.g., 7912345678', '+91': 'e.g., 9876543210',
        '+61': 'e.g., 412345678', '+86': 'e.g., 13812345678', '+81': 'e.g., 9012345678',
        '+49': 'e.g., 1512345678', '+33': 'e.g., 612345678', '+7': 'e.g., 9123456789',
        '+82': 'e.g., 101234567', '+39': 'e.g., 3123456789', '+34': 'e.g., 612345678',
        '+31': 'e.g., 612345678', '+41': 'e.g., 791234567', '+43': 'e.g., 6641234567',
        '+45': 'e.g., 12345678', '+46': 'e.g., 701234567', '+47': 'e.g., 41234567',
        '+358': 'e.g., 412345678', '+351': 'e.g., 912345678', '+353': 'e.g., 851234567',
        '+352': 'e.g., 621123456', '+32': 'e.g., 471234567'
    };

    // --- Helpers ---
    function safeEl(el) { return el && el !== null; }

    function resetAllForms() {
        // Clear inputs
        $('input[type="email"], input[type="text"], input[type="tel"]').val('');
        $('input[type="file"]').val('');
        // Hide error/success
        $('.invalid-feedback').text('').hide();
        $('.text-success').text('').hide();
        // Reset OTPs
        $('.otp-input').val('');
        // Profile picture preview
        $('.profile-picture-preview').html('<div class="profile-picture-placeholder"><i class="bi bi-person-circle"></i></div>');
        // Buttons
        $('.btn-primary').prop('disabled', false);
        $('.btn-primary .spinner-border').addClass('d-none');
        $('.btn-primary .btn-text').show();
        // Reset token
        signupToken = null;
    }

    function showFormById(formId) 
    {
        // Hide all known forms
        Object.values(authForms).forEach(el => { if (el) el.classList.add('d-none'); });
        
        // Show requested
        const el = authForms[formId];
        if (el) el.classList.remove('d-none');
        
        // If showing OTP forms, start countdown for resend links
        if (formId === 'loginOtpForm') {
            const $resendLink = $('#loginOtpForm').find('.resend-otp-link');
            if ($resendLink.length && !$resendLink.hasClass('disabled')) {
                startOtpCountdown($resendLink, 60, 'login');
            }
        } else if (formId === 'signupOtpForm') {
            const $resendLink = $('#signupOtpForm').find('.resend-otp-link');
            if ($resendLink.length && !$resendLink.hasClass('disabled')) {
                startOtpCountdown($resendLink, 60, 'signup');
            }
        }
    }

    function showLoader() { $authLoader.removeClass('d-none').addClass('d-flex'); }
    function hideLoader() { $authLoader.removeClass('d-flex').addClass('d-none'); }

    function showButtonLoading($btn) {
        if (!$btn || !$btn.length) return;
        $btn.prop('disabled', true);
        $btn.find('.btn-text').hide();
        $btn.find('.spinner-border').removeClass('d-none');
    }
    function hideButtonLoading($btn) {
        if (!$btn || !$btn.length) return;
        $btn.prop('disabled', false);
        $btn.find('.btn-text').show();
        $btn.find('.spinner-border').addClass('d-none');
    }

    function showError($el, msg) {
        if (!$el || !$el.length) return;
        $el.text(msg).show();
        // mark nearest input invalid
        const $formControl = $el.closest('.mb-3, .mt-3').find('.form-control');
        $formControl.addClass('is-invalid');
    }
    function hideError($el) {
        if (!$el || !$el.length) return;
        $el.text('').hide();
        $el.closest('.mb-3, .mt-3').find('.form-control').removeClass('is-invalid');
    }

    function showSuccess($el, msg) {
        if (!$el || !$el.length) return;
        $el.text(msg).removeClass('d-none').show();
    }
    function hideSuccess($el) {
        if (!$el || !$el.length) return;
        $el.text('').addClass('d-none').hide();
    }

    function isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }

    // --- Modal events ---
    $authModalEl.on('show.bs.modal', function () {
        resetAllForms();

        if (openForm !== 'login') {
            showFormById('loginForm');
        } else {
            showFormById('signupForm');
        }
    });

    // --- Switch link handler (data-target contains ID like "signupForm") ---
    $(document).on('click', '.auth-switch-link', function (e) {
        e.preventDefault();
        const target = $(this).data('target');
        if (!target) return;
        showFormById(target);
    });

    $('.auth-trigger').on('click', function () {
        openForm = $(this).data('form');
    });

    // --- LOGIN form submit (send OTP) ---
    $loginFormElement.on('submit', function (e) {
        e.preventDefault();
        const email = $loginEmail.val().trim();
        if (!email) {
            showError($loginEmailError, 'Please enter your email address');
            return;
        }
        if (!isValidEmail(email)) {
            showError($loginEmailError, 'Please enter a valid email address');
            return;
        }
        hideError($loginEmailError);
        showButtonLoading($sendLoginOtpBtn);

        $.ajax({
            url: base_url + 'auth/send-login-otp',
            type: 'POST',
            data: { email },
            dataType: 'json',
            xhrFields: {
                withCredentials: true
            }
        }).done(function (res) {
            hideButtonLoading($sendLoginOtpBtn);
            if (res && res.success) {
                showFormById('loginOtpForm');
                $('#loginOtpForm .otp-input:first').focus();
            } else {
                // Show error message in the UI (not alert)
                if (res && res.rate_limit_exceeded) {
                    // Show rate limit error in a more prominent way
                    showError($loginEmailError, res.message);
                    $loginEmailError.addClass('rate-limit-error');
                } else if (res && res.message) {
                    showError($loginEmailError, res.message);
                } else {
                    showError($loginEmailError, 'Could not send OTP.');
                }
            }
        }).fail(function () {
            hideButtonLoading($sendLoginOtpBtn);
            showError($loginEmailError, 'An error occurred. Please try again.');
        });
    });

    // --- SIGNUP form submit (send OTP) ---
    $signupFormElement.on('submit', function (e) {
        e.preventDefault();
        const email = $signupEmail.val().trim();
        if (!email) {
            showError($signupEmailError, 'Please enter your email address');
            return;
        }
        if (!isValidEmail(email)) {
            showError($signupEmailError, 'Please enter a valid email address');
            return;
        }
        hideError($signupEmailError);
        showButtonLoading($sendSignupOtpBtn);

        $.ajax({
            url: base_url + 'auth/send-signup-otp',
            type: 'POST',
            data: { email },
            dataType: 'json',
            xhrFields: {
                withCredentials: true
            }
        }).done(function (res) {
            hideButtonLoading($sendSignupOtpBtn);
            if (res && res.success) {
                showFormById('signupOtpForm');
                $('#signupOtpForm .otp-input:first').focus();
            } else {
                // Show error message in the UI (not alert)
                if (res && res.rate_limit_exceeded) {
                    // Show rate limit error in a more prominent way
                    showError($signupEmailError, res.message);
                    $signupEmailError.addClass('rate-limit-error');
                } else if (res && res.message) {
                    showError($signupEmailError, res.message);
                } else {
                    showError($signupEmailError, 'Could not send OTP.');
                }
            }
        }).fail(function () {
            hideButtonLoading($sendSignupOtpBtn);
            showError($signupEmailError, 'An error occurred. Please try again.');
        });
    });

    // --- OTP behavior (input, paste, backspace) ---
    function gatherOtp($form) {
        let val = '';
        $form.find('.otp-input').each(function () { val += $(this).val(); });
        return val;
    }

    $(document).on('input', '.otp-input', function (e) {
        const $input = $(this);
        const $form = $input.closest('form');
        const $inputs = $form.find('.otp-input');
        const index = parseInt($input.data('index'), 10);

        // If pasted full OTP (multiple chars), distribute
        const v = $input.val();
        if (v.length > 1) {
            // distribute characters starting from current index
            let chars = v.split('');
            for (let i = 0; i < chars.length && (index + i) < $inputs.length; i++) {
                $inputs.eq(index + i).val(chars[i]);
            }
            // set caret to next after pasted chunk
            const nextIndex = Math.min(index + chars.length, $inputs.length - 1);
            $inputs.eq(nextIndex).focus();
        } else {
            // normal single char input -> move forward
            if (v.length === 1 && index < $inputs.length - 1) {
                $inputs.eq(index + 1).focus();
            }
        }

        // enable verify button only when all filled
        const otp = gatherOtp($form);
        const formId = $form.attr('id');
        if (otp.length === $inputs.length) {
            if (formId === 'loginOtpFormElement') $verifyLoginOtpBtn.prop('disabled', false);
            else if (formId === 'signupOtpFormElement') $verifySignupOtpBtn.prop('disabled', false);
        } else {
            if (formId === 'loginOtpFormElement') $verifyLoginOtpBtn.prop('disabled', true);
            else if (formId === 'signupOtpFormElement') $verifySignupOtpBtn.prop('disabled', true);
        }
    });

    // Backspace navigation
    $(document).on('keydown', '.otp-input', function (e) {
        const $input = $(this);
        const $form = $input.closest('form');
        const $inputs = $form.find('.otp-input');
        const index = parseInt($input.data('index'), 10);

        if (e.key === 'Backspace') {
            // If current has value, clear it (default). If empty, move to prev.
            if ($input.val() === '' && index > 0) {
                e.preventDefault();
                $inputs.eq(index - 1).focus().val('');
            }
        } else if (e.key === 'ArrowLeft' && index > 0) {
            $inputs.eq(index - 1).focus();
        } else if (e.key === 'ArrowRight' && index < $inputs.length - 1) {
            $inputs.eq(index + 1).focus();
        }
    });

    // --- VERIFY login OTP ---
    $loginOtpFormElement.on('submit', function (e) {
        e.preventDefault();
        const otp = gatherOtp($loginOtpFormElement);
        if (otp.length !== 6) {
            showError($loginOtpError, 'Please enter the complete OTP');
            return;
        }
        hideError($loginOtpError);
        showButtonLoading($verifyLoginOtpBtn);

        $.ajax({
            url: base_url + 'auth/verify-login-otp',
            type: 'POST',
            data: { otp },
            dataType: 'json',
            xhrFields: {
                withCredentials: true
            }
        }).done(function (res) {
            hideButtonLoading($verifyLoginOtpBtn);
            if (res && res.success) {
                // success -> redirect if provided
                if (res.redirect) window.location.href = res.redirect;
                else location.reload();
            } else {
                showError($loginOtpError, (res && res.message) ? res.message : 'Invalid OTP.');
            }
        }).fail(function () {
            hideButtonLoading($verifyLoginOtpBtn);
            showError($loginOtpError, 'An error occurred. Please try again.');
        });
    });

    // --- VERIFY signup OTP ---
    $signupOtpFormElement.on('submit', function (e) {
        e.preventDefault();
        const otp = gatherOtp($signupOtpFormElement);
        if (otp.length !== 6) {
            showError($signupOtpError, 'Please enter the complete OTP');
            return;
        }
        hideError($signupOtpError);
        showButtonLoading($verifySignupOtpBtn);

        $.ajax({
            url: base_url + 'auth/verify-signup-otp',
            type: 'POST',
            data: { otp },
            dataType: 'json',
            xhrFields: {
                withCredentials: true
            }
        }).done(function (res) {
            hideButtonLoading($verifySignupOtpBtn);
            if (res && res.success) {
                showFormById('profileForm');
                if ($firstName && $firstName.length) $firstName.focus();
            } else {
                showError($signupOtpError, (res && res.message) ? res.message : 'Invalid OTP.');
            }
        }).fail(function () {
            hideButtonLoading($verifySignupOtpBtn);
            showError($signupOtpError, 'An error occurred. Please try again.');
        });
    });

    // --- Country code change updates example text & revalidate ---
    $countryCode.on('change', function () {
        const code = $(this).val();
        const example = phoneExamples[code] || '';
        const $formText = $(this).closest('.input-group').siblings('.form-text');
        if ($formText && $formText.length) {
            $formText.text(example ? `Enter your phone number without country code (${example})` : 'Enter your phone number without country code');
        }
        const phone = $phoneNumber.val().trim();
        if (phone) validatePhoneNumber(phone, code);
    });

    // --- Phone input sanitization + validation + profile form check ---
    $phoneNumber.on('input', function () {
        const raw = $(this).val();
        const cleaned = raw.replace(/\D/g, '');
        if (cleaned !== raw) $(this).val(cleaned);
        validatePhoneNumber(cleaned, $countryCode.val());
        checkProfileFormValidity();
    });
    $firstName.add($lastName).on('input', checkProfileFormValidity);

    function validatePhoneNumber(phone, code) {
        const $err = $phoneNumberError;
        if (!phone) {
            hideError($err);
            return false;
        }
        const pattern = phonePatterns[code];
        if (!pattern || !pattern.test(phone)) {
            showError($err, `Please enter a valid phone number for the selected country (${phoneExamples[code] || 'e.g., 1234567890'})`);
            return false;
        }
        hideError($err);
        return true;
    }

    function checkProfileFormValidity() {
        const f = ($firstName.val() || '').trim();
        const l = ($lastName.val() || '').trim();
        const p = ($phoneNumber.val() || '').trim();
        const code = $countryCode.val();
        const allFilled = f && l && p;
        const phoneOK = validatePhoneNumber(p, code);
        $saveProfileBtn.prop('disabled', !(allFilled && phoneOK));
    }

    // --- Profile submit ---
    $profileFormElement.on('submit', function (e) {
        e.preventDefault();
        const f = ($firstName.val() || '').trim();
        const l = ($lastName.val() || '').trim();
        const p = ($phoneNumber.val() || '').trim();
        const code = $countryCode.val();

        if (!f) { showError($firstNameError, 'Please enter your first name'); return; }
        if (!l) { showError($lastNameError, 'Please enter your last name'); return; }
        if (!p) { showError($phoneNumberError, 'Please enter your phone number'); return; }
        if (!validatePhoneNumber(p, code)) return;

        hideError($firstNameError); hideError($lastNameError); hideError($phoneNumberError);
        showButtonLoading($saveProfileBtn);

        const fullPhone = code + p;
        
        $.ajax({
            url: base_url + 'auth/save-profile',
            type: 'POST',
            data: { first_name: f, last_name: l, mobile: fullPhone },
            dataType: 'json',
            xhrFields: {
                withCredentials: true
            }
        }).done(function (res) {
            hideButtonLoading($saveProfileBtn);
            if (res && res.success) {
                // Store the token for future requests
                signupToken = res.token;
                showFormById('profilePictureForm');
            } else {
                showError($firstNameError, (res && res.message) ? res.message : 'Could not save profile.');
            }
        }).fail(function (xhr) {
            hideButtonLoading($saveProfileBtn);
            let msg = 'An error occurred. Please try again.';
            if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            showError($firstNameError, msg);
            console.error('Save profile failed:', xhr);
        });
    });

    // --- Profile picture preview & validation ---
    $profilePictureInput.on('change', function () {
        const file = this.files && this.files[0];
        if (!file) return;
        if (!file.type.match('image.*')) { showError($profilePictureError, 'Please select an image file'); return; }
        if (file.size > 5 * 1024 * 1024) { showError($profilePictureError, 'File size must be less than 5MB'); return; }
        hideError($profilePictureError);
        const reader = new FileReader();
        reader.onload = function (ev) {
            $('.profile-picture-preview').html(`<img src="${ev.target.result}" alt="Profile Picture" style="max-width:140px; border-radius:8px;">`);
        };
        reader.readAsDataURL(file);
    });

    // --- Upload profile picture or skip ---
    $uploadProfileBtn.on('click', function () {
        const file = $profilePictureInput.prop('files') && $profilePictureInput.prop('files')[0];
        
        if (!file) { // skip upload
            completeSignup();
            return;
        }
        
        hideError($profilePictureError);
        showButtonLoading($uploadProfileBtn);

        const fd = new FormData();
        fd.append('profile_picture', file);
        fd.append('token', signupToken);

        $.ajax({
            url: base_url + 'auth/upload-profile-picture',
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            dataType: 'json',
            xhrFields: {
                withCredentials: true
            }
        }).done(function (res) {
            hideButtonLoading($uploadProfileBtn);
            if (res && res.success) {
                // Update token if it changed
                if (res.token) signupToken = res.token;
                completeSignup();
            } else {
                showError($profilePictureError, (res && res.message) ? res.message : 'Could not upload picture.');
            }
        }).fail(function (xhr) {
            hideButtonLoading($uploadProfileBtn);
            let msg = 'An error occurred. Please try again.';
            if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            showError($profilePictureError, msg);
            console.error('Upload profile picture failed:', xhr);
        });
    });

    // skip profile link
    $(document).on('click', '.skip-profile-link', function (e) { 
        e.preventDefault(); 
        completeSignup(); 
    });

    // complete signup (final step)
    function completeSignup() {
        if (!signupToken) {
            alert('Session expired. Please refresh the page and try again.');
            return;
        }
        
        showButtonLoading($uploadProfileBtn);
        
        $.ajax({
            url: base_url + 'auth/complete-signup',
            type: 'POST',
            data: { token: signupToken },
            dataType: 'json',
            xhrFields: {
                withCredentials: true
            }
        }).done(function (res) {
            hideButtonLoading($uploadProfileBtn);
            if (res && res.success) {
                showFormById('welcomeForm');
            } else {
                alert((res && res.message) ? res.message : 'An error occurred.');
                console.error('Complete signup failed:', res);
            }
        }).fail(function (xhr) {
            hideButtonLoading($uploadProfileBtn);
            let msg = 'An error occurred. Please try again.';
            if (xhr && xhr.responseJSON && xhr.responseJSON.message) {
                msg = xhr.responseJSON.message;
            }
            alert(msg);
            console.error('Complete signup failed:', xhr);
        });
    }

    // download ebook
    $downloadEbookBtn.on('click', function (e) {
        e.preventDefault();
        showButtonLoading($downloadEbookBtn);
        
        $.ajax({
            url: base_url + 'auth/complete-signup',
            type: 'POST',
            data: { token: signupToken },
            dataType: 'json',
            xhrFields: {
                withCredentials: true
            }
        }).done(function (res) {
            hideButtonLoading($downloadEbookBtn);
            if (res && res.success) {
                window.location.href = base_url + 'download-ebook';
            } else {
                alert((res && res.message) ? res.message : 'Could not download e-book.');
            }
        }).fail(function () {
            hideButtonLoading($downloadEbookBtn);
            alert('An error occurred. Please try again.');
        });
    });

    // skip-download
    $(document).on('click', '.skip-download-link', function (e) {
        e.preventDefault();
        showButtonLoading($(this));
        
        $.ajax({
            url: base_url + 'auth/complete-signup',
            type: 'POST',
            data: { token: signupToken },
            dataType: 'json',
            xhrFields: {
                withCredentials: true
            }
        }).done(function (res) {
            if (res && res.success) {
                window.location.href = (res.redirect || '/');
            } else {
                alert((res && res.message) ? res.message : 'An error occurred.');
            }
        }).fail(function () {
            alert('An error occurred. Please try again.');
        }).always(function () { 
            hideButtonLoading($(this)); 
        });
    });

    // resend OTP link (works for both login & signup)
    $(document).on('click', '.resend-otp-link', function (e) {
        e.preventDefault();
        const formType = $(this).data('form'); // 'login' or 'signup'
        const emailInput = formType === 'login' ? $loginEmail : $signupEmail;
        const email = (emailInput.val() || '').trim();
        const $successEl = formType === 'login' ? $loginOtpSuccess : $signupOtpSuccess;
        const $resendLink = $(this);
        const $errorEl = formType === 'login' ? $loginOtpError : $signupOtpError;

        if (!email) { 
            showError($errorEl, 'Email address is required'); 
            return; 
        }
        
        // Disable the resend link temporarily
        $resendLink.addClass('disabled');
        
        $.ajax({
            url: base_url + 'auth/send-' + formType + '-otp',
            type: 'POST',
            data: { email },
            dataType: 'json',
            xhrFields: {
                withCredentials: true
            }
        }).done(function (res) {
            if (res && res.success) {
                showSuccess($successEl, 'OTP has been resent to your email');
                // clear inputs inside appropriate OTP form
                const formId = (formType === 'login') ? '#loginOtpForm' : '#signupOtpForm';
                $(formId + ' .otp-input').val('');
                $(formId + ' .otp-input:first').focus();
                
                // Simple disable for 60 seconds without countdown
                setTimeout(function() {
                    $resendLink.removeClass('disabled');
                }, 60000);
            } else {
                $resendLink.removeClass('disabled');
                // Show error message in the UI (not alert)
                if (res && res.rate_limit_exceeded) {
                    showError($errorEl, res.message);
                    $errorEl.addClass('rate-limit-error');
                } else if (res && res.message) {
                    showError($errorEl, res.message);
                } else {
                    showError($errorEl, 'Could not resend OTP. Please try again later.');
                }
            }
        }).fail(function () {
            $resendLink.removeClass('disabled');
            showError($errorEl, 'An error occurred. Please try again.');
        });
    });

    // Function to start countdown timer
    function startOtpCountdown($element, seconds, formType) {
        let remainingTime = seconds;
        const originalText = $element.text();
        
        // Clear any existing timer
        if (formType === 'login' && loginOtpTimer) {
            clearInterval(loginOtpTimer);
        } else if (formType === 'signup' && signupOtpTimer) {
            clearInterval(signupOtpTimer);
        }
        
        // Update the button text with countdown
        $element.text(`Resend OTP (${remainingTime}s)`);
        
        // Create the countdown timer
        const timer = setInterval(function() {
            remainingTime--;
            $element.text(`Resend OTP (${remainingTime}s)`);
            
            if (remainingTime <= 0) {
                clearInterval(timer);
                $element.text(originalText).removeClass('disabled');
                
                // Clear the timer reference
                if (formType === 'login') {
                    loginOtpTimer = null;
                } else {
                    signupOtpTimer = null;
                }
            }
        }, 1000);
        
        // Store the timer reference
        if (formType === 'login') {
            loginOtpTimer = timer;
        } else {
            signupOtpTimer = timer;
        }
    }

    // Function to show rate limit error with countdown
    function showOtpRateLimitError($element, message, seconds, formType) {
        const $errorContainer = $element.closest('.text-center');
        const $errorElement = $('<div class="text-danger small mt-2"></div>');
        
        // Remove any existing error
        $errorContainer.find('.text-danger').remove();
        
        // Add the error message
        $errorElement.text(message);
        $errorContainer.append($errorElement);
        
        // Start countdown
        startOtpCountdown($element, seconds, formType);
    }
    // Utility: prevent form submission on enter inside OTP (we submit via form) - allow normal handling
    // End of $(function)
});
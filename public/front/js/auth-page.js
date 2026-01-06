/* auth-page.js - Enhanced with comprehensive error handling */
 $(function () {
    // Global error handler for unhandled JavaScript errors
    window.addEventListener('error', function(event) {
        logClientError('JavaScript Error', {
            message: event.message,
            filename: event.filename,
            lineno: event.lineno,
            colno: event.colno,
            stack: event.error ? event.error.stack : null,
            timestamp: new Date().toISOString()
        });
    });

    // Global error handler for unhandled promise rejections
    window.addEventListener('unhandledrejection', function(event) {
        logClientError('Unhandled Promise Rejection', {
            reason: event.reason,
            timestamp: new Date().toISOString()
        });
    });

    const connection = navigator.connection || navigator.mozConnection || navigator.webkitConnection;

    // Enhanced browser information
    const browserInfo = {
        name: (function() {
            const ua = navigator.userAgent;
            if (ua.indexOf("SamsungBrowser") > -1) return "Samsung Browser";
            if (ua.indexOf("Chrome") > -1 && ua.indexOf("Edg") === -1) return "Chrome";
            if (ua.indexOf("Safari") > -1 && ua.indexOf("Chrome") === -1) return "Safari";
            if (ua.indexOf("Firefox") > -1) return "Firefox";
            if (ua.indexOf("Edg") > -1) return "Edge";
            return "Unknown";
        })(),
        version: (function() {
            const ua = navigator.userAgent;
            let match;
            if (ua.indexOf("SamsungBrowser") > -1) {
                match = ua.match(/SamsungBrowser\/(\d+)/);
            } else if (ua.indexOf("Chrome") > -1 && ua.indexOf("Edg") === -1) {
                match = ua.match(/Chrome\/(\d+)/);
            } else if (ua.indexOf("Safari") > -1 && ua.indexOf("Chrome") === -1) {
                match = ua.match(/Version\/(\d+).*Safari/);
            } else if (ua.indexOf("Firefox") > -1) {
                match = ua.match(/Firefox\/(\d+)/);
            } else if (ua.indexOf("Edg") > -1) {
                match = ua.match(/Edg\/(\d+)/);
            }
            return match ? match[1] : "Unknown";
        })(),
        platform: navigator.platform,
        language: navigator.language,
        cookieEnabled: navigator.cookieEnabled,
        onLine: navigator.onLine,
        screen: {
            width: screen.width,
            height: screen.height,
            colorDepth: screen.colorDepth
        },
        connection: connection ? {
            effectiveType: connection.effectiveType || null,
            downlink: connection.downlink || null,
            rtt: connection.rtt || null
        } : null
    };

    // Client-side logging function
    function logClientError(type, data) {
        const logData = {
            type: type,
            url: window.location.href,
            browser: browserInfo,
            timestamp: new Date().toISOString(),
            data: data
        };
        
        console.error('Client Error:', logData);
        
        // Send to server
        $.ajax({
            url: base_url + 'auth/log-client-error',
            type: 'POST',
            data: logData,
            dataType: 'json',
            timeout: 5000
        }).fail(function() {
            console.error('Failed to send client error to server');
        });
    }

    // Enhanced AJAX function with retry and detailed error handling
    function enhancedAjax(options) {
        const defaults = {
            timeout: 30000,
            retries: 2,
            retryDelay: 1000
        };
        
        const settings = $.extend({}, defaults, options);
        
        return new Promise(function(resolve, reject) {
            let retryCount = 0;
            
            function makeRequest() {
                const startTime = performance.now();
                
                $.ajax(settings)
                    .done(function(data, textStatus, xhr) {
                        const endTime = performance.now();
                        
                        // Log successful request
                        if (settings.logSuccess !== false) {
                            console.log('AJAX Success:', {
                                url: settings.url,
                                method: settings.method || 'GET',
                                duration: endTime - startTime,
                                status: xhr.status,
                                browser: browserInfo
                            });
                        }
                        
                        resolve({data, textStatus, xhr});
                    })
                    .fail(function(xhr, textStatus, error) {
                        const endTime = performance.now();
                        
                        // Log failed request
                        logClientError('AJAX Error', {
                            url: settings.url,
                            method: settings.method || 'GET',
                            status: xhr.status,
                            statusText: xhr.statusText,
                            error: error,
                            duration: endTime - startTime,
                            responseText: xhr.responseText,
                            retryCount: retryCount
                        });
                        
                        retryCount++;
                        
                        // Retry on network errors or 5xx errors
                        if (retryCount <= settings.retries && 
                            (textStatus === 'timeout' || textStatus === 'error' || (xhr.status >= 500 && xhr.status < 600))) {
                            
                            console.log(`Retrying request (${retryCount}/${settings.retries})...`);
                            setTimeout(makeRequest, settings.retryDelay * retryCount);
                        } else {
                            reject({xhr, textStatus, error});
                        }
                    });
            }
            
            makeRequest();
        });
    }

    function isPopupAllowedByUserGesture()
    {
        try {
            const popup = window.open('about:blank', '_blank', 'width=100,height=100');
            if (!popup) return false;
            popup.close();
            return true;
        } catch (e) {
            return false;
        }
    }

    // Check for common issues before attempting login
    function performPreLoginChecks() {
        const issues = [];

        if (!navigator.cookieEnabled) issues.push('Cookies are disabled');
        if (!navigator.onLine) issues.push('Browser is offline');

        try {
            localStorage.setItem('t', '1');
            localStorage.removeItem('t');
        } catch (e) {
            issues.push('localStorage is not available');
        }

        try {
            sessionStorage.setItem('t', '1');
            sessionStorage.removeItem('t');
        } catch (e) {
            issues.push('sessionStorage is not available');
        }

        if (issues.length > 0) {
            logClientError('Pre-login checks failed', { issues });
            $('#browser-issues').html(
                '<div class="alert alert-warning">' +
                '<ul><li>' + issues.join('</li><li>') + '</li></ul>' +
                '</div>'
            ).show();
            return false;
        }

        return true;
    }

    // --- Global AJAX Setup for Session Handling ---
    $.ajaxSetup({
        xhrFields: {
            withCredentials: true
        },
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    });

    // --- Cache DOM elements ---
    const authForms = {
        loginForm: document.getElementById('loginForm'),
        loginOtpForm: document.getElementById('loginOtpForm'),
        signupForm: document.getElementById('signupForm'),
        signupOtpForm: document.getElementById('signupOtpForm'),
        profileForm: document.getElementById('profileForm'),
        profilePictureForm: document.getElementById('profilePictureForm'),
        welcomeForm: document.getElementById('welcomeForm')
    };

    // jQuery-wrapped elements
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

    // Store the signup token globally
    let signupToken = null;
    let loginOtpTimer = null;
    let signupOtpTimer = null;

    // Phone patterns & examples
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
    function showFormById(formId) {
        // Hide all forms
        Object.values(authForms).forEach(el => { if (el) el.classList.add('d-none'); });
        
        // Show requested
        const el = authForms[formId];
        if (el) el.classList.remove('d-none');
    }

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

    // --- Switch link handler ---
    $(document).on('click', '.auth-switch-link', function (e) {
        e.preventDefault();
        const target = $(this).data('target');
        if (!target) return;
        showFormById(target);
    });

    // --- LOGIN form submit (send OTP) ---
    $loginFormElement.on('submit', function (e) {
        e.preventDefault();
        
        // Perform pre-login checks
        if (!performPreLoginChecks()) {
            return;
        }
        
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
        
        const requestData = {
            url: base_url + 'auth/send-login-otp',
            type: 'POST',
            data: { email },
            dataType: 'json',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-Client-Info', JSON.stringify(browserInfo));
                xhr.setRequestHeader('X-Request-ID', 'req_' + Date.now());
            }
        };
        
        enhancedAjax(requestData)
            .then(function({data, textStatus, xhr}) {
                hideButtonLoading($sendLoginOtpBtn);
                
                if (data && data.success) {
                    // Store request ID for debugging
                    if (data.request_id) {
                        sessionStorage.setItem('last_login_request_id', data.request_id);
                    }
                    
                    showFormById('loginOtpForm');
                    $('#loginOtpForm .otp-input:first').focus();
                } else {
                    const message = data && data.message ? data.message : 'Could not send OTP.';
                    showError($loginEmailError, message);
                }
            })
            .catch(function({xhr, textStatus, error}) {
                hideButtonLoading($sendLoginOtpBtn);
                
                let errorMessage = 'An error occurred. Please try again.';
                
                if (xhr.status === 0) {
                    errorMessage = 'Network error. Please check your internet connection.';
                } else if (xhr.status === 429) {
                    errorMessage = 'Too many requests. Please wait before trying again.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error. Please try again in a few moments.';
                } else if (xhr.status === 503) {
                    errorMessage = 'Service temporarily unavailable. Please try again later.';
                }
                
                showError($loginEmailError, errorMessage);
            });
    });

    $sendLoginOtpBtn.on('click', function (e) {

        const popupAllowed = isPopupAllowedByUserGesture();

        if (!popupAllowed) {
            e.preventDefault();

            $('#browser-issues').html(
                '<div class="alert alert-warning">' +
                '<h5>Popup Blocked</h5>' +
                '<p>Please allow popups for this site.</p>' +
                '</div>'
            ).show();

            logClientError('Popup Blocked', {
                action: 'login'
            });

            return false;
        }
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

        const requestData = {
            url: base_url + 'auth/send-signup-otp',
            type: 'POST',
            data: { email },
            dataType: 'json',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-Client-Info', JSON.stringify(browserInfo));
                xhr.setRequestHeader('X-Request-ID', 'req_' + Date.now());
            }
        };
        
        enhancedAjax(requestData)
            .then(function({data, textStatus, xhr}) {
                hideButtonLoading($sendSignupOtpBtn);
                if (data && data.success) {
                    showFormById('signupOtpForm');
                    $('#signupOtpForm .otp-input:first').focus();
                } else {
                    const message = data && data.message ? data.message : 'Could not send OTP.';
                    showError($signupEmailError, message);
                }
            })
            .catch(function({xhr, textStatus, error}) {
                hideButtonLoading($sendSignupOtpBtn);
                
                let errorMessage = 'An error occurred. Please try again.';
                
                if (xhr.status === 0) {
                    errorMessage = 'Network error. Please check your internet connection.';
                } else if (xhr.status === 429) {
                    errorMessage = 'Too many requests. Please wait before trying again.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error. Please try again in a few moments.';
                }
                
                showError($signupEmailError, errorMessage);
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

        const requestData = {
            url: base_url + 'auth/verify-login-otp',
            type: 'POST',
            data: { otp },
            dataType: 'json',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-Client-Info', JSON.stringify(browserInfo));
                xhr.setRequestHeader('X-Request-ID', 'req_' + Date.now());
            }
        };

        enhancedAjax(requestData)
            .then(function({data, textStatus, xhr}) {
                hideButtonLoading($verifyLoginOtpBtn);
                if (data && data.success) {
                    // success -> redirect if provided
                    if (data.redirect) window.location.href = data.redirect;
                    else location.reload();
                } else {
                    showError($loginOtpError, (data && data.message) ? data.message : 'Invalid OTP.');
                }
            })
            .catch(function({xhr, textStatus, error}) {
                hideButtonLoading($verifyLoginOtpBtn);
                
                let errorMessage = 'An error occurred. Please try again.';
                
                if (xhr.status === 0) {
                    errorMessage = 'Network error. Please check your internet connection.';
                } else if (xhr.status === 419) {
                    errorMessage = 'Session expired. Please refresh the page and try again.';
                } else if (xhr.status === 429) {
                    errorMessage = 'Too many attempts. Please wait before trying again.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error. Please try again in a few moments.';
                }
                
                showError($loginOtpError, errorMessage);
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

        const requestData = {
            url: base_url + 'auth/verify-signup-otp',
            type: 'POST',
            data: { otp },
            dataType: 'json',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-Client-Info', JSON.stringify(browserInfo));
                xhr.setRequestHeader('X-Request-ID', 'req_' + Date.now());
            }
        };

        enhancedAjax(requestData)
            .then(function({data, textStatus, xhr}) {
                hideButtonLoading($verifySignupOtpBtn);
                if (data && data.success) {
                    showFormById('profileForm');
                    if ($firstName && $firstName.length) $firstName.focus();
                } else {
                    showError($signupOtpError, (data && data.message) ? data.message : 'Invalid OTP.');
                }
            })
            .catch(function({xhr, textStatus, error}) {
                hideButtonLoading($verifySignupOtpBtn);
                
                let errorMessage = 'An error occurred. Please try again.';
                
                if (xhr.status === 0) {
                    errorMessage = 'Network error. Please check your internet connection.';
                } else if (xhr.status === 419) {
                    errorMessage = 'Session expired. Please refresh the page and try again.';
                } else if (xhr.status === 429) {
                    errorMessage = 'Too many attempts. Please wait before trying again.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error. Please try again in a few moments.';
                }
                
                showError($signupOtpError, errorMessage);
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
        
        const requestData = {
            url: base_url + 'auth/save-profile',
            type: 'POST',
            data: { first_name: f, last_name: l, mobile: fullPhone },
            dataType: 'json',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-Client-Info', JSON.stringify(browserInfo));
                xhr.setRequestHeader('X-Request-ID', 'req_' + Date.now());
            }
        };
        
        enhancedAjax(requestData)
            .then(function({data, textStatus, xhr}) {
                hideButtonLoading($saveProfileBtn);
                if (data && data.success) {
                    // Store the token for future requests
                    signupToken = data.token;
                    showFormById('profilePictureForm');
                } else {
                    showError($firstNameError, (data && data.message) ? data.message : 'Could not save profile.');
                }
            })
            .catch(function({xhr, textStatus, error}) {
                hideButtonLoading($saveProfileBtn);
                
                let errorMessage = 'An error occurred. Please try again.';
                
                if (xhr.status === 0) {
                    errorMessage = 'Network error. Please check your internet connection.';
                } else if (xhr.status === 419) {
                    errorMessage = 'Session expired. Please refresh the page and try again.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error. Please try again in a few moments.';
                }
                
                showError($firstNameError, errorMessage);
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

        const requestData = {
            url: base_url + 'auth/upload-profile-picture',
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-Client-Info', JSON.stringify(browserInfo));
                xhr.setRequestHeader('X-Request-ID', 'req_' + Date.now());
            }
        };
        
        enhancedAjax(requestData)
            .then(function({data, textStatus, xhr}) {
                hideButtonLoading($uploadProfileBtn);
                if (data && data.success) {
                    // Update token if it changed
                    if (data.token) signupToken = data.token;
                    completeSignup();
                } else {
                    showError($profilePictureError, (data && data.message) ? data.message : 'Could not upload picture.');
                }
            })
            .catch(function({xhr, textStatus, error}) {
                hideButtonLoading($uploadProfileBtn);
                
                let errorMessage = 'An error occurred. Please try again.';
                
                if (xhr.status === 0) {
                    errorMessage = 'Network error. Please check your internet connection.';
                } else if (xhr.status === 419) {
                    errorMessage = 'Session expired. Please refresh the page and try again.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error. Please try again in a few moments.';
                }
                
                showError($profilePictureError, errorMessage);
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
        
        const requestData = {
            url: base_url + 'auth/complete-signup',
            type: 'POST',
            data: { token: signupToken },
            dataType: 'json',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-Client-Info', JSON.stringify(browserInfo));
                xhr.setRequestHeader('X-Request-ID', 'req_' + Date.now());
            }
        };
        
        enhancedAjax(requestData)
            .then(function({data, textStatus, xhr}) {
                hideButtonLoading($uploadProfileBtn);
                if (data && data.success) {
                    showFormById('welcomeForm');
                } else {
                    alert((data && data.message) ? data.message : 'An error occurred.');
                }
            })
            .catch(function({xhr, textStatus, error}) {
                hideButtonLoading($uploadProfileBtn);
                
                let errorMessage = 'An error occurred. Please try again.';
                
                if (xhr.status === 0) {
                    errorMessage = 'Network error. Please check your internet connection.';
                } else if (xhr.status === 419) {
                    errorMessage = 'Session expired. Please refresh the page and try again.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error. Please try again in a few moments.';
                }
                
                alert(errorMessage);
            });
    }

    // download ebook
    $downloadEbookBtn.on('click', function (e) {
        e.preventDefault();
        showButtonLoading($downloadEbookBtn);
        
        const requestData = {
            url: base_url + 'auth/complete-signup',
            type: 'POST',
            data: { token: signupToken },
            dataType: 'json',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-Client-Info', JSON.stringify(browserInfo));
                xhr.setRequestHeader('X-Request-ID', 'req_' + Date.now());
            }
        };
        
        enhancedAjax(requestData)
            .then(function({data, textStatus, xhr}) {
                hideButtonLoading($downloadEbookBtn);
                if (data && data.success) {
                    window.location.href = base_url + 'download-ebook';
                } else {
                    alert((data && data.message) ? data.message : 'Could not download e-book.');
                }
            })
            .catch(function({xhr, textStatus, error}) {
                hideButtonLoading($downloadEbookBtn);
                
                let errorMessage = 'An error occurred. Please try again.';
                
                if (xhr.status === 0) {
                    errorMessage = 'Network error. Please check your internet connection.';
                } else if (xhr.status === 419) {
                    errorMessage = 'Session expired. Please refresh the page and try again.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error. Please try again in a few moments.';
                }
                
                alert(errorMessage);
            });
    });

    // skip-download
    $(document).on('click', '.skip-download-link', function (e) {
        e.preventDefault();
        showButtonLoading($(this));
        
        const requestData = {
            url: base_url + 'auth/complete-signup',
            type: 'POST',
            data: { token: signupToken },
            dataType: 'json',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-Client-Info', JSON.stringify(browserInfo));
                xhr.setRequestHeader('X-Request-ID', 'req_' + Date.now());
            }
        };
        
        enhancedAjax(requestData)
            .then(function({data, textStatus, xhr}) {
                if (data && data.success) {
                    window.location.href = (data.redirect || '/');
                } else {
                    alert((data && data.message) ? data.message : 'An error occurred.');
                }
            })
            .catch(function({xhr, textStatus, error}) {
                let errorMessage = 'An error occurred. Please try again.';
                
                if (xhr.status === 0) {
                    errorMessage = 'Network error. Please check your internet connection.';
                } else if (xhr.status === 419) {
                    errorMessage = 'Session expired. Please refresh the page and try again.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error. Please try again in a few moments.';
                }
                
                alert(errorMessage);
            })
            .always(function () { 
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
        
        const requestData = {
            url: base_url + 'auth/send-' + formType + '-otp',
            type: 'POST',
            data: { email },
            dataType: 'json',
            beforeSend: function(xhr) {
                xhr.setRequestHeader('X-Client-Info', JSON.stringify(browserInfo));
                xhr.setRequestHeader('X-Request-ID', 'req_' + Date.now());
            }
        };
        
        enhancedAjax(requestData)
            .then(function({data, textStatus, xhr}) {
                if (data && data.success) {
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
                    if (data && data.rate_limit_exceeded) {
                        showError($errorEl, data.message);
                    } else if (data && data.message) {
                        showError($errorEl, data.message);
                    } else {
                        showError($errorEl, 'Could not resend OTP. Please try again later.');
                    }
                }
            })
            .catch(function({xhr, textStatus, error}) {
                $resendLink.removeClass('disabled');
                
                let errorMessage = 'An error occurred. Please try again.';
                
                if (xhr.status === 0) {
                    errorMessage = 'Network error. Please check your internet connection.';
                } else if (xhr.status === 429) {
                    errorMessage = 'Too many requests. Please wait before trying again.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error. Please try again in a few moments.';
                }
                
                showError($errorEl, errorMessage);
            });
    });

    // Add health check function
    window.checkSystemHealth = function () {
        enhancedAjax({
            url: base_url + 'auth/health-check',
            type: 'GET',
            dataType: 'json',
            logSuccess: false
        })
        .then(function({data}) {
            if (data.status !== 'healthy') {
                console.warn('System health issues detected:', data.checks);
                
                // Show warning if critical services are down
                const criticalIssues = Object.entries(data.checks)
                    .filter(([key, check]) => check.status === 'error')
                    .map(([key, check]) => `${key}: ${check.message}`);
                
                if (criticalIssues.length > 0) {
                    $('#system-issues').html(
                        '<div class="alert alert-danger">' +
                        '<h5>System Issues</h5>' +
                        '<p>We\'re experiencing technical difficulties:</p>' +
                        '<ul><li>' + criticalIssues.join('</li><li>') + '</li></ul>' +
                        '<p>Please try again later.</p>' +
                        '</div>'
                    ).show();
                }
            }
        })
        .catch(function() {
            console.warn('Could not check system health');
        });
    }
    
    checkSystemHealth();
    
    // Add debug info panel in development
    if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
        $('body').append(
            '<div id="debug-panel" style="position: fixed; bottom: 10px; right: 10px; background: #fff; border: 1px solid #ccc; padding: 10px; font-size: 12px; z-index: 9999;">' +
            '<strong>Debug Info</strong><br>' +
            'Browser: ' + browserInfo.name + ' ' + browserInfo.version + '<br>' +
            'Platform: ' + browserInfo.platform + '<br>' +
            'Online: ' + (browserInfo.onLine ? 'Yes' : 'No') + '<br>' +
            'Cookies: ' + (browserInfo.cookieEnabled ? 'Yes' : 'No') + '<br>' +
            '<button id="loginBtn">Login</button>' +
            '</div>'
        );
    }
});
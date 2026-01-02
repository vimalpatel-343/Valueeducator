<?= $this->include('front/header') ?>
<style>

    body {
        overflow: hidden;
    }

    .login-container {
        height: 90vh;
        display: flex;
        align-items: center;
    }
    
    .login-left {
        background: linear-gradient(135deg, #FFFFFF 0%, #FFFFFF 100%);
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        position: relative;
        overflow: hidden;
    }
    
    .login-left-content {
        position: relative;
        z-index: 2;
        text-align: center;
        padding: 2rem;
        max-width: 500px;
    }
    
    .login-left h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }
    
    .login-left p {
        font-size: 1.1rem;
        margin-bottom: 2rem;
        opacity: 0.9;
    }
    
    .login-right {
        background-color: #f8f9fa;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }
    
    .auth-form-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 2.5rem;
        width: 100%;
        max-width: 450px;
    }
    
    .auth-logo {
        text-align: center;
        margin-bottom: 2rem;
    }
    
    .auth-logo img {
        max-height: 50px;
    }
    
    .auth-title {
        font-size: 1.5rem;
        font-weight: 600;
        text-align: center;
        margin-bottom: 1.5rem;
        color: #333;
    }
    
    .form-floating {
        margin-bottom: 1.5rem;
    }
    
    .otp-input-group {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 1.5rem;
    }
    
    .otp-input {
        width: 45px;
        height: 45px;
        text-align: center;
        font-size: 1.5rem;
        font-weight: 600;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    
    .otp-input:focus {
        border-color: #6a11cb;
        box-shadow: 0 0 0 0.2rem rgba(106, 17, 203, 0.25);
    }
    
    .auth-switch {
        text-align: center;
        margin-top: 1.5rem;
    }
    
    .auth-switch a {
        color: #6a11cb;
        text-decoration: none;
        font-weight: 500;
    }
    
    .auth-switch a:hover {
        text-decoration: underline;
    }
    
    .invalid-feedback {
        display: block;
        margin-top: 0.5rem;
        color: #dc3545;
        font-size: 0.875rem;
    }
    
    .text-success {
        color: #28a745;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    
    .auth-footer {
        text-align: center;
        margin-top: 2rem;
        font-size: 0.875rem;
        color: #6c757d;
    }
    
    .auth-footer a {
        color: #6a11cb;
        text-decoration: none;
    }
    
    .auth-footer a:hover {
        text-decoration: underline;
    }
    
    .illustration {
        max-width: 100%;
        height: auto;
        margin-bottom: 2rem;
    }
    
    @media (max-width: 991.98px) {
        .login-left {
            display: none;
        }
        
        .login-right {
            height: auto;
            min-height: 100vh;
            padding: 1rem;
        }

        .login-left-content {
            padding: 1rem;
        }
    }
</style>
<div class="login-container">
    <!-- Left Side - Illustration -->
    <div class="col-lg-6 login-left">
        <div class="login-left-content">
            <img src="<?= base_url('images/login-illustration.png') ?>" alt="Login Illustration" class="illustration">            
        </div>
    </div>
    
    <!-- Right Side - Login Form -->
    <div class="col-lg-6 login-right">
        <div class="auth-form-container auth-modal">
            
            <!-- LOGIN FORM -->
            <div id="loginForm" class="auth-form">
                <div class="text-center mb-4">
                    <h3 class="auth-title">Login to Your Account</h3>                        
                </div>

                <form id="loginFormElement">
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="email" class="form-control" id="loginEmail" placeholder=" " required>
                            <label for="loginEmail">Email address</label>
                        </div>
                        <div class="invalid-feedback" id="loginEmailError"></div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg" id="sendLoginOtpBtn">
                            <span class="btn-text">Send OTP</span>
                            <span class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>

                    <div class="auth-switch mt-3">
                        <p class="mb-0">Don't have an account? <a href="#" class="auth-switch-link" data-target="signupForm">Sign Up</a></p>
                    </div>
                </form>
            </div>

            <!-- LOGIN OTP FORM -->
            <div id="loginOtpForm" class="auth-form d-none">
                <div class="text-center mb-4">
                    <h3 class="auth-title">Enter Verification Code</h3>
                    <p class="text-muted">We've sent a 6-digit code to your email</p>
                </div>

                <form id="loginOtpFormElement">
                    <div class="mb-4">
                        <div class="otp-input-group d-flex justify-content-center gap-2">
                            <input type="text" class="form-control otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-index="0">
                            <input type="text" class="form-control otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-index="1">
                            <input type="text" class="form-control otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-index="2">
                            <input type="text" class="form-control otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-index="3">
                            <input type="text" class="form-control otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-index="4">
                            <input type="text" class="form-control otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-index="5">
                        </div>
                        <div class="invalid-feedback" id="loginOtpError"></div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg" id="verifyLoginOtpBtn" disabled>
                            <span class="btn-text">Verify & Login</span>
                            <span class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <p>Didn't receive the code? <a href="#" class="resend-otp-link" data-form="login">Resend OTP</a></p>
                        <p class="text-success small mt-2 d-none" id="loginOtpSuccess"></p>
                    </div>
                </form>
            </div>

            <!-- SIGNUP FORM -->
            <div id="signupForm" class="auth-form d-none">
                <div class="text-center mb-4">
                    <h3 class="auth-title">Create Your Account</h3>
                    <p class="text-muted">Enter your email to get started</p>
                </div>

                <form id="signupFormElement">
                    <div class="mb-3">
                        <div class="form-floating">
                            <input type="email" class="form-control" id="signupEmail" placeholder=" " required>
                            <label for="signupEmail">Email address</label>
                        </div>
                        <div class="invalid-feedback" id="signupEmailError"></div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg" id="sendSignupOtpBtn">
                            <span class="btn-text">Send OTP</span>
                            <span class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>

                    <div class="auth-switch mt-3">
                        <p>Already have an account? <a href="#" class="auth-switch-link" data-target="loginForm">Login</a></p>
                    </div>
                </form>
            </div>

            <!-- SIGNUP OTP FORM -->
            <div id="signupOtpForm" class="auth-form d-none">
                <div class="text-center mb-4">
                    <h3 class="auth-title">Enter Verification Code</h3>
                    <p class="text-muted">We've sent a 6-digit code to your email</p>
                </div>

                <form id="signupOtpFormElement">
                    <div class="mb-4">
                        <div class="otp-input-group d-flex justify-content-center gap-2">
                            <input type="text" class="form-control otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-index="0">
                            <input type="text" class="form-control otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-index="1">
                            <input type="text" class="form-control otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-index="2">
                            <input type="text" class="form-control otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-index="3">
                            <input type="text" class="form-control otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-index="4">
                            <input type="text" class="form-control otp-input" maxlength="1" inputmode="numeric" pattern="[0-9]*" data-index="5">
                        </div>
                        <div class="invalid-feedback" id="signupOtpError"></div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg" id="verifySignupOtpBtn" disabled>
                            <span class="btn-text">Verify & Continue</span>
                            <span class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <p>Didn't receive the code? <a href="#" class="resend-otp-link" data-form="signup">Resend OTP</a></p>
                        <p class="text-success small mt-2 d-none" id="signupOtpSuccess"></p>
                    </div>
                </form>
            </div>

            <!-- PROFILE FORM -->
            <div id="profileForm" class="auth-form d-none">
                <div class="text-center mb-4">
                    <h3 class="auth-title">Complete Your Profile</h3>
                </div>

                <form id="profileFormElement">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="firstName" placeholder=" " required>
                                <label for="firstName">First Name</label>
                            </div>
                            <div class="invalid-feedback" id="firstNameError"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="lastName" placeholder=" " required>
                                <label for="lastName">Last Name</label>
                            </div>
                            <div class="invalid-feedback" id="lastNameError"></div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Phone Number</label>
                        <div class="input-group">
                            <select class="form-select" id="countryCode" style="max-width: 120px;">
                                <option value="+1" data-flag="https://flagcdn.com/16x12/us.png">US +1</option>
                                <option value="+44" data-flag="https://flagcdn.com/16x12/gb.png">GB +44</option>
                                <option value="+91" data-flag="https://flagcdn.com/16x12/in.png" selected>IN +91</option>
                                <option value="+61" data-flag="https://flagcdn.com/16x12/au.png">AU +61</option>
                                <option value="+86" data-flag="https://flagcdn.com/16x12/cn.png">CN +86</option>
                                <option value="+81" data-flag="https://flagcdn.com/16x12/jp.png">JP +81</option>
                                <option value="+49" data-flag="https://flagcdn.com/16x12/de.png">DE +49</option>
                                <option value="+33" data-flag="https://flagcdn.com/16x12/fr.png">FR +33</option>
                                <option value="+7" data-flag="https://flagcdn.com/16x12/ru.png">RU +7</option>
                                <option value="+82" data-flag="https://flagcdn.com/16x12/kr.png">KR +82</option>
                                <option value="+39" data-flag="https://flagcdn.com/16x12/it.png">IT +39</option>
                                <option value="+34" data-flag="https://flagcdn.com/16x12/es.png">ES +34</option>
                                <option value="+31" data-flag="https://flagcdn.com/16x12/nl.png">NL +31</option>
                                <option value="+41" data-flag="https://flagcdn.com/16x12/ch.png">CH +41</option>
                                <option value="+43" data-flag="https://flagcdn.com/16x12/at.png">AT +43</option>
                                <option value="+45" data-flag="https://flagcdn.com/16x12/dk.png">DK +45</option>
                                <option value="+46" data-flag="https://flagcdn.com/16x12/se.png">SE +46</option>
                                <option value="+47" data-flag="https://flagcdn.com/16x12/no.png">NO +47</option>
                                <option value="+358" data-flag="https://flagcdn.com/16x12/fi.png">FI +358</option>
                                <option value="+351" data-flag="https://flagcdn.com/16x12/pt.png">PT +351</option>
                                <option value="+353" data-flag="https://flagcdn.com/16x12/ie.png">IE +353</option>
                                <option value="+352" data-flag="https://flagcdn.com/16x12/lu.png">LU +352</option>
                                <option value="+32" data-flag="https://flagcdn.com/16x12/be.png">BE +32</option>
                            </select>
                            <div class="form-floating flex-grow-1">
                                <input type="tel" class="form-control" id="phoneNumber" placeholder=" ">
                                <label for="phoneNumber">Phone Number</label>
                            </div>
                        </div>
                        <div class="invalid-feedback" id="phoneNumberError"></div>
                        <div class="form-text">Enter your phone number without country code</div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg" id="saveProfileBtn" disabled>
                            <span class="btn-text">Continue</span>
                            <span class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- PROFILE PICTURE FORM -->
            <div id="profilePictureForm" class="auth-form d-none">
                <div class="text-center mb-4">
                    <h3 class="auth-title">Add Profile Picture</h3>
                    <p class="text-muted">This will be displayed on your profile</p>
                </div>

                <div class="text-center">
                    <div class="profile-picture-preview">
                        <div class="profile-picture-placeholder">
                            <i class="bi bi-person-circle" style="font-size: 5rem;"></i>
                        </div>
                    </div>
                    <label for="profilePictureInput" class="btn btn-outline-primary mt-3">
                        <i class="bi bi-upload me-2"></i>Upload Photo
                    </label>
                    <input type="file" id="profilePictureInput" class="d-none" accept="image/*">
                    <div class="invalid-feedback" id="profilePictureError"></div>
                </div>

                <div class="d-grid mt-4">
                    <button type="button" class="btn btn-primary btn-lg" id="uploadProfileBtn">
                        <span class="btn-text">Continue</span>
                        <span class="spinner-border spinner-border-sm d-none"></span>
                    </button>
                </div>

                <div class="text-center mt-3">
                    <a href="#" class="skip-profile-link">Skip for now</a>
                </div>
            </div>

            <!-- WELCOME FORM -->
            <div id="welcomeForm" class="auth-form d-none">
                <div class="text-center mb-4">
                    <div class="welcome-icon mb-3">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem;"></i>
                    </div>
                    <h3 class="auth-title">Welcome, your account is all set up!</h3>
                    <p class="text-muted">Thank you for creating an account. As promised, here is your copy of Beyond the Radar, our exclusive free eBook.</p>
                </div>

                <div class="text-center mb-4">
                    <img src="<?= base_url('images/product/empowering-01.svg') ?>" alt="Empowering">
                </div>

                <div class="d-grid">
                    <a href="#" class="btn btn-primary btn-lg" id="downloadEbookBtn">
                        <i class="bi bi-download me-2"></i>Download E-Book &nbsp; <span class="spinner-border spinner-border-sm d-none"></span>
                    </a>
                </div>

                <div class="text-center mt-3">
                    <a href="#" class="skip-download-link">Skip for now</a>
                </div>
            </div>

            <!-- Footer -->
            <div class="auth-footer">
                <p class="mb-0">By signing up, you are agreeing to our </p>
                <p class="grey text-center sc-mt-0"><a href="<?= base_url('terms-and-conditions') ?>" target="_blank" />Terms of Use</a> | <a href="<?= base_url('privacy-policy') ?>" target="_blank" />Privacy Policy</a></p>
            </div>
        </div>
    </div>
</div>

<?= $this->include('front/footer-login') ?>
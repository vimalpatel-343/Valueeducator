<!-- Redesigned Login/Signup Modal (Premium UI) -->
<div class="auth-modal modal fade" id="authModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header border-0 position-relative">
                <!-- <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button> -->
                <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close">Close<img src="images/cancel.svg"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body px-4 pb-4 position-relative">

                <!-- Loader -->
                <div class="auth-loader d-none justify-content-center align-items-center position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-75">
                    <div class="spinner-border text-primary" role="status"></div>
                </div>

                <!-- LOGIN FORM -->
                <div id="loginForm" class="auth-form">
                    <div class="text-center mb-4">
                        <h3 class="auth-title font-lg-24-bold font-16-bold">Login to Your Account</h3>
                        
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

                        <div class="text-center mt-3">
                            <p class="mb-0">Don't have an account? <a href="#" class="auth-switch-link" data-target="signupForm">Sign Up</a></p>
                        </div>
                    </form>
                </div>

                <!-- LOGIN OTP FORM -->
                <div id="loginOtpForm" class="auth-form d-none">
                    <div class="text-center mb-4">
                        <h3 class="auth-title">Enter Verification Code</h3>
                        <p class="auth-subtext">We've sent a 6-digit code to your email</p>
                    </div>

                    <form id="loginOtpFormElement">
                        <div class="mb-4">
                            <div class="otp-input-group d-flex justify-content-center gap-2">
                                <input type="text" class="form-control otp-input" maxlength="1" data-index="0">
                                <input type="text" class="form-control otp-input" maxlength="1" data-index="1">
                                <input type="text" class="form-control otp-input" maxlength="1" data-index="2">
                                <input type="text" class="form-control otp-input" maxlength="1" data-index="3">
                                <input type="text" class="form-control otp-input" maxlength="1" data-index="4">
                                <input type="text" class="form-control otp-input" maxlength="1" data-index="5">
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
                            <p>Didn’t receive the code? <a href="#" class="resend-otp-link" data-form="login">Resend OTP</a></p>
                            <p class="text-success small mt-2 d-none" id="loginOtpSuccess"></p>
                        </div>
                    </form>
                </div>

                <!-- SIGNUP FORM -->
                <div id="signupForm" class="auth-form d-none">
                    <div class="text-center mb-4">
                        <h3 class="auth-title">Create Your Account</h3>
                        <p class="auth-subtext">Enter your email to get started</p>
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

                        <div class="text-center mt-3">
                            <p>Already have an account? <a href="#" class="auth-switch-link" data-target="loginForm">Log In</a></p>
                        </div>
                    </form>
                </div>

                <!-- SIGNUP OTP FORM -->
                <div id="signupOtpForm" class="auth-form d-none">
                    <div class="text-center mb-4">
                        <h3 class="auth-title">Enter Verification Code</h3>
                        <p class="auth-subtext">We've sent a 6-digit code to your email</p>
                    </div>

                    <form id="signupOtpFormElement">
                        <div class="mb-4">
                            <div class="otp-input-group d-flex justify-content-center gap-2">
                                <input type="text" class="form-control otp-input" maxlength="1" data-index="0">
                                <input type="text" class="form-control otp-input" maxlength="1" data-index="1">
                                <input type="text" class="form-control otp-input" maxlength="1" data-index="2">
                                <input type="text" class="form-control otp-input" maxlength="1" data-index="3">
                                <input type="text" class="form-control otp-input" maxlength="1" data-index="4">
                                <input type="text" class="form-control otp-input" maxlength="1" data-index="5">
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
                            <p>Didn’t receive the code? <a href="#" class="resend-otp-link" data-form="signup">Resend OTP</a></p>
                            <p class="text-success small mt-2 d-none" id="signupOtpSuccess"></p>
                        </div>
                    </form>
                </div>

                <!-- PROFILE FORM -->
                <div id="profileForm" class="auth-form d-none">
                    <div class="text-center mb-4">
                        <h3 class="auth-title">Complete Your Profile</h3>
                        <p class="auth-subtext">Tell us a bit about yourself</p>
                    </div>

                    <form id="profileFormElement">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control" id="firstName" placeholder=" " required>
                                    <label for="firstName">First Name</label>
                                </div>
                                <div class="invalid-feedback" id="firstNameError"></div>
                            </div>
                            <div class="col-md-6">
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
                                    <option value="+1" data-country="US">🇺🇸 +1</option>
                                    <option value="+44" data-country="GB">🇬🇧 +44</option>
                                    <option value="+91" data-country="IN" selected>🇮🇳 +91</option>
                                    <option value="+61" data-country="AU">🇦🇺 +61</option>
                                    <option value="+86" data-country="CN">🇨🇳 +86</option>
                                    <option value="+81" data-country="JP">🇯🇵 +81</option>
                                    <option value="+49" data-country="DE">🇩🇪 +49</option>
                                    <option value="+33" data-country="FR">🇫🇷 +33</option>
                                    <option value="+7" data-country="RU">🇷🇺 +7</option>
                                    <option value="+82" data-country="KR">🇰🇷 +82</option>
                                    <option value="+39" data-country="IT">🇮🇹 +39</option>
                                    <option value="+34" data-country="ES">🇪🇸 +34</option>
                                    <option value="+31" data-country="NL">🇳🇱 +31</option>
                                    <option value="+41" data-country="CH">🇨🇭 +41</option>
                                    <option value="+43" data-country="AT">🇦🇹 +43</option>
                                    <option value="+45" data-country="DK">🇩🇰 +45</option>
                                    <option value="+46" data-country="SE">🇸🇪 +46</option>
                                    <option value="+47" data-country="NO">🇳🇴 +47</option>
                                    <option value="+358" data-country="FI">🇫🇮 +358</option>
                                    <option value="+351" data-country="PT">🇵🇹 +351</option>
                                    <option value="+353" data-country="IE">🇮🇪 +353</option>
                                    <option value="+352" data-country="LU">🇱🇺 +352</option>
                                    <option value="+32" data-country="BE">🇧🇪 +32</option>
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
                        <p class="auth-subtext">This will be displayed on your profile</p>
                    </div>

                    <div class="text-center">
                        <div class="profile-picture-preview">
                            <div class="profile-picture-placeholder">
                                <i class="bi bi-person-circle"></i>
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
                            <i class="bi bi-check-circle-fill text-success"></i>
                        </div>
                        <h3 class="auth-title">Welcome to Value Educator!</h3>
                        <p class="auth-subtext">Your account has been created successfully</p>
                    </div>

                    <div class="text-center mb-4">
                        <p class="mb-0">As promised, here is your copy of our exclusive e-book:</p>
                        <h5 class="mt-2">"Beyond the Radar"</h5>
                    </div>

                    <div class="d-grid">
                        <a href="#" class="btn btn-primary btn-lg" id="downloadEbookBtn">
                            <i class="bi bi-download me-2"></i>Download E-Book
                        </a>
                    </div>

                    <div class="text-center mt-3">
                        <a href="#" class="skip-download-link">Skip for now</a>
                    </div>
                </div>

            </div>
            <!-- Modal Footer -->
            <div class="modal-footer border-0 text-center d-block pb-3">
                <p class="text-muted small mb-0">By continuing, you agree to our <a href="<?= base_url('terms-and-conditions') ?>" target="_blank">Terms of Service</a> and <a href="<?= base_url('privacy-policy') ?>" target="_blank">Privacy Policy</a></p>
            </div>
        </div>
    </div>
</div>
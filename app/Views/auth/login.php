<!DOCTYPE html>
<!-- =========================================================
* Sneat - Bootstrap 5 HTML Admin Template - Pro | v1.0.0
============================================================== -->
<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="<?= base_url('assets/') ?>"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Login - Value Educator Admin</title>

    <meta name="description" content="Value Educator Admin Panel" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/img/favicon/favicon.ico') ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@700;800&display=swap"
      rel="stylesheet"
    />

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/core.css') ?>" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/theme-default.css') ?>" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url('assets/css/demo.css') ?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/vendor/css/pages/page-auth.css') ?>" />
    
    <!-- Custom CSS for modern login page -->
    <style>
      :root {
        --primary: #0052cc;
        --primary-dark: #0747a6;
        --secondary: #de350b;
        --accent: #6554c0;
        --light: #f4f5f7;
        --dark: #172b4d;
        --text-secondary: #6b778c;
        --border-color: #dfe1e6;
        --gradient: linear-gradient(135deg, var(--primary), var(--primary-dark));
        --gradient-secondary: linear-gradient(135deg, var(--secondary), #c23a21);
      }
      
      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }
      
      body {
        font-family: 'Poppins', sans-serif;
        background: url('https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80') center/cover no-repeat fixed;
        min-height: 100vh;
        overflow-x: hidden;
        color: var(--dark);
        position: relative;
      }
      
      body::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1;
      }
      
      .login-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
        padding: 20px;
      }
      
      .bg-shapes {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
        overflow: hidden;
      }
      
      .shape {
        position: absolute;
        border-radius: 50%;
        filter: blur(40px);
        opacity: 0.6;
      }
      
      .shape-1 {
        width: 300px;
        height: 300px;
        background: rgba(0, 82, 204, 0.2);
        top: -100px;
        left: -100px;
      }
      
      .shape-2 {
        width: 400px;
        height: 400px;
        background: rgba(222, 53, 11, 0.15);
        bottom: -150px;
        right: -150px;
      }
      
      .shape-3 {
        width: 200px;
        height: 200px;
        background: rgba(101, 84, 192, 0.1);
        top: 50%;
        left: 10%;
      }
      
      .login-wrapper {
        display: flex;
        width: 90%;
        max-width: 1200px;
        height: auto;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        z-index: 2;
        backdrop-filter: blur(10px);
      }
      
      .illustration {
        flex: 1;
        background: var(--gradient);
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 3rem;
        color: white;
        overflow: hidden;
      }
      
      .illustration::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80') center/cover;
        opacity: 0.2;
        z-index: -1;
      }
      
      .illustration-content {
        text-align: center;
        z-index: 1;
      }
      
      .illustration h1 {
        font-family: 'Montserrat', sans-serif;
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1.5rem;
        line-height: 1.2;
        text-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        color: #FFFFFF;
      }
      
      .illustration p {
        font-size: 1.2rem;
        max-width: 80%;
        margin: 0 auto 2rem;
        line-height: 1.6;
      }
      
      .features {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-top: 2rem;
      }
      
      .feature {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
      }
      
      .feature i {
        font-size: 2rem;
        margin-bottom: 0.5rem;
      }
      
      .feature span {
        font-size: 0.9rem;
      }
      
      .login-form {
        flex: 1;
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: white;
      }
      
      .logo {
        text-align: center;
        margin-bottom: 2rem;
      }
      
      .logo img {
        height: 80px;
        margin-bottom: 1rem;
        border-radius: 8px;
      }
      
      .logo h2 {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        color: var(--primary);
        font-size: 1.8rem;
        margin-top: 0.5rem;
      }
      
      .welcome-text {
        text-align: center;
        margin-bottom: 2rem;
      }
      
      .welcome-text h3 {
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--dark);
      }
      
      .welcome-text p {
        color: var(--text-secondary);
      }
      
      .form-group {
        margin-bottom: 1.5rem;
      }
      
      .form-group label {
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: var(--dark);
      }
      
      .form-control {
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 1rem;
        transition: all 0.3s;
      }
      
      .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(0, 82, 204, 0.1);
      }
      
      .input-group {
        position: relative;
      }
      
      .input-group-text {
        background: transparent;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        cursor: pointer;
      }
      
      .form-check {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
      }
      
      .form-check-input {
        margin-right: 0.5rem;
      }
      
      .btn-login {
        background: var(--gradient);
        border: none;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        padding: 0.75rem;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(0, 82, 204, 0.3);
      }
      
      .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 7px 20px rgba(0, 82, 204, 0.4);
      }
      
      .alert {
        border-radius: 10px;
        padding: 0.75rem 1rem;
        margin-bottom: 1.5rem;
      }
      
      .floating {
        animation: floating 3s ease-in-out infinite;
      }
      
      @keyframes floating {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
      }
      
      .fade-in {
        animation: fadeIn 1s ease-in;
      }
      
      @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
      }
      
      .particles {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 0;
      }
      
      .particle {
        position: absolute;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
      }
      
      @media (max-width: 992px) {
        .login-wrapper {
          flex-direction: column;
          height: auto;
          width: 95%;
          max-width: 500px;
        }
        
        .illustration {
          display: none;
        }
        
        .login-form {
          padding: 2rem;
        }
      }
    </style>
    
    <!-- Helpers -->
    <script src="<?= base_url('assets/vendor/js/helpers.js') ?>"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= base_url('assets/js/config.js') ?>"></script>
  </head>

  <body>
    <!-- Content -->
    <div class="login-container">
      <!-- Background Shapes -->
      <div class="bg-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
      </div>
      
      <!-- Particles Effect -->
      <div class="particles" id="particles"></div>
      
      <!-- Login Wrapper -->
      <div class="login-wrapper fade-in">
        <!-- Left Side - Illustration -->
        <div class="illustration">
          <div class="illustration-content">
            <h1 class="floating">Value Educator</h1>
            <p>Admin Panel</p>
            <p>Manage your investment advisory platform with ease. Access portfolio data, manage users, and update content all in one place.</p>
            
            <div class="features">
              <div class="feature">
                <i class='bx bx-line-chart'></i>
                <span>Portfolio Management</span>
              </div>
              <div class="feature">
                <i class='bx bx-user-voice'></i>
                <span>User Management</span>
              </div>
              <div class="feature">
                <i class='bx bx-edit-alt'></i>
                <span>Content Management</span>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Right Side - Login Form -->
        <div class="login-form">
          <div class="logo">
            <img src="<?= base_url('assets/img/logo.png') ?>" alt="Value Educator Logo">
          </div>
          
          <div class="welcome-text">
            <h3>Welcome Back! 👋</h3>
            <p>Please sign-in to your admin account</p>
          </div>

          <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger" role="alert">
            <?= session()->getFlashdata('error') ?>
          </div>
          <?php endif; ?>

          <form id="formAuthentication" action="<?= base_url('auth/login') ?>" method="POST">
            <!-- Add CSRF token -->
            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />
            
            <div class="form-group">
              <label for="email">Email or Username</label>
              <input
                type="text"
                class="form-control"
                id="email"
                name="username"
                placeholder="Enter your email or username"
                autofocus
              />
            </div>
            
            <div class="form-group">
              <label for="password">Password</label>
              <div class="input-group">
                <input
                  type="password"
                  id="password"
                  class="form-control"
                  name="password"
                  placeholder="Enter your password"
                />
                <span class="input-group-text" id="togglePassword">
                  <i class="bx bx-hide"></i>
                </span>
              </div>
            </div>
            
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="remember-me" />
              <label class="form-check-label" for="remember-me">Remember Me</label>
            </div>
            
            <button class="btn btn-login w-100" type="submit">Sign In</button>
          </form>
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="<?= base_url('assets/vendor/libs/jquery/jquery.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/popper/popper.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/js/bootstrap.js') ?>"></script>
    <script src="<?= base_url('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>

    <script src="<?= base_url('assets/vendor/js/menu.js') ?>"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="<?= base_url('assets/js/main.js') ?>"></script>

    <!-- Page JS -->
    <script>
        $(document).ready(function() {
          // Create particles effect
          function createParticles() {
              const particlesContainer = document.getElementById('particles');
              const particlesCount = 50;
              
              for (let i = 0; i < particlesCount; i++) {
                  const particle = document.createElement('div');
                  particle.classList.add('particle');
                  
                  // Random size between 2px and 6px
                  const size = Math.random() * 4 + 2;
                  particle.style.width = `${size}px`;
                  particle.style.height = `${size}px`;
                  
                  // Random position
                  particle.style.left = `${Math.random() * 100}%`;
                  particle.style.top = `${Math.random() * 100}%`;
                  
                  // Random opacity
                  particle.style.opacity = Math.random() * 0.5 + 0.1;
                  
                  particlesContainer.appendChild(particle);
              }
          }
          
          createParticles();
          
          // Form submission with jQuery
          $('#formAuthentication').on('submit', function(e) {
              e.preventDefault();
              
              var form = $(this);
              var url = form.attr('action');
              var method = form.attr('method');
              
              // Get the current CSRF token
              var csrfToken = $('input[name="csrf_test_name"]').val();
              
              $.ajax({
                  url: url,
                  type: method,
                  data: form.serialize(),
                  dataType: 'json',
                  success: function(response) {
                      if (response.success) {
                          window.location.href = response.redirect;
                      } else {
                          // Show error message
                          if ($('#authError').length === 0) {
                              $('.login-form').prepend('<div id="authError" class="alert alert-danger" role="alert">' + response.message + '</div>');
                          } else {
                              $('#authError').html(response.message);
                          }
                      }
                  },
                  error: function(xhr, status, error) {
                      // If we get a 403 error, it's likely a CSRF issue
                      if (xhr.status === 403) {
                          // Refresh the page to get a new CSRF token
                          location.reload();
                      } else {
                          // Show error message
                          if ($('#authError').length === 0) {
                              $('.login-form').prepend('<div id="authError" class="alert alert-danger" role="alert">An error occurred. Please try again.</div>');
                          } else {
                              $('#authError').html('An error occurred. Please try again.');
                          }
                      }
                  }
              });
          });
          
          // Toggle password visibility with jQuery
          $('#togglePassword').on('click', function() {
              var passwordInput = $('#password');
              var icon = $(this).find('i');
              
              if (passwordInput.attr('type') === 'password') {
                  passwordInput.attr('type', 'text');
                  icon.removeClass('bx-hide');
                  icon.addClass('bx-show');
              } else {
                  passwordInput.attr('type', 'password');
                  icon.removeClass('bx-show');
                  icon.addClass('bx-hide');
              }
          });
      });
    </script>
  </body>
</html>
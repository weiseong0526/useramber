<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login / Register / Forgot Password</title>
<!-- External CSS -->
  <link rel="stylesheet" href="style.css">

  <!-- FontAwesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="wrapper">
      <!-- Left side image -->
  <div class="image-box">
    <img src="https://amber-7q7.pages.dev/logo.jpg" alt="Side Image">
      </div>
  
      <!-- Right side form -->
      <div class="container">
        <div class="form-box">
          <form id="loginForm">
            <h2>Login</h2>
            <div class="input-group">
              <i class="fa fa-envelope"></i>
              <input type="email" id="loginEmail" placeholder="Email" required>
            </div>
            <div class="input-group">
              <i class="fa fa-lock"></i>
              <input type="password" id="loginPassword" placeholder="Password" required>
              <span class="toggle-password" onclick="togglePassword('loginPassword', this)">
                <i class="fa fa-eye"></i>
              </span>
            </div>

            <div class="options">
              <label><input type="checkbox" id="rememberMe"> Remember me</label>
              <a href="#" id="forgotPasswordLink">Forgot password?</a>
            </div>
            <button type="submit">Login</button>
            <span class="link">Don't have an account? <a href="register.php">Register</a></span>

            <div id="g_id_onload"
       data-client_id="YOUR_GOOGLE_CLIENT_ID.apps.googleusercontent.com"
       data-context="signin"
       data-ux_mode="popup"
       data-callback="handleGoogleResponse"
       data-auto_prompt="false"></div>

            <div class="g_id_signin" data-type="standard" data-text="continue_with"></div>
            <script src="https://accounts.google.com/gsi/client" async defer></script>

            <button type="button" class="social-btn facebook-btn" onclick="facebookLogin()">
              <i class="fab fa-facebook-f"></i> Continue with Facebook
            </button>
          </form>

          <form id="forgotForm" class="hidden">
            <h2>Reset Password</h2>
            <div class="input-group">
              <i class="fa fa-envelope"></i>
              <input type="email" placeholder="Enter your email" required>
            </div>
            <button type="submit">Send Reset Link</button>
            <span class="link"><a href="login.php">Back to Login</a></span>
          </form>
        </div>
      </div>
    </div>
    <script src="login.js"></script>
  <!-- Facebook SDK -->
<script async defer crossorigin="anonymous" 
        src="https://connect.facebook.net/en_US/sdk.js"></script>
  </body> 
  </html>

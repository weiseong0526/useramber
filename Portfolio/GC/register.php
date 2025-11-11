<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
  <div class="wrapper">
    <div class="image-box">
      <img src="https://amber-7q7.pages.dev/logo.jpg" alt="Side Image">
    </div>

    <div class="container">
      <div class="form-box">
        <form id="registerForm">
          <h2>Register</h2>
          <div class="input-group">
            <i class="fa fa-user"></i>
            <input type="text" id="registerUsername" placeholder="Username" required>
          </div>
          <div class="input-group">
            <i class="fa fa-envelope"></i>
            <input type="email" id="registerEmail" placeholder="Email" required>
          </div>
          <div class="input-group">
            <i class="fa fa-lock"></i>
            <input type="password" id="registerPassword" placeholder="Password" required>
            <span class="toggle-password" onclick="togglePassword('registerPassword', this)">
              <i class="fa fa-eye"></i>
            </span>
          </div>
          <div class="input-group">
            <i class="fa fa-lock"></i>
            <input type="password" id="registerConfirmPassword" placeholder="Confirm Password" required>
            <span class="toggle-password" onclick="togglePassword('registerConfirmPassword', this)">
              <i class="fa fa-eye"></i>
            </span>
          </div>

          <div class="password-match-error" id="passwordMatchError" style="display: none;">
            <i class="fa fa-exclamation-circle"></i>
            <span>Password not match</span>
          </div>

          <div class="password-requirements" id="passwordRequirements">
            <p class="requirements-title">Password Requirements:</p>
            <ul class="requirements-list">
              <li id="req-length" class="requirement-item">
                <i class="fa fa-circle requirement-icon"></i> <span>At least 8 characters</span>
              </li>
              <li id="req-uppercase" class="requirement-item">
                <i class="fa fa-circle requirement-icon"></i> <span>One uppercase letter</span>
              </li>
              <li id="req-lowercase" class="requirement-item">
                <i class="fa fa-circle requirement-icon"></i> <span>One lowercase letter</span>
              </li>
              <li id="req-number" class="requirement-item">
                <i class="fa fa-circle requirement-icon"></i> <span>One number</span>
              </li>
              <li id="req-special" class="requirement-item">
                <i class="fa fa-circle requirement-icon"></i> <span>One special character (!@#$%^&*)</span>
              </li>
            </ul>
          </div>

          <button type="submit" id="registerBtn" disabled>Register</button>
          <span class="link">Already have an account? <a href="login.php">Back to Login</a></span>
        </form>
      </div>
    </div>
  </div>

  <script src="register.js"></script>
</body>
</html>


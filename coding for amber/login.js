function sendOTP() {
  const phone = document.getElementById("phoneNumber").value;
  if (!phone) {
    alert("❌ Please enter your phone number first!");
    return;
  }
  alert("📲 OTP has been sent to " + phone);
}

// Switch forms
function showForm(formId) {
  document.getElementById("loginForm").classList.add("hidden");
  document.getElementById("registerForm").classList.add("hidden");
  document.getElementById("forgotForm").classList.add("hidden");
  document.getElementById(formId).classList.remove("hidden");
}

function togglePassword(inputId, btn) {
  const input = document.getElementById(inputId);
  const icon = btn.querySelector('i');
  if (!input) return;
  if (input.type === 'password') {
    input.type = 'text';
    if (icon) { icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
  } else {
    input.type = 'password';
    if (icon) { icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
  }
}

// ✅ Auto-fill + Auto-login only if saved before
window.onload = function () {
  const savedEmail = localStorage.getItem("email");
  const savedPassword = localStorage.getItem("password");

  if (savedEmail && savedPassword) {
    // Fill values + keep checkbox ticked
    document.getElementById("loginEmail").value = savedEmail;
    document.getElementById("loginPassword").value = savedPassword;
    document.getElementById("rememberMe").checked = true;

    // ⚡ Auto-login directly
    autoLogin(savedEmail, savedPassword);
  } else {
    // If nothing saved → clear form + checkbox
    document.getElementById("loginEmail").value = "";
    document.getElementById("loginPassword").value = "";
    document.getElementById("rememberMe").checked = false;
  }
};

// ✅ Handle normal login
document.getElementById("loginForm").addEventListener("submit", function (e) {
  e.preventDefault();

  const email = document.getElementById("loginEmail").value;
  const password = document.getElementById("loginPassword").value;
  const remember = document.getElementById("rememberMe").checked;

  if (remember) {
    // Save login details ONLY if checkbox is ticked
    localStorage.setItem("email", email);
    localStorage.setItem("password", password);
  } else {
    // Clear saved login if checkbox not ticked
    localStorage.removeItem("email");
    localStorage.removeItem("password");
  }

  loginSuccess(email);
});

// ✅ Auto-login function
function autoLogin(email, password) {
  console.log("Auto-logged in with:", email, password);
  loginSuccess(email);
}

// ✅ Common success action
function loginSuccess(email) {
  alert("✅ Logged in successfully as " + email + "!");
  // Redirect to home page
  window.location.href = "home.html";
}

// ✅ Register form (demo)
document.getElementById("registerForm").addEventListener("submit", function(e) {
  e.preventDefault();
  alert("✅ Account registered!");
});

// ✅ Forgot form (demo)
document.getElementById("forgotForm").addEventListener("submit", function(e) {
  e.preventDefault();
  alert("📧 Password reset link sent to your email!");
});

function handleGoogleResponse(response) {
  console.log("Google JWT Token: ", response.credential);
  alert("✅ Logged in with Google!");
  // Redirect to home page
  window.location.href = "home.html";
}

// Facebook SDK init 
window.fbAsyncInit = function() 
{ FB.init({ appId : 'YOUR_FACEBOOK_APP_ID',
 cookie : true,
  xfbml : true,
   version : 'v19.0'
 }); 
}; 

function facebookLogin() 
{ FB.login(function(response) { 
    if (response.authResponse) { 
        console.log('Facebook login success:', response);
         alert("✅ Logged in with Facebook!");
         // Redirect to home page
         window.location.href = "home.html";
         } else { 
            alert("❌ Facebook login cancelled!");
          } 
        }, {scope: 'public_profile,email'}); }

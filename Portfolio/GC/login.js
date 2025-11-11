function togglePassword(inputId, btn) {
  const input = document.getElementById(inputId);
  const icon = btn?.querySelector('i');
  if (!input) return;
  if (input.type === 'password') {
    input.type = 'text';
    if (icon) {
      icon.classList.remove('fa-eye');
      icon.classList.add('fa-eye-slash');
    }
  } else {
    input.type = 'password';
    if (icon) {
      icon.classList.remove('fa-eye-slash');
      icon.classList.add('fa-eye');
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  const emailInput = document.getElementById('loginEmail');
  const passwordInput = document.getElementById('loginPassword');
  const rememberMe = document.getElementById('rememberMe');
  const loginForm = document.getElementById('loginForm');
  const forgotForm = document.getElementById('forgotForm');
  const forgotLink = document.getElementById('forgotPasswordLink');
  const backToLoginLink = forgotForm?.querySelector('.link a');

  const savedEmail = localStorage.getItem('email');
  const savedPassword = localStorage.getItem('password');

  if (savedEmail && savedPassword && emailInput && passwordInput && rememberMe) {
    emailInput.value = savedEmail;
    passwordInput.value = savedPassword;
    rememberMe.checked = true;
    autoLogin(savedEmail, savedPassword);
  } else {
    if (emailInput) emailInput.value = '';
    if (passwordInput) passwordInput.value = '';
    if (rememberMe) rememberMe.checked = false;
  }

  if (loginForm) {
    loginForm.addEventListener('submit', handleLoginSubmit);
  }

  if (forgotForm) {
    forgotForm.addEventListener('submit', function (e) {
      e.preventDefault();
      alert('📧 Password reset link sent to your email!');
    });
  }

  if (forgotLink && forgotForm && loginForm) {
    forgotLink.addEventListener('click', (e) => {
      e.preventDefault();
      loginForm.classList.add('hidden');
      forgotForm.classList.remove('hidden');
    });
  }

  if (backToLoginLink && forgotForm && loginForm) {
    backToLoginLink.addEventListener('click', (e) => {
      e.preventDefault();
      forgotForm.classList.add('hidden');
      loginForm.classList.remove('hidden');
    });
  }
});

function handleLoginSubmit(e) {
  e.preventDefault();

  const emailInput = document.getElementById('loginEmail');
  const passwordInput = document.getElementById('loginPassword');
  const rememberMe = document.getElementById('rememberMe');

  if (!emailInput || !passwordInput) {
    alert('❌ Missing email or password field on the page.');
    return;
  }

  const email = emailInput.value.trim();
  const password = passwordInput.value;
  const remember = rememberMe?.checked ?? false;

  const submitBtn = this.querySelector('button[type="submit"]');
  const originalText = submitBtn ? submitBtn.textContent : 'Login';
  if (submitBtn) {
    submitBtn.disabled = true;
    submitBtn.textContent = 'Logging in...';
  }

  const formData = new FormData();
  formData.append('email', email);
  formData.append('password', password);
  if (remember) {
    formData.append('remember', '1');
  }

  fetch('process_login.php', {
    method: 'POST',
    body: formData,
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then((data) => {
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
      }

      if (data.success) {
        if (remember) {
          localStorage.setItem('email', email);
          localStorage.setItem('password', password);
        } else {
          localStorage.removeItem('email');
          localStorage.removeItem('password');
        }

        loginSuccess(data.data.email, data.data.username);
      } else {
        alert('❌ ' + (data.message || 'Login failed. Please check your credentials.'));
        if (data.error) {
          console.error('Login error:', data.error);
        }
      }
    })
    .catch((error) => {
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
      }
      console.error('Login error:', error);
      alert("❌ Login failed. Please check:\n1. Database is running\n2. Database 'amberss15' exists\n3. Users table exists\n\nCheck browser console (F12) for details.");
    });
}

function autoLogin(email, password) {
  const formData = new FormData();
  formData.append('email', email);
  formData.append('password', password);
  formData.append('remember', '1');

  fetch('process_login.php', {
    method: 'POST',
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        loginSuccess(data.data.email, data.data.username);
      } else {
        localStorage.removeItem('email');
        localStorage.removeItem('password');
        const emailInput = document.getElementById('loginEmail');
        const passwordInput = document.getElementById('loginPassword');
        const rememberMe = document.getElementById('rememberMe');
        if (emailInput) emailInput.value = '';
        if (passwordInput) passwordInput.value = '';
        if (rememberMe) rememberMe.checked = false;
      }
    })
    .catch((error) => {
      console.error('Auto-login error:', error);
      localStorage.removeItem('email');
      localStorage.removeItem('password');
    });
}

function loginSuccess(email, username) {
  alert('✅ Logged in successfully as ' + (username || email) + '!');
  window.location.href = 'home.html';
}

function handleGoogleResponse(response) {
  console.log('Google JWT Token: ', response.credential);
  alert('✅ Logged in with Google!');
  window.location.href = 'home.html';
}

window.fbAsyncInit = function () {
  FB.init({
    appId: 'YOUR_FACEBOOK_APP_ID',
    cookie: true,
    xfbml: true,
    version: 'v19.0',
  });
};

function facebookLogin() {
  FB.login(
    function (response) {
      if (response.authResponse) {
        console.log('Facebook login success:', response);
        alert('✅ Logged in with Facebook!');
        window.location.href = 'home.html';
      } else {
        alert('❌ Facebook login cancelled!');
      }
    },
    { scope: 'public_profile,email' }
  );
}


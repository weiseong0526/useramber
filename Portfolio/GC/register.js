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
  setupRegisterFormValidation();
  checkRegisterFormCompletion();

  const passwordInput = document.getElementById('registerPassword');
  if (passwordInput) {
    passwordInput.addEventListener('input', validatePasswordRequirements);
    passwordInput.addEventListener('input', validatePasswordMatch);
    passwordInput.addEventListener('focus', () => {
      const requirements = document.getElementById('passwordRequirements');
      if (requirements) {
        requirements.style.display = 'block';
      }
    });
  }

  const confirmPasswordInput = document.getElementById('registerConfirmPassword');
  if (confirmPasswordInput) {
    confirmPasswordInput.addEventListener('input', validatePasswordMatch);
  }

  const registerForm = document.getElementById('registerForm');
  if (registerForm) {
    registerForm.addEventListener('submit', handleRegisterSubmit);
  }
});

function setupRegisterFormValidation() {
  const registerInputs = ['registerUsername', 'registerEmail', 'registerPassword', 'registerConfirmPassword'];

  registerInputs.forEach((inputId) => {
    const input = document.getElementById(inputId);
    if (input) {
      input.addEventListener('input', checkRegisterFormCompletion);
      input.addEventListener('change', checkRegisterFormCompletion);
    }
  });
}

function checkRegisterFormCompletion() {
  const username = document.getElementById('registerUsername')?.value.trim() || '';
  const email = document.getElementById('registerEmail')?.value.trim() || '';
  const password = document.getElementById('registerPassword')?.value || '';
  const confirmPassword = document.getElementById('registerConfirmPassword')?.value || '';

  const registerBtn = document.getElementById('registerBtn');
  if (!registerBtn) return;

  const allFieldsFilled = username && email && password && confirmPassword;
  const passwordsMatch = password === confirmPassword && password.length > 0;

  if (allFieldsFilled && passwordsMatch) {
    registerBtn.disabled = false;
    registerBtn.style.opacity = '1';
    registerBtn.style.cursor = 'pointer';
  } else {
    registerBtn.disabled = true;
    registerBtn.style.opacity = '0.6';
    registerBtn.style.cursor = 'not-allowed';
  }
}

function validatePasswordRequirements() {
  const password = document.getElementById('registerPassword')?.value || '';
  const checks = {
    'req-length': password.length >= 8,
    'req-uppercase': /[A-Z]/.test(password),
    'req-lowercase': /[a-z]/.test(password),
    'req-number': /[0-9]/.test(password),
    'req-special': /[!@#$%^&*]/.test(password),
  };

  Object.keys(checks).forEach((reqId) => {
    const reqItem = document.getElementById(reqId);
    if (reqItem) {
      if (checks[reqId]) {
        reqItem.classList.add('valid');
      } else {
        reqItem.classList.remove('valid');
      }
    }
  });
}

function validatePasswordMatch() {
  const password = document.getElementById('registerPassword')?.value || '';
  const confirmPassword = document.getElementById('registerConfirmPassword')?.value || '';
  const errorMessage = document.getElementById('passwordMatchError');
  const confirmPasswordInput = document.getElementById('registerConfirmPassword');

  if (!errorMessage || !confirmPasswordInput) return;

  if (confirmPassword.length > 0 && password !== confirmPassword) {
    errorMessage.style.display = 'flex';
    confirmPasswordInput.style.borderColor = '#f66';
    confirmPasswordInput.style.backgroundColor = '#fff5f5';
  } else {
    errorMessage.style.display = 'none';
    if (confirmPassword.length > 0 && password === confirmPassword) {
      confirmPasswordInput.style.borderColor = '#28a745';
      confirmPasswordInput.style.backgroundColor = '#f0fff4';
    } else {
      confirmPasswordInput.style.borderColor = '#e0e0e0';
      confirmPasswordInput.style.backgroundColor = '#fafafa';
    }
  }

  checkRegisterFormCompletion();
}

function handleRegisterSubmit(e) {
  e.preventDefault();

  const username = document.getElementById('registerUsername')?.value.trim() || '';
  const email = document.getElementById('registerEmail')?.value.trim() || '';
  const password = document.getElementById('registerPassword')?.value || '';
  const confirmPassword = document.getElementById('registerConfirmPassword')?.value || '';

  if (!username || !email || !password || !confirmPassword) {
    alert('❌ Please fill in all required fields!');
    return;
  }

  if (password !== confirmPassword) {
    alert('❌ Passwords do not match!');
    return;
  }

  if (password.length < 8 || !/[A-Z]/.test(password) || !/[a-z]/.test(password) || !/[0-9]/.test(password) || !/[!@#$%^&*]/.test(password)) {
    alert('❌ Password does not meet the strength requirements!');
    return;
  }

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(email)) {
    alert('❌ Please enter a valid email address!');
    return;
  }

  const submitBtn = e.target.querySelector('button[type="submit"]');
  const originalText = submitBtn ? submitBtn.textContent : 'Register';
  if (submitBtn) {
    submitBtn.disabled = true;
    submitBtn.textContent = 'Registering...';
  }

  const formData = new FormData();
  formData.append('username', username);
  formData.append('email', email);
  formData.append('password', password);

  fetch('register_action.php', {
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
        alert('✅ ' + data.message);
        clearRegisterForm();
        window.location.href = 'login.php';
      } else {
        alert('❌ ' + (data.message || 'Registration failed. Please try again.'));
        if (data.error) {
          console.error('Registration error:', data.error);
        }
      }
    })
    .catch((error) => {
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;
      }
      console.error('Registration error:', error);
      alert("❌ Registration failed. Please check:\n1. Database is running\n2. Database 'amberss15' exists\n3. Users table exists\n\nCheck browser console (F12) for details.");
    });
}

function clearRegisterForm() {
  const fields = ['registerUsername', 'registerEmail', 'registerPassword', 'registerConfirmPassword'];
  fields.forEach((id) => {
    const input = document.getElementById(id);
    if (input) {
      input.value = '';
      input.style.borderColor = '#e0e0e0';
      input.style.backgroundColor = '#fafafa';
    }
  });

  const requirements = document.getElementById('passwordRequirements');
  if (requirements) {
    requirements.style.display = 'none';
    [...requirements.querySelectorAll('.requirement-item')].forEach((item) => item.classList.remove('valid'));
  }

  const errorMessage = document.getElementById('passwordMatchError');
  if (errorMessage) {
    errorMessage.style.display = 'none';
  }

  const registerBtn = document.getElementById('registerBtn');
  if (registerBtn) {
    registerBtn.disabled = true;
    registerBtn.style.opacity = '0.6';
    registerBtn.style.cursor = 'not-allowed';
  }
}


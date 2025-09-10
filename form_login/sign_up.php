<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background-size: cover;
      background: linear-gradient(to right, #2193b0, #6dd5ed) no-repeat fixed;
      background-size: cover;
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }


    .login-container {
      position: relative;
      background-color: rgba(255, 255, 255, 0.85);
      padding: 2rem;
      border-radius: 12px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    } 

    .login-container h2 {
      text-align: center;
      color: #357ABD;
      margin-bottom: 2rem;
      font-weight: 600;
    }

    .form-group {
      margin-bottom: 1.25rem;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      color: #444;
      font-weight: 500;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
      transition: border-color 0.3s;
    }

    input:focus {
      border-color: #4A90E2;
      outline: none;
    }

    .btn-login {
      width: 100%;
      padding: 0.75rem;
      background-color: #4A90E2;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin-top: 0.5rem;
    }

    .btn-login:hover {
      background-color: #357ABD;
    }

    .divider {
      display: flex;
      align-items: center;
      text-align: center;
      margin: 2rem 0 1rem;
      color: #999;
      font-size: 0.9rem;
    }
        .password-wrapper {
    position: relative;
    }

    .password-wrapper input {
    padding-right: 40px; 
    }

    #togglePassword {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    user-select: none;
    font-size: 1.2rem;    
    }


    .divider::before,
    .divider::after {
      content: "";
      flex: 1;
      height: 1px;
      background: #ccc;
    }

    .divider::before {
      margin-right: 10px;
    }

    .divider::after {
      margin-left: 10px;
    }

    .google-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      background-color: #fff;
      border: 1px solid #ccc;
      padding: 0.75rem;
      border-radius: 6px;
      font-size: 1rem;
      cursor: pointer;
      width: 100%;
      transition: background-color 0.3s ease;
    }

    .google-btn img {
      width: 20px;
      height: 20px;
    }

    .google-btn:hover {
      background-color: #f5f5f5;
    }

    .register-link {
      margin-top: 1.5rem;
      text-align: center;
      font-size: 0.95rem;
    }

    .register-link a {
      color: #4A90E2;
      text-decoration: none;
      font-weight: 500;
    }

    .register-link a:hover {
      text-decoration: underline;
    }

    @media (max-width: 500px) {
        .login-container {
          margin: 1rem;
        }
      }
    </style> 
</head>
<body style="background-image: url('background_login.jpg');">
    <div class="login-container">
    <h2>Sign Up </h2>

    <form action="assets/function/register.php" method="POST">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required min="8"/>
      </div>
      <div class="form-group">
          <label for="password">Password:</label>
          <div class="password-wrapper">
              <input type="password" id="password" name="password" required min="8" />
              <span id="togglePassword">👁️</span>
            </div>
        </div>
        <div class="form-group">
            <label for="username">Email:</label>
            <input type="text" id="email" name="email" required min="8" />
        </div>
        <div class="form-group">
            <label for="username">Full Name:</label>
            <input type="text" id="name" name="name" required min="8" />
        </div>

      <button type="submit" class="btn-login" name="signup">Sign-Up</button>
    </form>
    
    <div class="divider">Or</div>

    <button class="google-btn" onclick="signInWithGoogle()">
      <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google Logo" />
      Sign up with Google
    </button>

  <script>
    function signInWithGoogle() {
      window.location.href = 'assets/function/call-back.php';
    }
    document.addEventListener("DOMContentLoaded", function () {
    const passwordInput = document.getElementById("password");
    const toggleIcon = document.getElementById("togglePassword");

    toggleIcon.addEventListener("click", function () {
      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.textContent = "🙈";
      } else {
        passwordInput.type = "password";
        toggleIcon.textContent = "👁️";
      }
    });
  });
  </script> 
</body>
</html>
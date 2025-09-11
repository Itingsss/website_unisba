<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../");
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sign In</title>
 <style>

    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      background-size: cover;
      background-image: url('assets/img/background_login.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
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
    width: 100%;
    padding-right: 2.5rem; 
    padding-left: 1rem;
    height: 2.5rem;
    font-size: 1rem;
    border-radius: 6px;
    border: 1px solid #ccc;
    }

    #togglePassword {
    position: absolute;
    right: 10px;
    top: 70%;
    transform: translateY(-50%);
    cursor: pointer;
    user-select: none;
    font-size: 1.2rem; 
    line-height: 1;   
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
<body>

  <div class="login-container">
    <h2>Sign In</h2>

    <form action="assets/function/login_manual.php" method="POST">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required placeholder="Email Or Username" />
      </div>

      <div class="form-group password-wrapper">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required placeholder="Password" />
        <span id="togglePassword">👁️</span>
      </div>


      <button type="submit" class="btn-login" name="login">Sign In</button>
    </form>

    <div class="divider">Or</div>

    <button class="google-btn" onclick="window.location.href='assets/function/call-back.php'">
      <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google Logo" />
      Sign in with Google
    </button>

    <div class="register-link">
      Don't have an account? <a href="sign_up.php">Sign up here</a>
    </div>
  </div>

  <script>
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

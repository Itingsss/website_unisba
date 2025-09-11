<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../");
    exit;
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Settings</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {margin:0; padding:0; box-sizing:border-box;}

    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #dbeafe, #bfdbfe, #93c5fd);
      min-height: 100vh;
      display: flex;
    }

    .sidebar {
      width: 220px;
      min-height: 100vh;
      background: #476EAE;
      color: #fff;
      position: fixed;
      left: 0;
      top: 0;
    }

    .content {
      margin-left: 220px;
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .card {
      background: #ffffff;
      border-radius: 16px;
      padding: 35px;
      width: 100%;
      max-width: 450px;
      text-align: center;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
      animation: fadeIn 0.6s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .card h2 {
      margin-bottom: 25px;
      font-size: 1.8rem;
      color: #476EAE;
    }

    .profile-pic {
      display: block;
      margin: 0 auto 20px;
      width: 110px;
      height: 110px;
      border-radius: 50%;
      border: 4px solid #476EAE;
      object-fit: cover;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .info {
      margin: 12px 0;
      font-size: 1rem;
      color: #333;
    }

    .info span {
      font-weight: bold;
      color: #476EAE;
    }
  </style>
</head>
<body>
  <?php include '../assets/layout/sidebar.php'; ?>
  <div class="content">
    <div class="card">
      <h2>User Settings</h2>
      <img src="<?= htmlspecialchars($_SESSION['picture'] ?? 'https://cdn-icons-png.flaticon.com/512/847/847969.png') ?>" 
           alt="Profile Picture" class="profile-pic">
      <div class="info"><span>Username:</span> <?= htmlspecialchars($user['username'] ?? '-') ?></div>
      <div class="info"><span>Name:</span> <?= htmlspecialchars($user['name'] ?? '-') ?></div>
      <div class="info"><span>Email:</span> <?= htmlspecialchars($user['email'] ?? '-') ?></div>
      <div class="info"><span>OAuth ID:</span> <?= htmlspecialchars($user['oauth_id'] ?? '-') ?></div>
    </div>
  </div>
  <?php
    include "../assets/layout/footer.php";
  ?>
</body>
</html>

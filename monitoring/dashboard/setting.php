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

    /* Sidebar */
 .sidebar {
    width: 220px;
    background: #476EAE;
    color: #fff;
    padding: 20px;
    position: fixed;
    top: 0;
    left: 0; /* default di desktop */
    height: 100%;
    z-index: 2000;
    transition: left 0.3s ease-in-out;
  }
  /* Mobile: sembunyikan sidebar */
  @media (max-width: 900px) {
    .sidebar { left: -100%; }
    .sidebar.show { left: 0; }
  }

    .sidebar h2 { text-align: center; margin-bottom: 20px; }
    .sidebar a {
      display: flex;
      align-items: center;
      gap: 10px;
      color: #fff;
      text-decoration: none;
      padding: 10px;
      border-radius: 8px;
      margin-bottom: 8px;
      transition: background 0.3s;
      z-index: 2500;
    }
    .sidebar a:hover { background: rgba(255, 255, 255, 0.2); }

    /* Hamburger */
    .hamburger {
    display:none;
    position:fixed;
    top:15px;
    left:15px;
    font-size:28px;
    color:#476EAE;
    cursor:pointer;
    z-index:2500;
  }
  @media (max-width: 900px) {
    .hamburger { display: block; }
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
    @media (max-width: 900px) {
  .content {
    margin-left: 0;           /* jangan geser ke kanan */
    justify-content: center;  /* pastikan di tengah horizontal */
    align-items: center;      /* pastikan di tengah vertical */
    min-height: 100vh;        /* biar card tetap center penuh layar */
  }
}
  </style>
</head>
<body>
    <div class="hamburger" id="hamburger"><i class="fas fa-bars"></i></div>
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
  <script>
    const hamburger = document.querySelector(".hamburger");
    const sidebar = document.querySelector(".sidebar");

    hamburger.addEventListener("click", () => {
      sidebar.classList.toggle("show");
    });
  </script>
</body>
</html>

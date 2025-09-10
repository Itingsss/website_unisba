<?php
include "../assets/conn.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AC Temperature Monitoring</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #fff; /* putih aja */
      color: #333;
      display: flex;
    }

    /* Sidebar */
    .sidebar {
      width: 220px;
      min-height: 100vh;
      background: #1a1a1a;
      position: fixed;
      top: 0;
      left: 0;
      color: #fff;
      z-index: 1000;
      transition: transform 0.3s ease;
    }

    /* Hamburger */
    .hamburger {
      display: none;
      position: fixed;
      top: 15px;
      left: 15px;
      font-size: 24px;
      color: #333;
      z-index: 1500;
      cursor: pointer;
    }

    .content {
      margin-left: 230px;
      padding: 20px;
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
      gap: 20px;
      width: 100%;
      max-width: 1200px;
    }

    .ac-card {
      background: rgba(71, 110, 174, 0.1); /* transparan biru muda */
      border-radius: 16px;
      padding: 20px;
      text-align: center;
      box-shadow: 0 6px 16px rgba(0,0,0,0.15);
      backdrop-filter: blur(6px);
      animation: fadeIn 1s ease-in-out;
      color: #333; /* teks gelap biar kebaca */
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .ac-icon {
      font-size: 50px;
      margin-bottom: 15px;
      color: #476EAE;
      animation: spinFan 3s linear infinite;
    }

    @keyframes spinFan {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .temperature {
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 10px;
      color: #476EAE;
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0%, 100% { color: #476EAE; }
      50% { color: #ff9800; }
    }

    .status {
      margin-bottom: 15px;
      font-size: 1rem;
      opacity: 0.9;
    }

    .progress-bar {
      width: 100%;
      height: 12px;
      background: rgba(0,0,0,0.1);
      border-radius: 10px;
      overflow: hidden;
    }

    .progress {
      height: 100%;
      width: 50%;
      background: linear-gradient(90deg, #00c6ff, #0072ff);
      animation: tempChange 5s infinite alternate ease-in-out;
    }

    @keyframes tempChange {
      from { width: 30%; }
      to { width: 80%; }
    }

    /* Responsive: Sidebar jadi hamburger */
    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
      }
      .sidebar.active {
        transform: translateX(0);
      }
      .hamburger {
        display: block;
      }
      .content {
        margin-left: 0;
        padding-top: 60px;
      }
    }
  </style>
</head>
<body>

<!-- Hamburger -->
<div class="hamburger" onclick="toggleSidebar()">
  <i class="fas fa-bars"></i>
</div>

<!-- Sidebar -->
<?php include '../assets/layout/sidebar.php'; ?>

<!-- Content -->
<div class="content">
  <h1 style="color:#476EAE;">AC Temperature Monitoring</h1>
  <div class="grid">
    <?php for($i=1; $i<=8; $i++): ?>
    <div class="ac-card">
      <i class="fa-solid fa-fan ac-icon"></i>
      <div class="temperature" id="temperature<?=$i?>">24°C</div>
      <div class="status">Cooling Mode</div>
      <div class="progress-bar">
        <div class="progress" id="progress<?=$i?>"></div>
      </div>
    </div>
    <?php endfor; ?>
  </div>
</div>

<script>
  // Sidebar toggle
  function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('active');
  }

  // Simulasi suhu random naik turun untuk 8 AC
  for (let i = 1; i <= 8; i++) {
    let tempElement = document.getElementById("temperature"+i);
    let currentTemp = 24;

    setInterval(() => {
      let change = Math.random() > 0.5 ? 1 : -1;
      currentTemp = Math.max(18, Math.min(30, currentTemp + change));
      tempElement.textContent = currentTemp + "°C";
    }, 2000 + i*200);
  }
</script>
<script>
    const hamburger = document.querySelector('.hamburger');
    const sidebar = document.querySelector('.sidebar');

    hamburger.addEventListener('click', () => {
        sidebar.classList.toggle('active');
    });
</script>
<?php
include "../assets/layout/footer.php";?>
</body>
</html>

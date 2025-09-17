<?php
include "../assets/conn.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Water Level Monitoring</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    * { margin:0; padding:0; box-sizing:border-box; }
    body { font-family:'Segoe UI', sans-serif; background:#f0f4f7; color:#333; }
    .wrapper { display:flex; width:100%; min-height:100vh; }

    /* Sidebar */
    .sidebar {
      width:220px;
      background:#476EAE;
      color:#fff;
      padding:20px;
      position:fixed;
      top:0;
      left:0;
      height:100%;
      z-index:2000;
      transition: left 0.3s ease;
    }
    .sidebar h2 { text-align:center; margin-bottom:20px; }
    .sidebar a { color:#fff; text-decoration:none; display:block; padding:10px; border-radius:8px; margin-bottom:8px; transition:0.3s; }
    .sidebar a:hover { background: rgba(255,255,255,0.2); }

    /* Main content */
    .main {
      flex:1;
      padding:25px;
      margin-left:220px;
      transition: margin-left 0.3s ease;
    }
    .main h1 { text-align:center; color:#476EAE; margin-bottom:20px; }

    /* Grid */
    .grid {
      display:grid;
      grid-template-columns:repeat(3,1fr);
      gap:35px;
      justify-content:center;
      align-items:start;
    }

    .card-wrapper {
      display:flex;
      flex-direction:column;
      align-items:center;
    }

    .card-title { 
      margin-bottom:12px;
      font-weight:bold;
      color:#476EAE;
      font-size:1.2rem;
      text-align:center;
    }

    .card {
      background:#fff;
      border-radius:50%;
      width:240px;
      height:240px;
      position:relative;
      text-align:center;
      box-shadow:0 6px 15px rgba(0,0,0,0.15);
      overflow:hidden;
      display:flex;
      flex-direction:column;
      justify-content:flex-end;
      color:#fff;
      font-weight:bold;
      font-size:2rem; 
      padding-bottom:30px;
    }

    .record {
      margin-top:10px;
      font-weight:bold;
      color:black;
      font-size:1rem;
      text-align:center;
    }

    .capacity {
      font-size:1rem;
      color:#fff;
      position:absolute;
      bottom:12px;
      width:100%;
      text-align:center;
    }

    .wave-container {
      position: absolute;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 100%;
      overflow: hidden;
      border-radius: 50%;
      background: transparent;
    }

    .wave {
      position: absolute;
      top: 0;
      left: 0;
      width: 200%;
      height: 100%;
      background: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 20' preserveAspectRatio='none'><path d='M0,10 C150,12 450,8 600,10 C750,12 1050,8 1200,10 L1200,20 L0,20 Z' fill='%2364b5f6'/></svg>") repeat-x;
      background-size: 50% 100%;
      animation: waveMove 4s linear infinite;
      transition: top 0.5s ease-in-out;
    }

    @keyframes waveMove {
      from { transform: translateX(0); }
      to   { transform: translateX(-50%); }
    }

    /* Hamburger */
    .hamburger { 
      display: none;
      position: fixed;
      top: 15px;
      left: 15px;
      font-size: 28px;
      color: #476EAE;
      cursor: pointer;
      z-index: 2500;
      background: transparent;
      border: none;
      padding: 5px;
    }

    /* Responsive */
    @media (max-width: 900px) {
      .sidebar {
        left: -100%;
      }
      .sidebar.active {
        left: 0;
      }
      .main {
        margin-left: 0;
      }
      .grid {
        grid-template-columns: 1fr; /* biar ke bawah */
        gap: 20px;
      }
      .hamburger { display: block; }
    }
  </style>
</head>
<body>

<button class="hamburger"><i class="fas fa-bars"></i></button>

<div class="wrapper">
  <?php include '../assets/layout/sidebar.php'; ?>
  <div class="main">
    <h1>Water Level Monitoring</h1>
    <div class="grid">
      <?php
        $devices = [
          3 => "Fakultas Kedokteran",
          4 => "Tamansari 1 Atas",
          5 => "Tamansari 1 Bawah"
        ];
        foreach ($devices as $deviceID => $location):
          $index = $deviceID - 2;
      ?>
      <div class="card-wrapper">
        <div class="card-title">Device <?= $deviceID ?> - <?= $location ?></div>
        <div class="card" id="card<?= $index ?>">
          <div class="persen" id="persen<?= $index ?>">--%</div>
          <div class="wave-container"><div class="wave" id="wave<?= $index ?>"></div></div>
          <div class="capacity" id="capacity<?= $index ?>">--%</div>
        </div>
        <div class="record" id="record<?= $index ?>">Record --</div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<script>
const deviceMap = { 3: 1, 4: 2, 5: 3 };

async function fetchWaterLevel() {
  try {
    const response = await fetch('../assets/function/waterFilter.php');
    const data = await response.json();

    for (const key in data) {
      const device = data[key];
      if (device.success && deviceMap[device.deviceID]) {
        const index = deviceMap[device.deviceID];

        const percent = document.getElementById('persen' + index);
        if (percent) percent.textContent = `${parseFloat(device.persen).toFixed(2)}%`;

        const wave = document.getElementById('wave' + index);
        if (wave) {
          const height = parseFloat(device.persen);
          let topValue = 100 - height;
          if (height >= 99.9) topValue = 0;
          wave.style.top = `${topValue}%`;
        }

        const capacityEl = document.getElementById('capacity' + index);
        if (capacityEl) capacityEl.textContent = `${device.persen.toFixed(2)}%`;

        const record = document.getElementById('record' + index);
        if (record) record.textContent = `Record ${device.totalRecords}`;
      }
    }
  } catch (err) {
    console.error("Gagal mengambil data:", err);
  }
}

fetchWaterLevel();
setInterval(fetchWaterLevel, 600);

const hamburger = document.querySelector('.hamburger');
const sidebar = document.querySelector('.sidebar');
hamburger.addEventListener('click', () => {
  sidebar.classList.toggle('active');
});
</script>

<?php include "../assets/layout/footer.php"; ?>
</body>
</html>

<?php
include "../assets/conn.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Water Monitoring</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'Segoe UI', sans-serif;
        background: #f0f4f7;
        color: #333;
    }

    .wrapper {
        display: flex;
        width: 100%;
        min-height: 100vh;
    }

    /* Sidebar */
.sidebar {
    width: 220px;
    min-width: 220px;
    background: #476EAE;
    color: #fff;
    padding: 20px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: fixed;
    top: 0; left: 0;
    height: 100%;
    z-index: 2000; /* dinaikin biar bisa diklik */
    transition: left 0.3s ease;
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
        transition: 0.3s;
    }
    .sidebar a:hover { background: rgba(255, 255, 255, 0.2); }

    /* Profile Dropdown */
    .profile-section {
        margin-top: auto;
        display: flex;
        align-items: center;
        gap: 10px;
        border-top: 1px solid rgba(255,255,255,0.3);
        padding-top: 10px;
        cursor: pointer;
        position: relative;
    }
    .profile-dropdown {
        display: none;
        flex-direction: column;
        background: rgba(0,0,0,0.85);
        position: absolute;
        bottom: 50px;
        left: 0;
        right: 0;
        border-radius: 6px;
        overflow: hidden;
    }
    .profile-dropdown a {
        color: #fff;
        padding: 10px;
        font-size: 0.9rem;
        text-decoration: none;
    }
    .profile-dropdown a:hover { background: rgba(255,255,255,0.2); }
    .profile-section.active .profile-dropdown { display: flex; }

    /* Main Content */
    .main {
        flex: 1;
        padding: 25px;
        margin-left: 220px;
        transition: margin-left 0.3s ease;
    }
    .main h1 {
        margin-bottom: 20px;
        text-align: center;
        color: #476EAE;
    }

    /* Grid Card */
    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        justify-content: flex-start; /* biar nempel ke kiri */
        margin-left: 40px; /* geser dikit ke kiri */
    }
    .card {
        background: #fff;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        position: relative;
        text-align: center;
        overflow: hidden;
        width: 250px; /* biar konsisten */
    }
    .card h3 { margin-bottom: 15px; font-size: 1.1rem; }
    canvas { max-width: 150px; margin: 0 auto 15px; }

    /* Wave Effect */
    .wave-container {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 50px;
        overflow: hidden;
    }
    .wave {
        position: absolute;
        width: 200%;
        height: 100%;
        background: url("da ta:image/svg+xml;utf8,
        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 100' preserveAspectRatio='none'>
        <path d='M0,50 C300,100 900,0 1200,50 L1200,100 L0,100 Z' stroke='rgba(54,162,235,0.8)' stroke-width='3' fill='transparent' />
        </svg>") repeat-x;
        background-size: 50% 100%;
        animation: waveMove 4s linear infinite;
    }
    @keyframes waveMove {
        from { transform: translateX(0); }
        to { transform: translateX(-50%); }
    }

    .hamburger {
        display: none;
        position: fixed;
        top: 15px;
        left: 15px;
        z-index: 1100;
        font-size: 1.8rem;
        color: #476EAE;
        cursor: pointer;
    }

    /* Mobile */
    @media (max-width: 576px) {
        .sidebar { left: -220px; transition: left 0.3s ease; }
        .sidebar.active { left: 0; }
        .main { margin-left: 0; }
        .hamburger { display: block; }
        .grid { margin-left: 0; justify-content: center; } /* biar rapi di layar kecil */
    }
  </style>
</head>
<body>
<div class="hamburger"><i class="fas fa-bars"></i></div>

<div class="wrapper">
    <?php include '../assets/layout/sidebar.php';?>
    <div class="main">
        <h1>Water Monitoring</h1>

        <div class="grid">
            <?php for($i=1;$i<=8;$i++): ?>
                <div class="card">
                    <h3>Water Tank <?=$i?></h3>
                    <canvas id="chart<?=$i?>"></canvas>
                    <div class="wave-container"><div class="wave"></div></div>
                </div>
            <?php endfor; ?>
        </div>
    </div>
</div> 

<script>
function makeChart(id, used, remain) {
    const total = used + remain;
    const usedPercent = Math.round((used / total) * 100);

    new Chart(document.getElementById(id), {
        type: 'doughnut',
        data: {
            labels: ['Used', 'Remaining'],
            datasets: [{
                data: [used, remain],
                backgroundColor: [
                    "rgba(54,162,235,0.7)",
                    "rgba(200,200,200,0.3)"
                ],
                borderWidth: 2
            }]
        },
        options: {
            cutout: '70%',
            plugins: { 
                legend: { display: false },
                tooltip: { enabled: true },
                // Custom plugin untuk menampilkan persentase di tengah
                beforeDraw: function(chart) {
                    const ctx = chart.ctx;
                    const width = chart.width;
                    const height = chart.height;
                    ctx.restore();
                    const fontSize = (height / 114).toFixed(2);
                    ctx.font = fontSize + "em sans-serif";
                    ctx.textBaseline = "middle";
                    const text = usedPercent + "%";
                    const textX = Math.round((width - ctx.measureText(text).width) / 2);
                    const textY = height / 2;
                    ctx.fillText(text, textX, textY);
                    ctx.save();
                }
            },
            animation: { duration: 1200 }
        }
    });
}

// Contoh data
const data = [
  [40,60],[55,45],[70,30],[25,75],
  [90,10],[10,90],[65,35],[50,50]
];
data.forEach((d,i)=>makeChart("chart"+(i+1), d[0], d[1]));

</script>
<script>
    const hamburger = document.querySelector('.hamburger');
    const sidebar = document.querySelector('.sidebar');

    hamburger.addEventListener('click', () => {
        sidebar.classList.toggle('active');
    });
</script>

<?php
include "../assets/layout/footer.php";
?>
</body>
</html>

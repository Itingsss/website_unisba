<?php
include "../assets/conn.php";
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AC Monitoring 3 Phasa</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    /* General Body Styles */
body {
  margin: 0;
  font-family: Arial, sans-serif;
  background-color: #f4f7f6;
  color: #333;
  overflow-x: hidden; /* Prevent horizontal scroll */
}

/* Sidebar */
.sidebar {
  width: 220px;
  background: #476EAE;
  color: #fff;
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  z-index: 2000;
  transition: left 0.3s ease-in-out;
}

/* Hamburger Menu */
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

/* Content Wrapper */
.content {
  margin-left: 220px;
  padding: 25px;
  transition: margin-left 0.3s ease-in-out;
  min-height: calc(100vh - 55px);
}

.content h1 {
  color: #476EAE;
  text-align: center;
  margin-bottom: 30px;
  font-size: 1.8rem; /* ukuran seragam */
}

/* Grid Layout */
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 25px;
  width: 100%;
  max-width: 1600px;
  margin: 0 auto;
  padding-left: 50px; /* geser semua isi ke kanan */
  box-sizing: border-box;
}

/* Card */
.ac-card {
  background: #fff;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  text-align: center;
  transition: transform 0.3s, box-shadow 0.3s;
}

.ac-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.ac-card h2 {
  color: #476EAE;
  margin: 0 0 18px;
  font-size: 1.2rem; /* seragam ukuran h2 */
}

.ac-card p {
  margin: 14px 0;
  font-size: 0.95rem;
}

/* Sensor */
.sensor-group {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 15px;
}

    .sensor {
      position: relative;
      width: 200px;
      margin: 25px auto;
      text-align: center;
    }
    .sensor p { margin-top: 8px; font-size: 16px; font-weight: bold; }
    .sensor-value { margin-top: -10px; font-size: 18px; font-weight: bold; position: relative; z-index: 2; }

/* Icon overlay */
.icon-overlay {
  position: absolute;
  top: 45%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 42px;
  color: #555;
  animation: pulseIcon 2.5s infinite ease-in-out;
  pointer-events: none;
}

/* Status */
.status {
  margin-top: 5px;
  font-size: 14px;
  font-weight: bold;
  padding: 5px 12px;
  border-radius: 15px;
  display: inline-block;
  color: white;
}

.status.green { background: #4caf50; }
.status.yellow { background: #ffc107; color: #333; }
.status.orange { background: #ff9800; }
.status.red { background: #f44336; }

/* Button */
button {
  padding: 10px 18px;
  margin-top: 15px;
  border: none;
  border-radius: 8px;
  background: #476EAE;
  color: white;
  cursor: pointer;
  transition: background 0.3s, transform 0.2s;
  font-weight: bold;
}

button:hover {
  background: #36548a;
  transform: scale(1.05);
}

.power-btn {
  margin: 20px auto;
  background: #e74c3c;
  font-size: 22px;
  border-radius: 50%;
  width: 60px;
  height: 60px;
}

.power-btn:hover { background: #c0392b; }

/* Footer */
footer {
  text-align: center;
  padding: 15px;
  background: #476EAE;
  color: #fff;
  margin-left: 220px;
  transition: margin-left 0.3s ease-in-out;
}

/* Animations */
@keyframes pulseIcon {
  0%   { transform: translate(-50%, -50%) scale(1);   color: #476EAE; }
  50%  { transform: translate(-50%, -50%) scale(1.15); color: #ff9800; }
  100% { transform: translate(-50%, -50%) scale(1);   color: #476EAE; }
}

/* Responsive */
 @media (max-width: 900px) {
    .sidebar { left: -100%; }
    .sidebar.active { left: 0; }
    .hamburger { display: block; }
    .content { margin-left: 0; transition: margin-left 0.3s ease; }
    .content.shifted { margin-left: 0; }
    footer { margin-left: 0; }
  }

@media (max-width: 768px) {
  .content { padding: 15px;  margin-left: -30px;
   margin-right: auto;}
  .grid { grid-template-columns: 1fr; gap: 20px; }
  .content h1 { font-size: 1.4rem; }
  .sensor-group { flex-direction: column; align-items: center; }
}

  </style>
</head>
<body>
<div class="hamburger"><i class="fas fa-bars"></i></div>

<div class="wrapper">
    <?php include "../assets/layout/sidebar.php"; ?>
    </div>
<div class="content">
  <h1>Monitoring AC 3 Phasa</h1>
  <div class="grid">
    <!-- Phasa R -->
  <div class="ac-card">
    <h2>Phasa R</h2>
    <div class="sensor">
      <canvas id="gaugeVoltR"></canvas>
      <div class="icon-overlay"><i class="fa-solid fa-bolt"></i></div>
      <p>Voltage</p>
      <div class="sensor-value" id="voltR">0V</div>
      <div id="voltR-status" class="status green">-</div>
    </div>
    <div class="sensor">
      <canvas id="gaugeAmpR"></canvas>
      <div class="icon-overlay"><i class="fa-solid fa-battery-half"></i></div>
      <p>Ampere</p>
      <div class="sensor-value" id="ampR">0A</div>
      <div id="ampR-status" class="status green">-</div>
    </div>
    <div class="sensor">
      <canvas id="gaugeWattR"></canvas>
      <div class="icon-overlay"><i class="fa-solid fa-plug-circle-bolt"></i></div>
      <p>Watt</p>
      <div class="sensor-value" id="wattR">0W</div>
      <div id="wattR-status" class="status green">-</div>
    </div>
<button class="power-btn" onclick="togglePower()">
  <i class="fas fa-power-off"></i>
</button>
  </div>


    <!-- Phasa S -->
  <div class="ac-card">
    <h2>Phasa S</h2>
    <div class="sensor">
      <canvas id="gaugeVoltS"></canvas>
      <div class="icon-overlay"><i class="fa-solid fa-bolt"></i></div>
      <p>Voltage</p>
      <div class="sensor-value" id="voltS">0V</div>
      <div id="voltS-status" class="status green">-</div>
    </div>
    <div class="sensor">
      <canvas id="gaugeAmpS"></canvas>
      <div class="icon-overlay"><i class="fa-solid fa-battery-half"></i></div>
      <p>Ampere</p>
      <div class="sensor-value" id="ampS">0A</div>
      <div id="ampS-status" class="status green">-</div>
    </div>
    <div class="sensor">
      <canvas id="gaugeWattS"></canvas>
      <div class="icon-overlay"><i class="fa-solid fa-plug-circle-bolt"></i></div>
      <p>Watt</p>
      <div class="sensor-value" id="wattS">0W</div>
      <div id="wattS-status" class="status green">-</div>
    </div>
<button onclick="calibrateRelay()">
  <i class="fas fa-sliders"></i> Kalibrasi Relay
</button>
  </div>

    <!-- Phasa T -->
    <div class="ac-card">
      <h2>Phasa T</h2>
      <div class="sensor">
        <canvas id="gaugeVoltT"></canvas>
        <div class="icon-overlay"><i class="fa-solid fa-bolt"></i></div>
        <p>Voltage</p>
        <div class="sensor-value" id="voltT">0V</div>
        <div id="voltT-status" class="status green">-</div>
      </div>
      <div class="sensor">
        <canvas id="gaugeAmpT"></canvas>
        <div class="icon-overlay"><i class="fa-solid fa-battery-half"></i></div>
        <p>Ampere</p>
        <div class="sensor-value" id="ampT">0A</div>
        <div id="ampT-status" class="status green">-</div>
      </div>
      <div class="sensor">
        <canvas id="gaugeWattT"></canvas>
        <div class="icon-overlay"><i class="fa-solid fa-plug-circle-bolt"></i></div>
        <p>Watt</p>
        <div class="sensor-value" id="wattT">0W</div>
        <div id="wattT-status" class="status green">-</div>
      </div>
      <p style="margin-top:100px; font-size:25px; color:#777;">Record Data</p>
      <b style="margin-top:10px; font-size:20px; color:#777;" id="record-ac">0</b>
    </div>
  </div>
</div>
<?php include "../assets/layout/footer.php"; ?>
<script> 
// Tombol power & kalibrasi
function togglePower() {
  alert("Tombol Power Phasa R ditekan!");
  // TODO: fetch ke PHP / API untuk kontrol power relay
}

function calibrateRelay() {
  alert("Kalibrasi Relay Phasa S dijalankan!");
  // TODO: fetch ke PHP / API untuk trigger kalibrasi
}

// Fungsi bikin gauge Chart.js
function createGauge(ctx, max) {
  return new Chart(ctx, {
    type: 'doughnut',
    data: {
      datasets: [{
        data: [0, max],
        backgroundColor: ['#4caf50', '#e0e0e0'],
        borderWidth: 0
      }]
    },
    options: {
      rotation: -90,
      circumference: 180,
      cutout: '70%',
      plugins:{
        legend:{display:false},
        tooltip:{enabled:false}
      },
      animation: {
        animateRotate: true,
        animateScale: true,
        duration: 800
      }
    }
  });
}

// Status warna & teks
function getStatus(value, max) {
  let percent = (value/max)*100;
  if(percent < 50) return {cls:'green', color:'#4caf50', text:'Safe'};
  if(percent < 70) return {cls:'yellow', color:'#ffeb3b', text:'Warning'};
  if(percent < 85) return {cls:'orange', color:'#ff9800', text:'High'};
  return {cls:'red', color:'#f44336', text:'Danger'};
}

// Toggle sidebar (hamburger)
const hamburger = document.querySelector('.hamburger');
const sidebar = document.querySelector('.sidebar');
if(hamburger && sidebar){
  hamburger.addEventListener('click', () => {
    sidebar.classList.toggle('active');
  });
}


// Update gauge + status
function updateGauge(chart, value, max, valueId, unit, statusId) {
  chart.data.datasets[0].data = [value, max - value];

  let status = getStatus(value, max);

  chart.data.datasets[0].backgroundColor = [
    status.color, "rgba(230,230,230,0.3)"
  ];

  chart.update();

  // update angka
  document.getElementById(valueId).innerText = value + unit;

  // update status
  let statusEl = document.getElementById(statusId);
  statusEl.innerText = status.text;
  statusEl.className = "status " + status.cls;
}

// Init semua gauge
const gauges = {
  voltR: createGauge(document.getElementById('gaugeVoltR'),240),
  ampR: createGauge(document.getElementById('gaugeAmpR'),10),
  wattR: createGauge(document.getElementById('gaugeWattR'),2000),
  voltS: createGauge(document.getElementById('gaugeVoltS'),240),
  ampS: createGauge(document.getElementById('gaugeAmpS'),10),
  wattS: createGauge(document.getElementById('gaugeWattS'),2000),
  voltT: createGauge(document.getElementById('gaugeVoltT'),240),
  ampT: createGauge(document.getElementById('gaugeAmpT'),10),
  wattT: createGauge(document.getElementById('gaugeWattT'),2000),
};

setInterval(()=>{
  fetch('../assets/function/acphase3.php')
  .then(res => res.json())
  .then(data=>{
    let voltR = parseFloat(data.acPhasa3.voltageR) || 0;
    let ampR  = parseFloat(data.acPhasa3.ampereR) || 0;
    let wattR = parseFloat(data.acPhasa3.wattR) || 0;
  
    let voltS = parseFloat(data.acPhasa3.voltageS) || 0;
    let ampS  = parseFloat(data.acPhasa3.ampereS) || 0;
    let wattS = parseFloat(data.acPhasa3.wattS) || 0;
  
    let voltT = parseFloat(data.acPhasa3.voltageT) || 0;
    let ampT  = parseFloat(data.acPhasa3.ampereT) || 0;
    let wattT = parseFloat(data.acPhasa3.wattT) || 0;

    let totalRecord = parseInt(data.totalACPhasa3) || 0;
    document.getElementById('record-ac').innerText = totalRecord + " Records";
  
    updateGauge(gauges.voltR, voltR,240,"voltR","V","voltR-status");
    updateGauge(gauges.ampR, ampR,10,"ampR","A","ampR-status");
    updateGauge(gauges.wattR,wattR,2000,"wattR","W","wattR-status");
  
    updateGauge(gauges.voltS, voltS,240,"voltS","V","voltS-status");
    updateGauge(gauges.ampS, ampS,10,"ampS","A","ampS-status");
    updateGauge(gauges.wattS,wattS,2000,"wattS","W","wattS-status");
  
    updateGauge(gauges.voltT, voltT,240,"voltT","V","voltT-status");
    updateGauge(gauges.ampT, ampT,10,"ampT","A","ampT-status");
    updateGauge(gauges.wattT,wattT,2000,"wattT","W","wattT-status");
  })
  .catch(err => console.error("Fetch error:", err));
},500);
</script>


</body>
</html>

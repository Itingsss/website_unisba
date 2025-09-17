<?php
include "../assets/conn.php";
session_start();

$status = json_decode(file_get_contents('../assets/data/ac_status.json'), true);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Monitoring Suhu Ruang Server</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

<?php include '../assets/layout/sidebar.php';?>

<main class="content">
  <h1>Monitoring Suhu Ruang Server</h1>
  
  <div class="grid">

    <div class="ac-card">
      <h2>Suhu Server Deknat</h2>
      <div class="sensor-group">
        <div class="sensor">
          <canvas id="gaugeTemp"></canvas>
          <div class="icon-overlay"><i class="fa-solid fa-temperature-half"></i></div>
          <p>Temperature</p>
          <div class="sensor-value" id="temp-value">0°C</div>
          <div id="temp-status" class="status green">-</div>
        </div>
        <div class="sensor">
          <canvas id="gaugeHum"></canvas>
          <div class="icon-overlay"><i class="fa-solid fa-droplet"></i></div>
          <p>Humidity</p>
          <div class="sensor-value" id="hum-value">0%</div>
          <div id="hum-status" class="status green">-</div>
        </div>
      </div>
      <button class="power-btn"><i class="fa-solid fa-power-off"></i></button>
      <p>Record Data: <b id="record-deknat">0</b></p>
    </div>

    <div class="ac-card">
      <h2>Ruang Server AC IN</h2>
      <div class="sensor-group">
        <div class="sensor">
          <canvas id="gaugeVoltIn"></canvas>
          <div class="icon-overlay"><i class="fa-solid fa-bolt"></i></div>
          <p>Voltage IN</p>
          <div class="sensor-value" id="volt-in">0V</div>
          <div id="volt-in-status" class="status green">-</div>
        </div>
        <div class="sensor">
          <canvas id="gaugeAmpIn"></canvas>
          <div class="icon-overlay"><i class="fa-solid fa-battery-three-quarters"></i></div>
          <p>Ampere IN</p>
          <div class="sensor-value" id="amp-in">0.0A</div>
          <div id="amp-in-status" class="status green">-</div>
        </div>
      </div>
      <p>Status 1: <b>AC1 <?= strtoupper($status['ac1']) ?></b></p>
      <p>Status 2: <b>AC2 <?= strtoupper($status['ac2']) ?></b></p>
      <form action="../assets/function/mqtt.php" method="post">
          <button type="submit"><i class="fa-solid fa-retweet"></i> Switch Prioritas AC</button>
      </form>
    </div>

    <div class="ac-card">
      <h2>Ruang Server AC1</h2>
      <div class="sensor-group">
        <div class="sensor">
          <canvas id="gaugeVolt1"></canvas>
          <div class="icon-overlay"><i class="fa-solid fa-bolt"></i></div>
          <p>Voltage</p>
          <div class="sensor-value" id="volt1">0V</div>
          <div id="volt1-status" class="status green">-</div>
        </div>
        <div class="sensor">
          <canvas id="gaugeAmp1"></canvas>
          <div class="icon-overlay"><i class="fa-solid fa-battery-three-quarters"></i></div>
          <p>Ampere</p>
          <div class="sensor-value" id="amp1">0.0A</div>
          <div id="amp1-status" class="status green">-</div>
        </div>
        <div class="sensor">
          <canvas id="gaugeWatt1"></canvas>
          <div class="icon-overlay"><i class="fa-solid fa-plug-circle-bolt"></i></div>
          <p>Watt</p>
          <div class="sensor-value" id="watt1">0W</div>
          <div id="watt1-status" class="status green">-</div>
        </div>
        <div class="sensor">
          <canvas id="gaugePf1"></canvas>
          <div class="icon-overlay"><i class="fa-solid fa-circle-nodes"></i></div>
          <p>PF</p>
          <div class="sensor-value" id="pf1">0.00</div>
          <div id="pf1-status" class="status green">-</div>
        </div>
      </div>
      <p>Record Data: <b id="record-ac">0</b></p>
    </div>

    <div class="ac-card">
      <h2>Ruang Server AC2</h2>
      <div class="sensor-group">
        <div class="sensor">
          <canvas id="gaugeVolt2"></canvas>
          <div class="icon-overlay"><i class="fa-solid fa-bolt"></i></div>
          <p>Voltage</p>
          <div class="sensor-value" id="volt2">0V</div>
          <div id="volt2-status" class="status green">-</div>
        </div>
        <div class="sensor">
          <canvas id="gaugeAmp2"></canvas>
          <div class="icon-overlay"><i class="fa-solid fa-battery-three-quarters"></i></div>
          <p>Ampere</p>
          <div class="sensor-value" id="amp2">0.0A</div>
          <div id="amp2-status" class="status green">-</div>
        </div>
        <div class="sensor">
          <canvas id="gaugeWatt2"></canvas>
          <div class="icon-overlay"><i class="fa-solid fa-plug-circle-bolt"></i></div>
          <p>Watt</p>
          <div class="sensor-value" id="watt2">0W</div>
          <div id="watt2-status" class="status green">-</div>
        </div>
        <div class="sensor">
          <canvas id="gaugePf2"></canvas>
          <div class="icon-overlay"><i class="fa-solid fa-circle-nodes"></i></div>
          <p>PF</p>
          <div class="sensor-value" id="pf2">0.00</div>
          <div id="pf2-status" class="status green">-</div>
        </div>
      </div>
      <button><i class="fa-solid fa-sliders"></i> Kalibrasi Relay</button>
    </div>

    <div class="ac-card">
      <h2>Server Gedung FK</h2>
      <div class="sensor-group">
        <div class="sensor">
          <canvas id="gaugeTempFK"></canvas>
          <div class="icon-overlay"><i class="fa-solid fa-temperature-half"></i></div>
          <p>Temperature</p>
          <div class="sensor-value" id="tempFK">0°C</div>
          <div id="tempFK-status" class="status green">-</div>
        </div>
        <div class="sensor">
          <canvas id="gaugeHumFK"></canvas>
          <div class="icon-overlay"><i class="fa-solid fa-droplet"></i></div>
          <p>Humidity</p>
          <div class="sensor-value" id="humFK">0%</div>
          <div id="humFK-status" class="status green">-</div>
        </div>
        <div class="sensor">
          <canvas id="gaugeVoltFK"></canvas>
          <div class="icon-overlay"><i class="fa-solid fa-bolt"></i></div>
          <p>Voltage</p>
          <div class="sensor-value" id="voltFK">221V</div>
          <div id="voltFK-status" class="status green">-</div>
        </div>
        <div class="sensor">
          <canvas id="gaugeAmpFK"></canvas>
          <div class="icon-overlay"><i class="fa-solid fa-battery-three-quarters"></i></div>
          <p>Ampere</p>
          <div class="sensor-value" id="ampFK">0.0A</div>
          <div id="ampFK-status" class="status green">-</div>
        </div>
        <div class="sensor">
          <canvas id="gaugeWattFK"></canvas>
          <div class="icon-overlay"><i class="fa-solid fa-plug-circle-bolt"></i></div>
          <p>Watt</p>
          <div class="sensor-value" id="wattFK">0W</div>
          <div id="wattFK-status" class="status green">-</div>
        </div>
        <div class="sensor">
          <canvas id="gaugePfFK"></canvas>
          <div class="icon-overlay"><i class="fa-solid fa-circle-nodes"></i></div>
          <p>PF</p>
          <div class="sensor-value" id="pfFK">0.00</div>
          <div id="pfFK-status" class="status green">-</div>
        </div>
      </div>
      <p>Record Data: <b id="record-fk">0</b></p>
    </div>

  </div> </main> <?php
include "../assets/layout/footer.php";
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // --- Sidebar Toggle Logic ---
  const hamburger = document.querySelector('.hamburger');
  const sidebar = document.querySelector('.sidebar');
  const content = document.querySelector('.content');

  hamburger.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    // If you want the content to be pushed when the sidebar is active on mobile, uncomment the line below
    // content.classList.toggle('shifted');
  });

  // --- Chart and Gauge Logic (No changes needed here) ---
  function createGauge(ctx, max) {
    return new Chart(ctx, {
      type: 'doughnut',
      data: {
        datasets: [{
          data: [0, max],
          backgroundColor: ['#4caf50', '#eee'],
          borderWidth: 0
        }]
      },
      options: {
        rotation: -90,
        circumference: 180,
        cutout: '70%',
        plugins: {
          legend: { display: false },
          tooltip: { enabled: false }
        },
        animation: {
            duration: 500 // Smooth animation
        }
      }
    });
  }

  function getStatus(value, max) {
      let percent = (value / max) * 100;
      if (percent > 90) return {color:"red", text:"Danger"};
      if (percent > 75) return {color:"orange", text:"High"};
      if (percent > 60) return {color:"yellow", text:"Warning"};
      return {color:"green", text:"Safe"};
  }

  function updateGauge(gauge, value, max, labelId, unit, statusId, isPf = false) {
    // Prevent value from exceeding max for the gauge visual
    let gaugeValue = Math.min(value, max);
    gauge.data.datasets[0].data = [gaugeValue, max - gaugeValue];

    let status;
    if (isPf) {
      status = {
        color: value >= 0.9 ? "green" : "red",
        text: value >= 0.9 ? "Good" : "Poor"
      };
    } else {
      status = getStatus(value, max);
    }

    gauge.data.datasets[0].backgroundColor[0] = status.color === "green" ? "#4caf50" : status.color === "yellow" ? "#ffc107" : status.color === "orange" ? "#ff9800" : "#f44336";
    gauge.update();
    
    document.getElementById(labelId).textContent = value + unit;
    let el = document.getElementById(statusId);
    el.className = "status " + status.color;
    el.textContent = status.text;
  }

  // Gauge initializations
  const tempGauge = createGauge(document.getElementById('gaugeTemp'), 40);
  const humGauge = createGauge(document.getElementById('gaugeHum'), 100);
  const voltInGauge = createGauge(document.getElementById('gaugeVoltIn'), 250); // Max 250V
  const ampInGauge = createGauge(document.getElementById('gaugeAmpIn'), 10);
  const volt1Gauge = createGauge(document.getElementById('gaugeVolt1'), 250);
  const amp1Gauge = createGauge(document.getElementById('gaugeAmp1'), 10);
  const watt1Gauge = createGauge(document.getElementById('gaugeWatt1'), 2000);
  const pf1Gauge = createGauge(document.getElementById('gaugePf1'), 1);
  const volt2Gauge = createGauge(document.getElementById('gaugeVolt2'), 250);
  const amp2Gauge = createGauge(document.getElementById('gaugeAmp2'), 10);
  const watt2Gauge = createGauge(document.getElementById('gaugeWatt2'), 2000);
  const pf2Gauge = createGauge(document.getElementById('gaugePf2'), 1);
  const tempFKGauge = createGauge(document.getElementById('gaugeTempFK'), 40);
  const humFKGauge  = createGauge(document.getElementById('gaugeHumFK'), 100);
  const voltFKGauge = createGauge(document.getElementById('gaugeVoltFK'), 250);
  const ampFKGauge  = createGauge(document.getElementById('gaugeAmpFK'), 10);
  const wattFKGauge = createGauge(document.getElementById('gaugeWattFK'), 2000);
  const pfFKGauge   = createGauge(document.getElementById('gaugePfFK'), 1);

  // Data fetching interval
  setInterval(() => {
    fetch("../assets/function/server.php")
      .then(res => res.json())
      .then(data => {
        // Deknat
        updateGauge(tempGauge, parseFloat(data.deknat.temperature) || 0, 40, "temp-value", "°C", "temp-status");
        updateGauge(humGauge, parseFloat(data.deknat.humidity) || 0, 100, "hum-value", "%", "hum-status");

        // Record Counts
        document.getElementById("record-deknat").textContent = data.totalDEKNAT || 0;
        document.getElementById("record-ac").textContent     = data.totalAC || 0;
        document.getElementById("record-fk").textContent     = data.totalFK || 0;

        // AC IN
        updateGauge(voltInGauge, parseFloat(data.ac.voltageIn) || 0, 250, "volt-in", "V", "volt-in-status");
        updateGauge(ampInGauge, parseFloat(data.ac.ampereIn) || 0, 10, "amp-in", "A", "amp-in-status");
        
        // AC1
        updateGauge(volt1Gauge, parseFloat(data.ac.voltageR) || 0, 250, "volt1", "V", "volt1-status");
        updateGauge(amp1Gauge, parseFloat(data.ac.ampereR) || 0, 10, "amp1", "A", "amp1-status");
        updateGauge(watt1Gauge, parseFloat(data.ac.wattR) || 0, 2000, "watt1", "W", "watt1-status");
        updateGauge(pf1Gauge, parseFloat(data.ac.powerfactorR) || 0, 1, "pf1", "", "pf1-status", true);

        // AC2
        updateGauge(volt2Gauge, parseFloat(data.ac.voltageS) || 0, 250, "volt2", "V", "volt2-status");
        updateGauge(amp2Gauge, parseFloat(data.ac.ampereS) || 0, 10, "amp2", "A", "amp2-status");
        updateGauge(watt2Gauge, parseFloat(data.ac.wattS) || 0, 2000, "watt2", "W", "watt2-status");
        updateGauge(pf2Gauge, parseFloat(data.ac.powerfactorS) || 0, 1, "pf2", "", "pf2-status", true);

        // FK
        updateGauge(tempFKGauge, parseFloat(data.fk.temperature) || 0, 40, "tempFK", "°C", "tempFK-status");
        updateGauge(humFKGauge, parseFloat(data.fk.humidity) || 0, 100, "humFK", "%", "humFK-status");
        updateGauge(voltFKGauge, parseFloat(data.fk.voltage) || 0, 250, "voltFK", "V", "voltFK-status");
        updateGauge(ampFKGauge, parseFloat(data.fk.ampere) || 0, 10, "ampFK", "A", "ampFK-status");
        updateGauge(wattFKGauge, parseFloat(data.fk.watt) || 0, 2000, "wattFK", "W", "wattFK-status");
        updateGauge(pfFKGauge, parseFloat(data.fk.powerfactor) || 0, 1, "pfFK", "", "pfFK-status", true);
      })
      .catch(err => console.error("Error fetching data:", err));
  }, 1000); // Fetch every second for smoother updates
</script>

</body>
</html>
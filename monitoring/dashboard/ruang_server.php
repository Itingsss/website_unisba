<?php
include "../assets/conn.php";
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Monitoring Suhu Ruang Server</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #fff;
      color: #333;
    }

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
      top: 0; 
      left: 0;
      height: 100%;
      z-index: 2000;
      transition: left 0.3s ease-in-out;
    }
    .sidebar h2 { 
      text-align: center; 
      margin-bottom: 20px; 
    }
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
    }
    .sidebar a:hover { background: rgba(255, 255, 255, 0.2); }

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

    .content {
      margin-left: 230px;
      padding: 20px;
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
      box-sizing: border-box;
      position: relative;
    }

    .dashboard {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
    }
    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 15px;
      width: 100%;
      max-width: 1600px;
      margin: 0 auto 60px;
    }
    .grid-2col {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
      width: 100%;
      max-width: 1400px;
    }
    footer {
      text-align: center;
      padding: 15px;
      background: #476EAE;
      color: #fff;
      margin-left: 230px;
      transition: margin-left 0.3s ease;
    }

    .card, .ac-card, .server-card {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.15);
      height: 100%;
      transition: transform 0.3s;
    }
    .ac-card, .server-card {
      background: rgba(71, 110, 174, 0.08);
      padding: 12px;
      text-align: center;
      box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    }
    .ac-card:hover, .server-card:hover { transform: translateY(-5px); }
    .ac-card h2, .server-card h2 { color: #476EAE; margin-bottom: 15px; }
    .server-card .item { margin-bottom: 12px; }
    .server-card .item strong { display: block; font-size: 14px; color: #333; }
    .server-card .item p { margin: 2px 0; font-size: 16px; font-weight: bold; }
    .calibrate-btn {
      padding: 8px 14px;
      border: none;
      border-radius: 8px;
      background: #476EAE;
      color: white;
      cursor: pointer;
      width: 100%;
      margin-top: 10px;
      transition: 0.3s;
    }
    .calibrate-btn:hover { background: #36548a; }

    .sensor {
      position: relative;
      width: 200px;
      margin: 25px auto;
      text-align: center;
    }
    .sensor p { margin-top: 8px; font-size: 16px; font-weight: bold; }
    .sensor-value { margin-top: -10px; font-size: 18px; font-weight: bold; position: relative; z-index: 2; }

  .hamburger {
      display:none;
      position:fixed;
      top:15px;
      left:15px;
      font-size:28px;
      color:#476EAE;
      cursor:pointer;
      z-index:2500;
      background:none;
  }
    
  .status {
    margin-top: 5px;
    font-size: 14px;
    font-weight: bold;
    padding: 4px 10px;
    border-radius: 8px;
    display: inline-block;
  }
  .status.green { background: #4caf50; color: white; }
  .status.yellow { background: #ffeb3b; color: #333; }
  .status.orange { background: #ff9800; color: white; }
  .status.red { background: #f44336; color: white; }

  button {
    padding: 8px 14px;
    margin-top: 15px;
    border: none;
    border-radius: 8px;
    background: #476EAE;
    color: white;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
  }
  button:hover { background: #36548a; transform: scale(1.05); }
  .power-btn {
    margin: 20px auto;
    background: #e74c3c;
    font-size: 22px;
    border-radius: 50%;
    width: 60px;
    height: 60px;
  }
  .power-btn:hover { background: #c0392b; }

  .icon-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 45px;
    color: #555;
    animation: pulseIcon 2s infinite;
    pointer-events: none;
  }
  @keyframes pulseIcon {
    0%   { transform: translate(-50%, -50%) scale(1);   color: #476EAE; }
    50%  { transform: translate(-50%, -50%) scale(1.2); color: #ff9800; }
    100% { transform: translate(-50%, -50%) scale(1);   color: #476EAE; }
  }

  @media (max-width: 1600px) { .grid { grid-template-columns: repeat(4, 1fr); } }
  @media (max-width: 1200px) { .grid { grid-template-columns: repeat(3, 1fr); } }

  @media (max-width: 900px) {
    .sidebar { left: -100%; }
    .sidebar.active { left: 0; }
    .hamburger { display: block; }
    .content { margin-left: 0; transition: margin-left 0.3s ease; }
    .content.shifted { margin-left: 0; }
    footer { margin-left: 0; }
  }

  @media (max-width: 480px) {
    .grid, .dashboard { grid-template-columns: 1fr !important; gap: 15px; }
    .ac-card, .server-card { padding: 10px; font-size: 14px; }
    .sensor { width: 100% !important; margin: 15px 0; }
  }

</style>
</head>
<body>
<div class="hamburger"><i class="fas fa-bars"></i></div>
<?php include '../assets/layout/sidebar.php';?>
<div class="content">
  <h1 style="color:#476EAE;">Monitoring Suhu Ruang Server</h1>
  <div class="grid">
    <div class="ac-card">
      <div class=24°C>
        <h2>Suhu Server Deknat</h2>
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
        <button class="power-btn"><i class="fa-solid fa-power-off"></i></button>
        <p>Record Data: <b id="record-deknat">0</b></p>
      </div>
    </div>
    <div class="ac-card">
      <h2>Ruang Server AC IN</h2>
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
      <p>Status: <b>AC1 ON</b></p>
      <p>Status: <b>AC2 OFF</b></p>
      <button><i class="fa-solid fa-retweet"></i> Switch Prioritas AC</button>
    </div>

    <div class="ac-card">
      <h2>Ruang Server AC1</h2>
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
      <p>Record Data: <b id="record-ac">0</b></p>
    </div>

<div class="dashboard">
  <div class="ac-card">
    <h2>Ruang Server AC2</h2>
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
    <button><i class="fa-solid fa-sliders"></i> Kalibrasi Relay</button>
  </div>

  <div class="ac-card">
    <h2>Server Gedung FK</h2>
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
    <p>Record Data: <b id="record-fk">0</b></p>
  </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  function createGauge(ctx, max) {
    return new Chart(ctx, {
      type: 'doughnut',
      data: { datasets: [{ data: [0, max], backgroundColor: ['#4caf50', '#eee'], borderWidth: 0 }] },
      options: { rotation: -90, circumference: 180, cutout: '70%', plugins: { legend: { display: false }, tooltip: { enabled: false } } }
    });
  }
    const hamburger = document.querySelector('.hamburger');
    const sidebar = document.querySelector('.sidebar');
    const content = document.querySelector('.content');

  hamburger.addEventListener('click', () => {
    sidebar.classList.toggle('active');
    content.classList.toggle('shifted');
  });

  function getStatus(percent) {
    if (percent < 30) return {color:"green", text:"Aman"};
    if (percent < 60) return {color:"yellow", text:"Waspada"};
    if (percent < 85) return {color:"orange", text:"Tinggi"};
    return {color:"red", text:"Kritis"};
  }

  function updateGauge(gauge, value, max, labelId, unit, statusId, isPf=false) {
    let percent = (value/max)*100;
    gauge.data.datasets[0].data = [value, max - value];
    let status = isPf ? {color: value>=0.9?"green":"red", text: value>=0.9?"Bagus":"Jelek"} : getStatus(percent);
    gauge.data.datasets[0].backgroundColor[0] =
      status.color==="green"?"#4caf50":status.color==="yellow"?"#ffeb3b":status.color==="orange"?"#ff9800":"#f44336";
    gauge.update();
    document.getElementById(labelId).textContent = value + unit;
    let el = document.getElementById(statusId);
    el.className = "status " + status.color;
    el.textContent = status.text;
  }


  const tempGauge = createGauge(document.getElementById('gaugeTemp'), 40);
  const humGauge = createGauge(document.getElementById('gaugeHum'), 100);
  const voltInGauge = createGauge(document.getElementById('gaugeVoltIn'), 240);
  const ampInGauge = createGauge(document.getElementById('gaugeAmpIn'), 10);
  const volt1Gauge = createGauge(document.getElementById('gaugeVolt1'), 240);
  const amp1Gauge = createGauge(document.getElementById('gaugeAmp1'), 10);
  const watt1Gauge = createGauge(document.getElementById('gaugeWatt1'), 2000);
  const pf1Gauge = createGauge(document.getElementById('gaugePf1'), 1);
  const volt2Gauge = createGauge(document.getElementById('gaugeVolt2'), 240);
  const amp2Gauge = createGauge(document.getElementById('gaugeAmp2'), 10);
  const watt2Gauge = createGauge(document.getElementById('gaugeWatt2'), 2000);
  const pf2Gauge = createGauge(document.getElementById('gaugePf2'), 1);
  const tempFKGauge = createGauge(document.getElementById('gaugeTempFK'), 40);
  const humFKGauge  = createGauge(document.getElementById('gaugeHumFK'), 100);
  const voltFKGauge = createGauge(document.getElementById('gaugeVoltFK'), 240);
  const ampFKGauge  = createGauge(document.getElementById('gaugeAmpFK'), 10);
  const wattFKGauge = createGauge(document.getElementById('gaugeWattFK'), 2000);
  const pfFKGauge   = createGauge(document.getElementById('gaugePfFK'), 1);


setInterval(() => {
  fetch("../assets/function/server.php")
    .then(res => res.json())
    .then(data => {

      let temp = parseFloat(data.deknat.temperature) || 0;
      let hum  = parseFloat(data.deknat.humidity) || 0;

      updateGauge(tempGauge, temp, 40, "temp-value", "°C", "temp-status");
      updateGauge(humGauge, hum, 100, "hum-value", "%", "hum-status");

      document.getElementById("record-deknat").textContent = data.totalDEKNAT || 0;
      document.getElementById("record-ac").textContent     = data.totalAC || 0;
      document.getElementById("record-fk").textContent     = data.totalFK || 0;


      let voltIn = parseFloat(data.ac.voltageIn) || 0;
      let ampIn  = parseFloat(data.ac.ampereIn) || 0;
      let volac1 = parseFloat(data.ac.voltageR) || 0;
      let volac2 = parseFloat(data.ac.voltageS) || 0;
      let amp1 = parseFloat(data.ac.ampereR) || 0;
      let amp2 = parseFloat(data.ac.ampereS) || 0;
      let wat1 = parseFloat(data.ac.wattR) || 0;
      let wat2 = parseFloat(data.ac.wattS) || 0;
      let pof1 = parseFloat(data.ac.powerfactorR) || 0;
      let pof2 = parseFloat(data.ac.powerfactorS) || 0;

      updateGauge(voltInGauge, voltIn, 240, "volt-in", "V", "volt-in-status");
      updateGauge(ampInGauge, ampIn, 10, "amp-in", "A", "amp-in-status");
      updateGauge(volt1Gauge, volac1, 240, "volt1", "V", "volt1-status");
      updateGauge(volt2Gauge, volac2, 240, "volt2", "V", "volt2-status");
      updateGauge(amp1Gauge, amp1, 10, "amp1", "A", "amp1-status");
      updateGauge(amp2Gauge, amp2, 10, "amp2", "A", "amp2-status");
      updateGauge(watt1Gauge, wat1, 10, "watt1", "W", "watt1-status");
      updateGauge(watt2Gauge, wat2, 10, "watt2", "W", "watt2-status");
      updateGauge(pf1Gauge, pof1, 1, "pf1","", "pf1-status",true);
      updateGauge(pf2Gauge, pof2, 1, "pf2", "", "pf2-status", true);

      let tempfk = parseFloat(data.fk.temperature) || 0;
      let humfk = parseFloat(data.fk.humidity) || 0;
      let voltfk = parseFloat(data.fk.voltage) || 0;
      let ampfk = parseFloat(data.fk.ampere) || 0;
      let wattfk = parseFloat(data.fk.watt) || 0;
      let pffk = parseFloat(data.fk.powerfactor) || 0;

      updateGauge(tempFKGauge, tempfk, 40, "tempFK", "°C", "tempFK-status");
      updateGauge(humFKGauge, humfk, 100, "humFK", "%", "humFK-status");
      updateGauge(voltFKGauge, voltfk, 240, "voltFK", "V", "voltFK-status");
      updateGauge(ampFKGauge, ampfk, 10, "ampFK", "A", "ampFK-status")
      updateGauge(wattFKGauge, wattfk, 10, "wattFK", "W", "wattFK-status");
      updateGauge(pfFKGauge, pffk, 1, "pfFK","", "pfFK-status",true);
    })
    .catch(err => console.error("Error:", err));
}, 500);


</script>
</div>
</div>
<?php
include "../assets/layout/footer.php";
?>
</body>
</html>


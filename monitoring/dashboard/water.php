<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Filter Monitoring</title>
</head>
<body>
    <h1 style="text-align: center;">Data Filter Air Terbaru</h1>
    <canvas id="waterChart" style="max-width: 800px; margin: auto;"></canvas>
    <div class="deviceIDValue">
        Device ID: <span id="deviceID"></span>
    </div>
    <div class="waterLevel">
        Water Level: <span id="waterLevel"></span>%
    </div>

    <script>
        // Konfigurasi
        const updateInterval = 1500; // 1,5s
        const water_callback = "../assets/function/waterFilter.php";

        // Elemen DOM
        const deviceIDelement = document.getElementById('deviceID');
        const waterLevelElement = document.getElementById('waterLevel');

        let updateTimer;

        // Function grep data dari waterFilter.php
        async function fetchWaterData() {
            try {
                const response = await fetch(water_callback);
                if (!response.ok) {
                    throw new Error('HTTP error! status: ' + response.status);
                }
                const data = await response.json(); 

                if (data.error) {
                    throw new Error(data.error);
                }

                updateUI(data);

            } catch (error) {
                console.error('Fetch error:', error);
                setStatus('Error, retrying...', '${error.message}');         
            }
        }

        // Function untuk update UI
        function updateUI(data) {
            deviceIDelement.textContent = data.deviceID;
            waterLevelElement.textContent = data.persen;

            // Update visual
            const level = Math.min(100, Math.max(0, data.persen));
            waterLevelElement.style.height = '${level}%';
        }

        // Function start interval
        function start() {
            // Stop interval jika sudah ada
            if (updateTimer) {
                clearInterval(updateTimer);
            }

            // Jalankan fetch pertama kali
            fetchWaterData();

            // Set interval
            updateTimer = setInterval(fetchWaterData, updateInterval);
        }

        start();
    </script>
    
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Monitoring Sensor</title>
</head>
<body>
    <h2>Data Sensor Terbaru</h2>
    <div id="dataSensor">Loading...</div>

    <script>
        function loadData() {
            let xhr = new XMLHttpRequest();
            xhr.open("GET", "../assets/function/server.php", true);
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById("dataSensor").innerHTML = this.responseText;
                }
            }
            xhr.send();
        }
        loadData();
        setInterval(loadData, 2000);
    </script>
</body>
</html>

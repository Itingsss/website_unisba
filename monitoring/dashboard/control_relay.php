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
<title>Control Relay</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body {
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
    background: #f0f4f7;
}

.wrapper {
    display: flex;
}

.sidebar {
    width: 220px;
    background: #476EAE;
    color: #fff;
    height: 100vh;
    padding: 20px;
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
    z-index: 1000;
}
.sidebar h2 { text-align:center; margin-bottom:20px; font-size:1.4rem; }
.sidebar a {
    display: block;
    color: #fff;
    text-decoration: none;
    padding: 12px;
    margin-bottom: 10px;
    border-radius: 8px;
    transition: 0.3s;
}
.sidebar a:hover { background: rgba(255,255,255,0.2); }

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

.main {
    flex: 1;
    margin-left: 220px; 
    padding: 30px;
    transition: margin-left 0.3s ease;
}
h1 { text-align:center; color:#476EAE; margin-bottom:25px; }

table {
    width: 95%;
    right: -60px;
    border-collapse: collapse;
    text-align: center;
    z-index: 1;
    position: relative;
}
th, td {
    padding: 20px;
    border: 2px solid #476EAE;
    vertical-align: top;
    font-size: 1.05rem;
}
th {
    background-color: #476EAE;
    color: #fff;
    font-size: 1.1rem;
}
button {
    padding: 12px 18px;
    margin: 8px 0;
    border: none;
    border-radius: 8px;
    font-weight: bold;
    color: #fff;
    cursor: pointer;
    width: 140px;
    transition: 0.3s;
}
button.on { background-color:#4CAF50; }
button.off { background-color:#f44336; }
button:hover { opacity:0.8; }

footer { text-align:center; padding:15px 0; background:#476EAE; color:#fff; width:100%; margin-top:20px; }

@media (max-width: 768px){
    .hamburger { display:block; }
    .sidebar { left:-100%; }
    .sidebar.active { left:0; }
    .main { 
        margin-left:0; 
        padding:15px; 
        overflow-x: hidden; 
    }

    table {
        width: 100%; 
        right: 0;  
        display: block; 
        overflow-x: auto;
    }
    th, td {
        padding: 12px; 
        font-size: 1rem;
    }
    button { width: 100%; } 
}

</style>
</head>
<body>
<div class="hamburger"><i class="fas fa-bars"></i></div>

<div class="wrapper">
    <?php include '../assets/layout/sidebar.php'; ?>

    <div class="main">
        <h1>Control Relay</h1>
        <table>
            <tr>
                <th>Ciburial</th>
                <th>Dekanat</th>
                <th>Kedokteran</th>
            </tr>
            <tr>
                <td>
                    <button class="on">Ciburial 1 ON</button><br>
                    <button class="off">Ciburial 1 OFF</button>
                </td>
                <td>
                    <button class="on">Dekanat 1 ON</button><br>
                    <button class="off">Dekanat 1 OFF</button>
                </td>
                <td>
                    <button class="on">Kedokteran 1 ON</button><br>
                    <button class="off">Kedokteran 1 OFF</button>
                </td>
            </tr>
        </table>
    </div>
</div>

<?php include "../assets/layout/footer.php"; ?>

<script>
const hamburger = document.querySelector('.hamburger');
const sidebar = document.querySelector('.sidebar');
hamburger.addEventListener('click', () => {
    sidebar.classList.toggle('active');
});
</script>

</body>
</html>

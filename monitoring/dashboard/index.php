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
<title>Dashboard Home</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
* { box-sizing: border-box; margin:0; padding:0; }
body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; display:flex; min-height:100vh; background:#f0f4f7; color:#333; overflow-x:hidden; }

.wrapper { display:flex; flex:1; width:100%; transition: all 0.3s ease; }

.sidebar {
    width: 220px;
    background: #476EAE;
    color: #fff;
    flex-shrink:0;
    padding:20px;
    display:flex;
    flex-direction:column;
    position:fixed;
    top:0;
    left:0;
    height:100%;
    transition:left 0.3s ease;
    z-index:2000;
}
.sidebar h2 { text-align:center; margin-bottom:20px; }
.sidebar a { display:flex; align-items:center; gap:10px; color:#fff; text-decoration:none; padding:10px; border-radius:8px; margin-bottom:8px; transition:0.3s; }
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

.header-profile {
    display:flex;
    justify-content:flex-end;
    align-items:center;
    margin-bottom:30px;
    position:relative; 
    padding-right: 50px; 
}

.header-profile span {
    font-weight:500;
    font-size:1rem;
    color:#333;
    white-space:nowrap;
}

.main { flex:1; padding:25px; margin-left:220px; transition:margin-left 0.3s ease; }
.header-profile { display:flex; justify-content:flex-end; align-items:center; margin-bottom:30px; flex-wrap:wrap; }
.header-profile span { font-weight:500; font-size:1rem; color:#333; white-space:nowrap; }

.card { background-color: rgba(255,255,255,0.95); padding: 20px; border-radius: 12px; box-shadow: 0 8px 20px rgba(0,0,0,0.15); margin-bottom: 20px; }

@media(max-width:768px){
    .hamburger { display:block; }
    .sidebar { left:-100%; }
    .sidebar.active { left:0; }
    .main { margin-left:0; padding:15px; }

    .header-profile { justify-content:flex-end; padding-right:50px; }
    .header-profile span { margin:0; }
}
</style>
</head>
<body>

<div class="hamburger"><i class="fas fa-bars"></i></div>

<div class="wrapper">
    <?php include "../assets/layout/sidebar.php"; ?>
    <div class="main">
        <div class="header-profile">
            <span>Hello, <?=htmlspecialchars($user['name'])?></span>
        </div>

        <div class="card">
            <h2>Welcome!</h2>
            <p>This is your dashboard home page with modern animations, sidebar icons, and a transparent footer.</p>
        </div>

        <div class="card">
            <h3>Additional Info</h3>
            <p>You can add statistics, charts, or notifications here as needed.</p>
        </div>
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

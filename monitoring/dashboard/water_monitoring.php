<?php
include "../assets/conn.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Water Level Monitoring</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'Segoe UI', sans-serif; background:#f0f4f7; color:#333; }
.wrapper { display:flex; width:100%; min-height:100vh; }

.sidebar { width:220px; background:#476EAE; color:#fff; padding:20px; position:fixed; top:0; left:0; height:100%; display:flex; flex-direction:column; justify-content:space-between; z-index:2000; transition:left 0.3s ease; }
.sidebar h2 { text-align:center; margin-bottom:20px; }
.sidebar a { display:flex; align-items:center; gap:10px; color:#fff; text-decoration:none; padding:10px; border-radius:8px; margin-bottom:8px; transition:0.3s; }
.sidebar a:hover { background: rgba(255,255,255,0.2); }

.main { flex:1; padding:25px; margin-left:220px; transition: margin-left 0.3s ease; }
.main h1 { margin-bottom:20px; text-align:center; color:#476EAE; }

.grid {
    display:grid;
    grid-template-columns:repeat(5,1fr);
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
    margin-top:14px;
    font-weight:bold;
    color:black;
    font-size:1rem; 
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
    position:absolute;
    bottom:0;
    left:0;
    width:100%;
    height:100%;
    overflow:hidden;
    border-radius:50%;
    pointer-events:none;
    background:#fff; 
}
.wave {
    position:absolute;
    width:200%;
    height:100%;
    background: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 1200 20' preserveAspectRatio='none'><path d='M0,10 C150,12 450,8 600,10 C750,12 1050,8 1200,10 L1200,20 L0,20 Z' fill='%2364b5f6'/></svg>") repeat-x;
    background-size:50% 100%;
    bottom:0;
    animation: waveMove 4s linear infinite;
    transform: translateY(0%);
    transition: transform 1s ease-in-out;
}
@keyframes waveMove { from { transform: translateX(0); } to { transform: translateX(-50%); } }

.hamburger { display:none; position:fixed; top:15px; left:15px; z-index:2100; font-size:1.8rem; color:#476EAE; cursor:pointer; }

@media (max-width:1200px){ .grid{grid-template-columns:repeat(4,1fr);} }
@media (max-width:992px){ .grid{grid-template-columns:repeat(3,1fr);} }
@media (max-width:768px){ .grid{grid-template-columns:repeat(2,1fr);} }
@media (max-width:576px){ 
    .sidebar{left:-220px;} 
    .sidebar.active{left:0;} 
    .main{margin-left:0;} 
    .hamburger{display:block;} 
    .grid{grid-template-columns:repeat(2,1fr);gap:15px;} 
}
</style>
</head>
<body>

<div class="hamburger"><i class="fas fa-bars"></i></div>

<div class="wrapper">
    <?php include '../assets/layout/sidebar.php';?>
    <div class="main">
        <h1>Water Level Monitoring</h1>
        <div class="grid">
            <?php
            $titles = ["Kampus II Ciburial","Dekanat","Fakultas Kedokteran","Tamansari 1 Atas","Tamansari 1 Bawah","Ranggagading","Kampus III Sukaluyu"];
            $percents = [40,55,70,25,90,10,65]; 
            $capacities = ["500 L","750 L","1000 L","300 L","600 L","200 L","800 L"]; 
            foreach($titles as $i => $title): ?>
                <div class="card-wrapper">
                    <div class="card-title"><?=$title?></div>
                    <div class="card" id="card<?=$i+1?>">
                        <?=$percents[$i]?>%
                        <div class="wave-container"><div class="wave" id="wave<?=$i+1?>"></div></div>
                        <div class="capacity"><?=$capacities[$i]?></div>
                    </div>
                    <div class="record">Record 132</div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
const percents = [40,55,70,25,90,10,65];
percents.forEach((p,i)=>{
    const wave = document.getElementById('wave'+(i+1));
    if(wave){
        wave.style.transform = `translateY(${100-p}%)`;
    }
});

const hamburger=document.querySelector('.hamburger');
const sidebar=document.querySelector('.sidebar');
hamburger.addEventListener('click',()=>{sidebar.classList.toggle('active');});
</script>

<?php include "../assets/layout/footer.php";?>
</body>
</html>

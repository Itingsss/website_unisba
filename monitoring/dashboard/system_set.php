<?php
include "../assets/conn.php";
session_start();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>System Settings</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
  * {margin:0; padding:0; box-sizing:border-box;}

  body {
    font-family: 'Segoe UI', sans-serif;
    background: linear-gradient(135deg, #dbeafe, #bfdbfe, #93c5fd);
    min-height: 100vh;
    margin: 0;
    color: #333;
    display: flex;
    flex-direction: column;
  }

 .sidebar {
    width: 220px;
    background: #476EAE;
    color: #fff;
    padding: 20px;
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    z-index: 2000;
    transition: left 0.3s ease-in-out;
  }
  @media (max-width: 900px) {
    .sidebar { left: -100%; }
    .sidebar.show { left: 0; }
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
      transition: background 0.3s;
      z-index: 2500;
    }
    .sidebar a:hover { background: rgba(255, 255, 255, 0.2); }

    .hamburger {
    display:none;
    position:fixed;
    top:15px;
    left:15px;
    font-size:28px;
    color:#476EAE;
    cursor:pointer;
    z-index:2500;
  }
  @media (max-width: 900px) {
    .hamburger { display: block; }
  }

    .content {
      margin-left: 220px;
      flex: 1;
      padding: 20px;
      display: flex;
      justify-content: center;
      align-items: center;
      transition: margin-left 0.3s ease;
    }
    @media (max-width: 900px) {
      .content { margin-left: 0; }
    }

    .card {
      background: #ffffff;
      border-radius: 16px;
      padding: 35px;
      width: 100%;
      max-width: 450px;
      
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
      animation: fadeIn 0.6s ease;
    }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .card h2 {
    margin-bottom: 20px;
    font-size: 1.6rem;
    font-weight: bold;
    color: #333;
    text-align: center;
  }

  .section { margin-bottom: 30px; }
  .section h3 {
    font-size: 1.2rem;
    color: #476EAE;
    margin-bottom: 15px;
  }

  .input-group {
    margin-bottom: 15px;
  }
  .input-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 8px;
    color: #333;
  }
  .input-group input, .input-group select {
    width: 100%;
    padding: 12px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
    transition: border-color 0.3s;
  }
  .input-group input:focus, .input-group select:focus {
    border-color: #476EAE;
  }

  button {
    background: #476EAE;
    color: #fff;
    font-size: 1rem;
    font-weight: bold;
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    width: 100%;
    transition: background 0.3s;
    margin-top: 10px;
  }
  button:hover { background: #365a90; }


  footer {
    text-align: center;
    padding: 15px;
    background: #476EAE;
    color: #fff;
    width: 100%;
    font-size: 14px;
    margin-top: auto;
    transition: margin-left 0.3s ease;
  }


  @media (max-width: 900px) {
    .sidebar { 
      left: -100%; 
    }
    .sidebar.active { 
      left: 0; 
    }
    .hamburger { 
      display: block; 
    }
    .content { 
      margin-left: 0; 
    }
    footer { 
      margin-left: 0; 
    }
  }
</style>
</head>
<body>
  <div class="hamburger" id="hamburger"><i class="fas fa-bars"></i></div>
    <?php include '../assets/layout/sidebar.php'; ?>
  <div class="content" id="content">
    <div class="card">
      <h2>System Settings</h2>


      <div class="section">
        <h3><i class="fas fa-users"></i> Monitoring User</h3>
        <div class="input-group">
          <label for="user">Pilih User</label>
          <select id="user">
            <option value="">-- Pilih User --</option>
            <option value="admin">Admin</option>
            <option value="operator">Operator</option>
            <option value="viewer">Viewer</option>
          </select>
        </div>
        <button>Simpan Monitoring User</button>
      </div>


      <div class="section">
        <h3><i class="fas fa-plus-circle"></i> Tambah Alat Monitoring</h3>
        <div class="input-group">
          <label for="alat">Nama Alat</label>
          <input type="text" id="alat" placeholder="Contoh: AC Gedung A">
        </div>
        <div class="input-group">
          <label for="jenis">Jenis Monitoring</label>
          <select id="jenis">
            <option value="">-- Pilih Jenis --</option>
            <option value="ac">Monitoring AC</option>
            <option value="air">Monitoring Air</option>
          </select>
        </div>
        <button>Tambah Alat</button>
      </div>
    </div>
  </div>

  <?php include "../assets/layout/footer.php"; ?>

<script>
    const hamburger = document.querySelector(".hamburger");
    const sidebar = document.querySelector(".sidebar");

    hamburger.addEventListener("click", () => {
      sidebar.classList.toggle("show");
    });
  </script>


</body>
</html>

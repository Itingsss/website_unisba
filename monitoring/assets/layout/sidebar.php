<?php
if (!isset($_SESSION['user'])) {
    header("Location: ../");
    exit;
}

$user = $_SESSION['user'];

?>

<style>
    .sidebar {
        width: 220px;
        min-width: 220px;
        background-color: #476EAE;
        color: white;
        padding: 20px;
        flex-shrink: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: fixed;
        height: 100%;
        animation: slideInSidebar 0.7s ease forwards;
        transition: all 0.3s ease;
        z-index: 1000;
    }

    @keyframes slideInSidebar {
        from { transform: translateX(-100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }

    .sidebar h2 {
        margin-bottom: 2rem;
        font-size: 1.5rem;
        text-align: center;
        letter-spacing: 1px;
        border-bottom: 1px solid rgba(255,255,255,0.4);
        padding-bottom: 10px;
    }

    .sidebar a {
        display: flex;
        align-items: center;
        gap: 10px;
        color: white;
        text-decoration: none;
        margin-bottom: 1rem;
        padding: 12px 16px;
        border-radius: 8px;
        transition: background 0.3s, transform 0.2s;
        cursor: pointer;
    }

    .sidebar a:hover {
        background-color: rgba(255,255,255,0.2);
        transform: translateX(5px);
    }

    .dropdown {
        display: none;
        flex-direction: column;
        margin-left: 20px;
    }
    .active + .dropdown {
        display: flex;
    }

.profile-section {
    margin-top: auto;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px;
    border-top: 1px solid rgba(255, 255, 255, 0.3);
    cursor: pointer;
    position: relative;
    border-radius: 8px 8px 0 0; 
} 

.profile-section img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid white;
    object-fit: cover;
}


.profile-section span {
    flex: 1;
    font-size: 0.9rem;
    font-weight: bold;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.profile-dropdown {
    display: none;
    flex-direction: column;
    background: rgba(91, 130, 196, 0.95); 
    position: absolute;
    bottom: 55px;
    left: 0;
    min-width: 180px;
    border-radius: 6px;
    overflow: hidden;
    z-index: 100;
}

.profile-dropdown a {
    color: white;
    text-decoration: none;
    padding: 10px;
    font-size: 0.85rem;
    transition: background 0.3s;
}

.profile-dropdown a:hover {
    background: rgba(255, 255, 255, 0.2);
}

.profile-section.active .profile-dropdown {
    display: flex;
}

</style>

<div class="sidebar">
    <div>
        <h2>Home</h2>
        <a href="../dashboard"><i class="fas fa-home"></i>Dashboard</a>
        <a class="monitoring-toggle"><i class="fas fa-desktop"></i>Monitoring</a>
        <div class="dropdown">
            <a href="../dashboard/ruang_server.php"><i class="fas fa-server"></i> Ruang Server</a>
            <a href="../dashboard/water_monitoring.php"><i class="fas fa-tint"></i>Water Monitoring</a>
        </div>
        <a href="../dashboard/control_relay.php"><i class="fas fa-toggle-off"></i>Control Relay</a>
        <a href="#"><i class="fas fa-chart-line"></i>Reports</a>
    </div>

<div class="profile-section">
    <?php if (!empty($_SESSION['picture'])): ?>
        <img src="<?= htmlspecialchars($_SESSION['picture']) ?>" alt="Profile">
    <?php else: ?>
        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="Default Profile">
    <?php endif; ?>
    <span><?= htmlspecialchars($user['name'] ?? 'Guest') ?></span>
    <div class="profile-dropdown">
        <a href="../dashboard/setting.php">⚙️ Settings</a>
        <a href="../assets/function/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>
</div>

<script>
    document.querySelector('.monitoring-toggle').addEventListener('click', function() {
        this.classList.toggle('active');
    });

    document.querySelector('.profile-section').addEventListener('click', function(e) {
        e.stopPropagation();
        this.classList.toggle('active');
    });

    document.addEventListener('click', function(e) {
        const profile = document.querySelector('.profile-section');
        if (!profile.contains(e.target)) {
            profile.classList.remove('active');
        }
    });
</script>
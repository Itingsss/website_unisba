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
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        display: flex;
        min-height: 100vh;
        background: #f0f4f7;
        color: #333;
        overflow-x: hidden;
        animation: fadeInBody 1s ease;
    }

    @keyframes fadeInBody {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .wrapper {
        display: flex;
        flex: 1;
        width: 100%;
    }



    @keyframes slideInSidebar {
        from { transform: translateX(-100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }


    @keyframes fadeInText {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }


    @keyframes fadeInLink {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    /* Main content */
    .main {
        flex: 1;
        padding: 25px;
        margin-left: 220px; /* supaya sidebar tidak nabrak content */
        animation: fadeInContent 1s ease forwards;
    }

    @keyframes fadeInContent {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Header profile */
    .header-profile {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        margin-bottom: 30px;
    }

    .header-profile span {
        margin-right: 15px;
        font-weight: 500;
        font-size: 1rem;
        color: #333;
        animation: fadeInProfile 1s ease forwards;
    }

    @keyframes fadeInProfile {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .header-profile a {
        padding: 8px 16px;
        background-color: #ff4d4d;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        transition: background 0.3s, transform 0.2s;
    }

    .header-profile a:hover {
        background-color: #e60000;
        transform: scale(1.05);
    }

    /* Card-style content */
    .card {
        background-color: rgba(255,255,255,0.95);
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        margin-bottom: 20px;
        animation: fadeInCard 0.8s ease forwards;
    }

    @keyframes fadeInCard {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

animation: fadeInFooter 1s ease forwards;

    @keyframes fadeInFooter {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Responsive */
    @media(max-width:768px){


        .main {
            margin-left: 0;
            padding: 15px;
        }

        .header-profile {
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .header-profile span {
            margin-bottom: 5px;
        }
    }

</style>
</head>
<body>

<div class="wrapper">
    <!-- Main content -->
     <?php include "../assets/layout/sidebar.php";?>
    <div class="main">
        <div class="header-profile">
            <span>Hello, <?=htmlspecialchars($user['name'])?></span>
        </div>

        <div class="card">
            <h2>Welcome!</h2>
            <p>This is your dashboarda home page with modern animations, sidebar icons, and a transparent footer.</p>
        </div>

        <div class="card">
            <h3>Additional Info</h3>
            <p>You can add statistics, charts, or notifications here as needed.</p>
        </div>
    </div>
</div>

<?php include "../assets/layout/footer.php"; ?>

</body>
</html>

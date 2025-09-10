<?php
session_start();
include "../conn.php";

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil data user berdasarkan username
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1){
        $user = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $user['password'])){
            $_SESSION['user'] = $user;
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['username'] = $user['username'];
            $last_login = date("Y-m-d H:i:s");
            $stmt2 = $conn->prepare("UPDATE user SET last_login = ? WHERE id = ?");
            $stmt2->bind_param("si", $last_login, $user['id']);
            $stmt2->execute();

            // Redirect ke dashboard
            header("Location: ../../dashboard/");
            exit;
        } else {
            echo "Password salah";
        }
    } else {
        echo "Username tidak ditemukan";
    }
} else {
    echo "Gagal login: request tidak valid";
}
?>

<?php
session_start();
include "../conn.php";

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM tblog_user WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1){
        $user = $result->fetch_assoc();

        // if ($user['is_active'] === "aktif") {
        //     echo "<script>
        //     alert ('⚠️ Akun ini sedang dipakai di perangkat lain.');
        //     window.location.href = '../../';
        //     </script>";
        //     exit;
        // }

        if (password_verify($password, $user['password'])){
            $_SESSION['user'] = $user;
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['username'] = $user['username'];

            $last_login = date("Y-m-d H:i:s");
            $isActive = "aktif";
            $stmt2 = $conn->prepare("UPDATE tblog_user SET last_login = ?, is_active = ? WHERE id = ?");
            $stmt2->bind_param("ssi", $last_login, $isActive, $user['id']);
            $stmt2->execute();

            header("Location: ../../dashboard/");
            exit;
        } else {
            echo "<script>
                    alert('Password atau Username salah!!');
                    window.location.href = '../../';
                </script>";
        }
    } else {
            echo "<script>
                    alert('Password atau Username salah!!');
                    window.location.href = '../../';
                </script>";
    }
} else {
    echo "Gagal login: request tidak valid";
}
?>

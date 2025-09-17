<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../conn.php';
require_once '../../vendor/autoload.php';

$client = new Google_Client();
$client->setClientId(GOOGLE_CLIENT_ID);
$client->setClientSecret(GOOGLE_CLIENT_SECRET);
$client->setRedirectUri(GOOGLE_REDIRECT_URL);
$client->addScope("email");
$client->addScope("profile");
$client->setPrompt('consent select_account');

if (!isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    exit;
} else {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (isset($token['error'])) {
        die("Google OAuth Error: " . $token['error_description']);
    }
    $client->setAccessToken($token);

    $oauth = new Google\Service\Oauth2($client);
    $userInfo = $oauth->userinfo->get();

    $oauth_id = $userInfo->id ?? '';
    $name     = $userInfo->name ?? '';
    $email    = $userInfo->email ?? '';

    $stmt = $conn->prepare("SELECT * FROM tblog_user WHERE oauth_uid = ? AND oauth_provider = 'google'");
    $stmt->bind_param("s", $oauth_id);
    $stmt->execute();
    $results = $stmt->get_result();

    $last_login = date("Y-m-d H:i:s");
    $isActive   = "aktif";

    if ($results->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO tblog_user (oauth_provider, oauth_uid, name, email, role, is_active, last_login) 
                                VALUES ('google', ?, ?, ?, 'pegawai', ?, ?)");
        $stmt->bind_param("sssss", $oauth_id, $name, $email, $isActive, $last_login);
        if (!$stmt->execute()) {
            die("Insert gagal: " . $stmt->error);
        }
        $user_id = $stmt->insert_id;
    } else {
        $user = $results->fetch_assoc();

        // if ($user['is_active'] === "aktif") {
        //     echo "<script>
        //     alert('⚠️ Akun ini sedang dipakai di perangkat lain.');
        //     window.location.href='../../';
        //     </script>";
        //     exit;
        // }

        $stmt = $conn->prepare("UPDATE tblog_user 
                                SET name = ?, email = ?, last_login = ?, is_active = ? 
                                WHERE oauth_uid = ? AND oauth_provider = 'google'");
        $stmt->bind_param("sssss", $name, $email, $last_login, $isActive, $oauth_id);
        if (!$stmt->execute()) {
            die("Update gagal: " . $stmt->error);
        }
        $user_id = $user['id'];
    }

    $_SESSION['user'] = [
        'id'       => $user_id,
        'name'     => $name,
        'email'    => $email,
        'oauth_id' => $oauth_id
    ];

    header("Location: ../../dashboard/");
    exit;
}

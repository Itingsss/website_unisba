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
$client->addScope("email"); // penting biar dapat email
$client->addScope("profile"); // penting biar dapat nama
$client->setPrompt('consent select_account'); // Memaksa Google menampilkan dialog pemilihan akun


if (!isset($_GET['code'])) {
    $auth_url = $client->createAuthUrl();
    header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    exit;
} else {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token);

    $oauth = new Google\Service\Oauth2($client);
    $userInfo = $oauth->userinfo->get();

    $oauth_id = $userInfo->id ?? '';
    $name     = $userInfo->name ?? '';
    $email    = $userInfo->email ?? '';

    // cek apakah user sudah ada di DB
    $stmt = $conn->prepare("SELECT * FROM user WHERE oauth_uid = ? AND oauth_provider = 'google'");
    $stmt->bind_param("s", $oauth_id);
    $stmt->execute();
    $results = $stmt->get_result();

    if ($results->num_rows == 0) {
        // User baru → INSERT
        $stmt = $conn->prepare("INSERT INTO user(oauth_provider, oauth_uid, name, email, picture, role) 
                                VALUES ('google', ?, ?, ?, ?, 'pegawai')");
        $stmt->bind_param("ssss", $oauth_id, $name, $email, $picture);
        if (!$stmt->execute()) {
            die("Insert gagal: " . $stmt->error);
        }
    } else {
        // User sudah ada → UPDATE
        $last_login = date("Y-m-d H:i:s");
        $stmt = $conn->prepare("UPDATE user SET name = ?, email = ?, last_login = ? WHERE oauth_uid = ? AND oauth_provider = 'google'");
        $stmt->bind_param("ssss", $name, $email,  $last_login, $oauth_id);
        if (!$stmt->execute()) {
            die("Update gagal: " . $stmt->error);
        }
    }

    // Simpan ke session
    $_SESSION['user'] = [
        'name'  => $userInfo->name,
        'email' => $userInfo->email,
        'oauth_id' => $oauth_id
    ];

    header("Location: ../../dashboard/");
    exit;
}

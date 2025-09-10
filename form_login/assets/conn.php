<?php
$host = "localhost";
$username = "root";
$db = "db_login";
$password = "";

$conn = new mysqli($host, $username, $password, $db);
if ($conn->connect_errno) {
    die("Connection Error". $conn->connect_error);

}

define('GOOGLE_CLIENT_ID', '183166548642-mi1tblern5c4kkgjisbtmcdm7vqshnk0.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_REDIRECT_URL', 'https://localhost/form_login/assets/function/call-back.php');
?>
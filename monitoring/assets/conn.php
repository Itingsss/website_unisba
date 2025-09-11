<?php
$host = "172.26.30.8";
$username = "root";
$db = "dbsensor";
$password = "Unisba#1958";


$conn = new mysqli($host, $username, $password, $db);
if ($conn->connect_errno) {
    die("Connection Error". $conn->connect_error);

}

define('GOOGLE_CLIENT_ID', '183166548642-mi1tblern5c4kkgjisbtmcdm7vqshnk0.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_REDIRECT_URL', 'https://localhost/monitoring/assets/function/call-back.php');
?> 
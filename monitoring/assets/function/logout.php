<?php
include "../conn.php";
session_start();
$user = $_SESSION['user'];

$isActive = "nonaktif";
$sql = "UPDATE tblog_user SET is_active = ? WHERE id = ? OR oauth_uid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sis', $isActive, $user['id'], $user['oauth_id']);
if($stmt->execute()){
    echo "berhasil logout";
};

session_destroy();
header("Location: ../../");
exit;

?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../conn.php";

header("Content-Type: application/json");

$data = [];

$sql = "SELECT temperature, humidity, waktu 
        FROM tblog_suhuruangserver 
        ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
    $data['deknat'] = $row;
} else {
    $data['deknat'] = null;
}

$sql2 = "SELECT * FROM tblog_acruangserver ORDER BY id DESC LIMIT 1";
$result2 = $conn->query($sql2);

if ($result2 && $row2 = $result2->fetch_assoc()) {
    $data['ac'] = $row2;
} else {
    $data['ac'] = null;
}

$sql3 = "SELECT * FROM tblog_ruangserverfk ORDER BY id DESC LIMIT 1";
$result3 = $conn->query($sql3);

if ($result3 && $row3 = $result3->fetch_assoc()) {
    $data['fk'] = $row3;
} else {
    $data['fk'] = null;
}

function getTotal($conn, $table) {
    $res = $conn->query("SELECT COUNT(*) AS total FROM $table");
    if ($res && $row = $res->fetch_assoc()) {
        return (int)$row['total'];
    }
    return 0;
}

$data['totalDEKNAT'] = getTotal($conn, "tblog_suhuruangserver");
$data['totalAC']     = getTotal($conn, "tblog_acruangserver");
$data['totalFK']     = getTotal($conn, "tblog_ruangserverfk");

echo json_encode($data, JSON_PRETTY_PRINT);

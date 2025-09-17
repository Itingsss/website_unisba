<?php
include "../conn.php";

$sql = "SELECT * FROM tblog_acruangkelas3phasa ORDER BY id LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$data['acPhasa3'] = $row;

$sql2 = 'SELECT COUNT(*) AS total FROM tblog_acruangkelas3phasa';
$result2 = $conn->query($sql2);
$row2 = $result2->fetch_assoc();
$data['totalACPhasa3'] = $row2['total'];

if ($row) {
    echo json_encode($data);
} else {
    echo json_encode(["error" => "No data found"]);
}
?>
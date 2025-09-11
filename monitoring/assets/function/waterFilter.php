<?php
include "../conn.php";
session_start();

function getLatestWaterLevel($conn) {
    $sql1 = "SELECT * FROM tblog_waterlevel ORDER BY deviceID = 3 DESC LIMIT 1";
    $result1 = $conn->query($sql1);

    if ($result1 && $result1->num_rows > 0) {
        $row = $result1->fetch_assoc();
        $device3 = [
            "success" => true,
            "deviceID" => $row['deviceID'],
            "persen"   => $row['persen']
        ];
    } else {
        $device3 = [
            "success" => false,
            "message" => "Data tidak ditemukan."
        ];
    }

    $sql2 = "SELECT * FROM tblog_waterlevel ORDER BY deviceID = 4 DESC LIMIT 1";
    $result2 = $conn->query($sql2);

    if ($result2 && $result2->num_rows > 0) {
        $row = $result2->fetch_assoc();
        $device4 = [
            "success" => true,
            "deviceID" => $row['deviceID'],
            "persen"   => $row['persen']
        ];
    } else {
        $device4 = [
            "success" => false,
            "message" => "Data tidak ditemukan."
        ];
    }

    $sql3 = "SELECT * FROM tblog_waterlevel ORDER BY deviceID = 5 DESC LIMIT 1";
    $result3 = $conn->query($sql3);

    if ($result3 && $result3->num_rows > 0) {
        $row = $result3->fetch_assoc();
        $device5 = [
            "success" => true,
            "deviceID" => $row['deviceID'],
            "persen"   => $row['persen']
        ];
    } else {
        $device5 = [
            "success" => false,
            "message" => "Data tidak ditemukan."
        ];
    }


    return [
        "device3" => $device3,
        "device4" => $device4,
        "device5" => $device5
    ];
}

if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header('Content-Type: application/json');
    $data = getLatestWaterLevel($conn);
    echo json_encode(($data));
}

?>
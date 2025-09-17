<?php
include "../conn.php";
session_start();

function getTotalRecords($conn, $table, $deviceID = null) {
    $sql = "SELECT COUNT(*) AS total FROM $table";
    
    if ($deviceID !== null) {
        $sql .= " WHERE deviceID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $deviceID);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query($sql);
    }

    if ($result && $row = $result->fetch_assoc()) {
        return (int)$row['total'];
    }

    return 0;
}

function getLatestDataByDevice($conn, $deviceID) {
    $sql = "SELECT * FROM tblog_waterlevel WHERE deviceID = ? ORDER BY waktu DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $deviceID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return [
            "success" => true,
            "deviceID" => $row['deviceID'],
            "persen"   => $row['persen'],
            "waktu"    => $row['waktu'],
            "totalRecords" => getTotalRecords($conn, "tblog_waterlevel", $deviceID)
        ];
    } else {
        return [
            "success" => false,
            "message" => "Data tidak ditemukan untuk device ID $deviceID."
        ];
    }
}

function getLatestWaterLevel($conn) {
    return [
        "device3" => getLatestDataByDevice($conn, 3),
        "device4" => getLatestDataByDevice($conn, 4),
        "device5" => getLatestDataByDevice($conn, 5)
    ];
}

if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    header('Content-Type: application/json');
    $data = getLatestWaterLevel($conn);
    echo json_encode($data);
}
?>

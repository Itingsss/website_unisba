<?php
require_once '../../vendor/autoload.php';

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

$statusFile = '../data/ac_status.json';

if (!file_exists($statusFile)) {
    die("File tidak ditemukan!");
}

$status = json_decode(file_get_contents($statusFile), true);

$newStatus = [
    'ac1' => $status['ac2'],
    'ac2' => $status['ac1']
];

$payloadAc1 = 'ac1' . $newStatus['ac1'];
$payloadAc2 = 'ac2' . $newStatus['ac2'];

file_put_contents($statusFile, json_encode($newStatus));

$server   = '172.26.30.8';
$port     = 1883;
$clientId = 'php_mqtt_' . rand(1000, 9999);
$username = 'galang';
$password = 'Unisba#1958';
$topic    = 'ac/ruangserver/json/relay';

$settings = (new ConnectionSettings)
    ->setUsername($username)
    ->setPassword($password)
    ->setKeepAliveInterval(60);

$mqtt = new MqttClient($server, $port, $clientId);

try {
    $mqtt->connect($settings, true);

    $mqtt->publish($topic, $payloadAc1, 1);
    $mqtt->publish($topic, $payloadAc2, 3);

    $mqtt->disconnect();
    
    header("Location: ../../dashboard/ruang_server.php");
    exit;

} catch (Exception $e) {
    echo "MQTT Error: " . $e->getMessage();
}
?>

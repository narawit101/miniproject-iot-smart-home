<?php
require_once '../config/connect.php';

$sql = "SELECT water_level, temperature, humidity, light, vibration, created_at FROM sensor_data ORDER BY created_at DESC LIMIT 1";
$result = $conn->query($sql);

$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $row['water_level'] = $row['water_level'] !== null ? floatval($row['water_level']) : null;
        $row['temperature'] = $row['temperature'] !== null ? floatval($row['temperature']) : null;
        $row['humidity'] = $row['humidity'] !== null ? floatval($row['humidity']) : null;
        $row['light'] = $row['light'] !== null ? floatval($row['light']) : null;
        $row['vibration'] = $row['vibration'] !== null ? floatval($row['vibration']) : null;
        $data[] = $row;
    }
}

// ส่งผลลัพธ์เป็น JSON
header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

$conn->close();
?>

<?php
header('Content-Type: application/json');

// เชื่อมต่อฐานข้อมูล
require_once '../config/connect.php';

// ดึงค่าทั้งหมดจากฐานข้อมูล
$sql = "SELECT water_level, temperature, humidity, light, vibration, created_at FROM `sensor_data` ORDER BY created_at DESC  LIMIT 20";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo json_encode($result->fetch_all(MYSQLI_ASSOC)); // ส่งข้อมูลทั้งหมดเป็น array
} else {
    echo json_encode(["error" => "No data found"]);
}

$conn->close();
?>

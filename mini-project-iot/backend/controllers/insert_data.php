<?php
header("Content-Type: application/json");

// ตรวจสอบ API Key
define('API_KEY', 'DPI');

// รับค่า API Key จาก Header แทนการใช้ GET
$headers = getallheaders();
if (!isset($headers['api_key']) || $headers['api_key'] !== API_KEY) {
    http_response_code(403); // Forbidden
    echo json_encode(["status" => "error", "message" => "Invalid API key"]);
    exit();
}

// เชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iot_project_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// รับ JSON Data
$json = file_get_contents("php://input");
$data = json_decode($json, true);

if (!$data) {
    echo json_encode(["status" => "error", "message" => "Invalid JSON received", "raw_data" => $json]);
    exit();
}

// ตรวจสอบค่าจาก JSON
if (isset($data['temperature']) && isset($data['humidity']) && isset($data['water_level']) && isset($data['light']) && isset($data['vibration'])) {
    $temperature = $conn->real_escape_string($data['temperature']);
    $humidity = $conn->real_escape_string($data['humidity']);
    $water_level = $conn->real_escape_string($data['water_level']);
    $light = $conn->real_escape_string($data['light']);
    $vibration = $conn->real_escape_string($data['vibration']);

    $sql = "INSERT INTO sensor_data (temperature, humidity, water_level, light, vibration) 
            VALUES ('$temperature', '$humidity', '$water_level', '$light', '$vibration')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Insert success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error inserting data: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Missing required parameters", "received_data" => $data]);
}

$conn->close();

?>

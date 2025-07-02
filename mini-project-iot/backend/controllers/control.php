<?php
header("Content-Type: application/json");

if (isset($_GET['led'])) {
    $led_status = $_GET['led'];
    file_put_contents("../data/led_status.txt", $led_status);
    echo json_encode(["status" => "success", "led" => $led_status]);
}

if (isset($_GET['servo'])) {
    $servo_status = $_GET['servo']; // เก็บค่าที่รับมา
    file_put_contents("../data/servo_angle.txt", $servo_status); // แก้จาก "servo_status.txt" เป็น "servo_angle.txt"
    echo json_encode(["status" => "success", "servo" => $servo_status]);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $led_status = file_exists("../data/led_status.txt") ? file_get_contents("../data/led_status.txt") : "off";
    $servo_angle = file_exists("../data/servo_angle.txt") ? trim(file_get_contents("../data/servo_angle.txt")) : "0"; // trim() ป้องกันช่องว่างไม่พึงประสงค์

    echo json_encode(["led" => $led_status, "servo" => $servo_angle]);
}
?>
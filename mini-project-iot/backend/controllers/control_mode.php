<?php
header("Content-Type: application/json");

if (isset($_GET['mode'])) {
    $mode_status = $_GET['mode'];
    file_put_contents("../data/mode_status.txt", $mode_status);
    echo json_encode(["status" => "success", "mode" => $mode_status]);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $mode_status = file_exists("../data/mode_status.txt") ? file_get_contents("../data/mode_status.txt") : "manual";   
    echo json_encode(["mode" => $mode_status]);
}
?>
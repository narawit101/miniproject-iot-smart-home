<?php
$config = parse_ini_file(__DIR__ . '/.env');
header('Content-Type: application/json; charset=UTF-8');
header("Access-Control-Allow-Origin: *");

$host = $config['host'];
$user = $config['user'];
$pass = $config['pass'];
$dbname = $config['dbname'];


$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode(["error" => "DB Connection failed"]);
    exit;
}

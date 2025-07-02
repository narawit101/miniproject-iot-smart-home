<?php
session_start(); // เริ่ม Session

// ล้างค่าทุกอย่างใน Session
$_SESSION = array();

// ทำลาย Session
session_destroy();

// กลับไปที่หน้า login.php
header("Location: /mini-project-iot/frontend/pages/login.php");

exit();

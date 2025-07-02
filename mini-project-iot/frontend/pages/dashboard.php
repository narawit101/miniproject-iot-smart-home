<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DPI Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="../js/data.js"></script>
    <script src="../js/control.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../js/graph.js"></script>
</head>

<body>
    <div class="container">
            <!-- aside section start -->
        <aside>
            <div class="top">
                <div class="logo">
                    <h2>DPI<span class="danger">DASHBOARD</span></h2>
                </div>

                <!-- <div class="close">
                    <span class="material-symbols-sharp">close</span>
                </div> -->
            </div>
            <!-- end top -->
            <div class="sidebar">
                <a href="#" class="active">
                    <span class="material-symbols-sharp">grid_view</span>
                    <h3>Dashboard</h3>
                </a>

                <a href="/mini-project-iot/backend/controllers/logout.php">
                    <span class="material-symbols-sharp">logout</span>
                    <h3>logout</h3>
                </a>
            </div>

        </aside>
        <!-- aside section end -->

        <!-- main section start  -->
        <main>
            <h1>Dashboard</h1>
            <div class="date-time">
                <div id="timestamp"> เวลาปัจจุบัน: <div class="data" id="current-time">--:--:--</div>
                </div>
            </div>
            <div class="insights">

                <!-- start water -->
                <div class="water">
                    <span class="material-symbols-sharp">water</span>
                    <div class="middle">
                        <div class="left" id="waterLevel">
                            <h3>Water Level</h3>
                            <div class="value">
                                <h1 class="data">...</h1>
                                <h1 class="tail">M</h1>
                            </div>
                            <small class="status-box"></small>
                        </div>
                    </div>
                </div>
                <!-- end water -->

                <!-- start temperature -->
                <div class="temperature">
                    <span class="material-symbols-sharp">thermometer</span>
                    <div class="middle">
                        <div class="left" id="temperature">
                            <h3>Temperature</h3>
                            <div class="value">
                                <h1 class="data">...</h1>
                                <h1 class="tail">°C</h1>
                            </div>
                            <small class="status-box"></small>
                        </div>
                    </div>
                </div>
                <!-- end tamperature -->

                <!-- start humidity -->
                <div class="humidity">
                    <span class="material-symbols-sharp">humidity_low</span>
                    <div class="middle">
                        <div class="left" id="humidity">
                            <h3>Humidity</h3>
                            <div class="value">
                                <h1 class="data">...</h1>
                                <h1 class="tail">%</h1>
                            </div>
                            <small class="status-box"></small>
                        </div>
                    </div>
                </div>
                <!-- end humidity -->

                <!-- start light -->
                <div class="light">
                    <span class="material-symbols-sharp">light</span>
                    <div class="middle">
                        <div class="left" id="light">
                            <h3>Light</h3>
                            <div class="value">
                                <h1 class="data">...</h1>
                                <h1 class="tail">%</h1>
                            </div>
                            <small class="status-box"></small>
                        </div>
                    </div>
                </div>
                <!-- end light -->

                <!-- start vibration -->
                <div class="vibration">
                    <span class="material-symbols-sharp">earthquake</span>
                    <div class="middle">
                        <div class="left" id="vibration">
                            <h3>Vibration</h3>
                            <div class="value">
                                <h1 class="data">...</h1>
                                <h1 class="tail">Mw</h1>
                            </div>
                            <small class="status-box"></small>
                        </div>
                    </div>
                </div>
                <!-- end vibration -->
            </div>
            <!-- end inside -->

            <!-- start graph -->
            <div class="graph">
                <h1>Graph</h1>
                <canvas id="myChart"></canvas>
            </div>
            <!-- end graph -->

        </main>
        <!-- main section end -->

        <!-- right section start -->
        <div class="right">
            <div class="select-mode">
                <h2>Select Mode</h2>
                <div class="control-btn-card">
                    <div class="control-btn-box">
                        <button class="mode-btn active" id="manualBtn" onclick="toggleMode('manual')">Manual</button>
                        <button class="mode-btn inactive" id="sensorBtn" onclick="toggleMode('sensor')">Sensor</button>
                    </div>
                </div>
            </div>

            <div class="control-panel">
                <div class="light-control">
                    <h2>Light Control</h2>
                    <div class="control-btn-card">
                        <div class="status-box">
                            <p id="lightStatus" class="status led">
                                <span class="material-icons">lightbulb_outline</span>
                            </p>
                            <h5 id="lightText">Light: Off</h5>
                        </div>
                        <div class="control-btn-box">
                            <button class="control-btn led-btn" id="ledOnBtn" onclick="toggleLED('on')">เปิด LED</button>
                            <button class="control-btn led-btn" id="ledOffBtn" onclick="toggleLED('off')">ปิด LED</button>
                        </div>
                    </div>
                </div>

                <div class="dam-gate-control">
                    <h2>Dam Gate Control</h2>
                    <div class="control-btn-card">
                        <div class="status-box">
                            <p id="gateStatus" class="status servo-motor">
                                <span class="material-icons">door_front</span>
                            </p>
                            <h5 id="gateText">Dam Gate: Close</h5>
                        </div>
                        <div class="control-btn-box">
                            <button class="control-btn servo-btn" id="openGateBtn" onclick="setServoAngle('50')">เปิด ประตู</button>
                            <button class="control-btn servo-btn" id="closeGateBtn" onclick="setServoAngle('0')">ปิด ประตู</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end right section -->
    </div>
  
    
   
</body>

</html>
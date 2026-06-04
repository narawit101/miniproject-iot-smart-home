# DPI Smart Home & Dam Gate Control System (DPI Dashboard)

A comprehensive Internet of Things (IoT) smart home and dam water management control system. This platform integrates edge hardware microcontrollers (ESP32/Arduino), a relational database (MySQL), a PHP-based backend API, and a real-time web dashboard interface (HTML/CSS/JavaScript).

---

## 📂 Project Structure

The project is structured into three main directories: `backend`, `data` (hardware firmware & data files), and `frontend`. Below is the detailed structure:

```text
mini-project-iot/
├── backend/
│   ├── config/
│   │   ├── connect.php         # Database connection helper utilizing mysqli and parsing .env
│   │   └── database.php        # Core Database connection class utilizing PDO
│   └── controllers/
│       ├── control.php         # Controls LED status and Servo angle via status text files
│       ├── control_mode.php    # Configures system execution mode (Manual vs Sensor-based Auto)
│       ├── fetch_data.php      # Fetches the latest 1 sensor reading in JSON format
│       ├── fetch_graph.php     # Fetches the latest 20 sensor readings for historical chart rendering
│       ├── insert_data.php     # API endpoint for ESP32 to upload sensor readings (secured by API Key)
│       ├── user-login.php      # Class handler for admin login authentication
│       └── logout.php          # Destroys current session and redirects to login
│
├── data/
│   ├── iot.ino                 # Main ESP32 firmware (sensor reading, servo & siren controls)
│   ├── micro.ino               # Secondary microcontroller firmware for real-time clock (RTC) & I2C LCD
│   ├── led_status.txt          # Active LED status file
│   ├── servo_angle.txt         # Active Servo angle status file
│   └── mode_status.txt         # Active operation mode status file (manual vs sensor)
│
└── frontend/
    ├── css/
    │   ├── login.css           # Styling styles for the Admin login page
    │   ├── dashboard.css       # Core styling for the responsive Dashboard grid layout
    │   └── index.css           # Styling for environmental statuses and custom warning animations
    ├── img/
    │   └── Build.png           # Graphic illustration asset used on the login panel
    ├── js/
    │   ├── control.js          # Handles interactive controls & mode configurations via Fetch API
    │   ├── data.js             # Polls real-time data & modifies card classes based on thresholds
    │   └── graph.js            # Renders real-time historical graphs using Chart.js
    └── pages/
        ├── login.php           # Admin login interface form
        └── dashboard.php       # Core user web dashboard page
```

---

## ⚡ Key Features

1. **Real-time Environmental Monitoring**: Instantly displays metrics for Water Level, Temperature, Humidity, Light intensity, and Vibration levels.
2. **Dual-Mode System Control**:
   - **Manual Mode**: Admins can manually toggle the LED light bulb or command the Dam Gate (Servo motor) directly from the web interface.
   - **Sensor Mode (Auto)**: Edge hardware operates automatically based on environment sensors (e.g., dam gates open when the water level rises beyond a critical threshold, and lights activate in dark environments).
3. **Visual & Audio Alarms**:
   - **Physical Buzzer Siren**: Beeps loudly when anomalous vibrations are detected (potential earthquake alert).
   - **Interactive Web Effects**: Cards dynamically shift styles to threat colors (e.g., red) accompanied by vibration shaking animations (`.shake`) or blinking notifications (`.blinking`).
4. **Historical Data Visualization**: Draws real-time line charts showing trends for the 20 most recent logs of all five sensors using Chart.js.
5. **Secure Middleware Integration**:
   - Web application dashboard is protected behind admin session authentication.
   - Incoming hardware logs via [insert_data.php](file:///c:/D/iot/software_iot/miniproject-iot-smart-home/mini-project-iot/backend/controllers/insert_data.php) require a security header validation (`api_key: DPI`) to reject unsolicited data writes.

---

## 🗄️ Database Setup

The backend communicates with a MySQL database (default name: `iot_project_db`). Set up the schema using the SQL schema below:

```sql
CREATE DATABASE IF NOT EXISTS iot_project_db CHARACTER SET utf8 COLLATE utf8_general_ci;
USE iot_project_db;

-- 1. Table for logging sensor data
CREATE TABLE IF NOT EXISTS `sensor_data` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `temperature` FLOAT DEFAULT NULL,
  `humidity` FLOAT DEFAULT NULL,
  `water_level` FLOAT DEFAULT NULL,
  `light` FLOAT DEFAULT NULL,
  `vibration` FLOAT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 2. Table for admin authentication details
CREATE TABLE IF NOT EXISTS `admindpi` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert default admin login credentials
INSERT INTO `admindpi` (`username`, `password`) VALUES ('admin', 'admin123');
```

---

## 🚀 Installation & Quick Start

### 1. Backend Web Server Configuration
1. Install a local web server packager (e.g., **XAMPP** or **AppServ**) on Windows.
2. Clone or copy the `mini-project-iot` workspace into your server's root directory, typically `C:/xampp/htdocs/`.
3. Launch **Apache** and **MySQL** from your XAMPP Control Panel.
4. Import the SQL commands provided above via **phpMyAdmin** (`http://localhost/phpmyadmin/`) or any preferred MySQL client.
5. Verify database connection credentials in [database.php](file:///c:/D/iot/software_iot/miniproject-iot-smart-home/mini-project-iot/backend/config/database.php) and ensure `.env` file matches your host context for [connect.php](file:///c:/D/iot/software_iot/miniproject-iot-smart-home/mini-project-iot/backend/config/connect.php).

### 2. Edge Hardware Programming (Arduino Setup)
1. Launch **Arduino IDE**.
2. Install the necessary libraries referenced in the sketches:
   - `ESP32Servo`
   - `DHT sensor library`
   - `RTClib`
   - `LiquidCrystal I2C`
3. Wire the electronic components to the corresponding GPIO pins designated in [iot.ino](file:///c:/D/iot/software_iot/miniproject-iot-smart-home/mini-project-iot/data/iot.ino) and [micro.ino](file:///c:/D/iot/software_iot/miniproject-iot-smart-home/mini-project-iot/data/micro.ino).
4. Configure your Wi-Fi credentials in the ESP32 source code and set the destination URL to point to the host IP of your local PHP web server.
5. Compile and flash the firmware onto the microcontrollers.

### 3. Running the Dashboard Web Interface
1. Launch your browser and navigate to: `http://localhost/mini-project-iot/frontend/pages/login.php`
2. Log in using the admin account credentials (`admin` / `admin123`).
3. Upon success, you will be redirected to [dashboard.php](file:///c:/D/iot/software_iot/miniproject-iot-smart-home/mini-project-iot/frontend/pages/dashboard.php) to monitor your smart home system in real time!

---

## 🛠️ Main Reference Links

- **Main Edge Firmware**: [iot.ino](file:///c:/D/iot/software_iot/miniproject-iot-smart-home/mini-project-iot/data/iot.ino)
- **Backend Components**:
  - Insert Logger API: [insert_data.php](file:///c:/D/iot/software_iot/miniproject-iot-smart-home/mini-project-iot/backend/controllers/insert_data.php)
  - Interactive Overrides Controller: [control.php](file:///c:/D/iot/software_iot/miniproject-iot-smart-home/mini-project-iot/backend/controllers/control.php)
- **Frontend Components**:
  - Login Page: [login.php](file:///c:/D/iot/software_iot/miniproject-iot-smart-home/mini-project-iot/frontend/pages/login.php)
  - Main Dashboard UI: [dashboard.php](file:///c:/D/iot/software_iot/miniproject-iot-smart-home/mini-project-iot/frontend/pages/dashboard.php)
  - Dynamic Display Updater: [data.js](file:///c:/D/iot/software_iot/miniproject-iot-smart-home/mini-project-iot/frontend/js/data.js)
  - Dashboard Style Sheet: [dashboard.css](file:///c:/D/iot/software_iot/miniproject-iot-smart-home/mini-project-iot/frontend/css/dashboard.css)

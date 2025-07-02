document.addEventListener("DOMContentLoaded", function () {
    function fetchData() {
        fetch("/mini-project-iot/backend/controllers/fetch_data.php")
            .then((response) => response.json())
            .then((data) => {
                console.log("Fetched data:", data);

                if (!data || data.length === 0) {
                    console.error("No data received!");
                    return;
                }

                const sensors = {
                    waterLevel: document.querySelector("#waterLevel .data"),
                    temperature: document.querySelector("#temperature .data"),
                    humidity: document.querySelector("#humidity .data"),
                    light: document.querySelector("#light .data"),
                    vibration: document.querySelector("#vibration .data"),
                };

                Object.keys(sensors).forEach((key) => {
                    if (!sensors[key]) {
                        console.error(` Element #${key} หรือ .data ไม่พบ`);
                    }
                });

                const sensorValues = {
                    waterLevel: parseFloat(data[0].water_level) || 0,
                    temperature: parseFloat(data[0].temperature) || 0,
                    humidity: parseFloat(data[0].humidity) || 0,
                    light: parseFloat(data[0].light) || 0,
                    vibration: parseFloat(data[0].vibration) || 0,
                };

                console.log("Parsed Sensor Values:", sensorValues);

                Object.keys(sensorValues).forEach((key) => {
                    if (sensors[key]) {
                        sensors[key].textContent =
                            sensorValues[key] !== null ? sensorValues[key] : "N/A";
                    }
                });

                updateSensorStyles(sensorValues);
            })
            .catch((error) => console.error("Error fetching data:", error));
    }

    function updateSensorStyles(values) {
        const sensors = {
            waterLevel: document.querySelector("#waterLevel"),
            temperature: document.querySelector("#temperature"),
            humidity: document.querySelector("#humidity"),
            light: document.querySelector("#light"),
            vibration: document.querySelector("#vibration"),
        };

        sensors.waterLevel.classList.remove(
            "water-normal",
            "water-warning",
            "water-danger"
        );
        sensors.temperature.classList.remove(
            "temp-normal",
            "temp-warning",
            "temp-danger",
            "temp-cold"
        );
        sensors.humidity.classList.remove(
            "humidity-normal",
            "humidity-warning",
            "humidity-danger"
        );
        sensors.light.classList.remove(
            "light-normal",
            "light-warning",
            "light-danger"
        );
        sensors.vibration.classList.remove("vibration-normal", "vibration-danger");

        // เรียกใช้ฟังก์ชันเมื่อระดับน้ำเปลี่ยนแปลง
        if (values.waterLevel >= 40) {
            sensors.waterLevel.classList.add("water-danger");
            sensors.waterLevel.querySelector(".status-box").textContent =
                "Danger Flood !!! 🌊";
            // updateWaterLevel(values.waterLevel);
        } else if (values.waterLevel >= 35) {
            sensors.waterLevel.classList.add("water-warning");
            sensors.waterLevel.querySelector(".status-box").textContent =
                "Warning Flood 🌊";
            // updateWaterLevel(values.waterLevel);
        } else {
            sensors.waterLevel.classList.add("water-normal");
            sensors.waterLevel.querySelector(".status-box").textContent =
                "Normal ⛲️";
            // updateWaterLevel(0);
        }

        if (values.temperature >= 35) {
            sensors.temperature.classList.add("temp-danger");
            sensors.temperature.querySelector(".status-box").textContent =
                "Hot !!! 🌡️";
        } else if (values.temperature >= 28) {
            sensors.temperature.classList.add("temp-warning");
            sensors.temperature.querySelector(".status-box").textContent = "Warm 🌞";
        } else if (values.temperature > 15) {
            sensors.temperature.classList.add("temp-normal");
            sensors.temperature.querySelector(".status-box").textContent =
                "The Weather is Good 🌬️";
        } else {
            sensors.temperature.classList.add("temp-cold");
            sensors.temperature.querySelector(".status-box").textContent = "Cold ☃️˚";
            // setInterval(createSnowflake, 500);
        }

        if (values.humidity >= 75) {
            sensors.humidity.classList.add("humidity-danger");
            sensors.humidity.querySelector(".status-box").textContent =
                "It will Rain !!! 🌦️";

            // setInterval(createRain, 200);
        } else if (values.humidity >= 50) {
            sensors.humidity.classList.add("humidity-warning");
            sensors.humidity.querySelector(".status-box").textContent =
                "Very Humid ☁";
        } else {
            sensors.humidity.classList.add("humidity-normal");
            sensors.humidity.querySelector(".status-box").textContent =
                "Clearing Up ✨";
        }

        if (values.light >= 70) {
            sensors.light.classList.add("light-normal");
            sensors.light.querySelector(".status-box").textContent = "Shine 🌟";
        } else if (values.light >= 40) {
            sensors.light.classList.add("light-warning");
            sensors.light.querySelector(".status-box").textContent =
                "Medium Light ✨";
        } else {
            sensors.light.classList.add("light-danger");
            sensors.light.querySelector(".status-box").textContent =
                "Very Dark !!! 🌑";
        }
        if (values.light <= 30) {
            document.querySelector("#light .status-box").classList.add("blinking");
        } else {
            document.querySelector("#light .status-box").classList.remove("blinking");
        }
        if (values.vibration >= 10) {
            document.querySelector("#vibration .status-box").classList.add("shake");
            setTimeout(() => {
                document
                    .querySelector("#vibration .status-box")
                    .classList.remove("shake");
            }, 2000);
        }
        if (values.vibration >= 5) {
            sensors.vibration.classList.add("vibration-danger");
            sensors.vibration.querySelector(".status-box").textContent =
                "Danger !!! Earthquake ♒︎";
        } else {
            sensors.vibration.classList.add("vibration-normal");
            sensors.vibration.querySelector(".status-box").textContent = "Normal 〰";
        }
    }

    setInterval(fetchData, 2000);
    fetchData();
});
function updateCurrentTime() {
    const currentTime = new Date().toLocaleString("th-TH", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        hour12: false,
    });
    document.getElementById("current-time").textContent = currentTime;
}
setInterval(updateCurrentTime, 1000);
updateCurrentTime();

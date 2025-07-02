const serverUrl = "http://172.25.11.10/mini-project-iot/backend/controllers/control.php";
const serverMode = "http://172.25.11.10/mini-project-iot/backend/controllers/control_mode.php";


let currentMode = "manual";
function toggleMode(mode) {
   
    currentMode = mode;
    let manualBtn = document.getElementById("manualBtn");
    let sensorBtn = document.getElementById("sensorBtn");

    if (mode === "manual") {
        manualBtn.classList.add("active");
        manualBtn.classList.remove("inactive");

        sensorBtn.classList.add("inactive");
        sensorBtn.classList.remove("active");

        setControlsEnabled(true);
    } else {
        sensorBtn.classList.add("active");
        sensorBtn.classList.remove("inactive");

        manualBtn.classList.add("inactive");
        manualBtn.classList.remove("active");

        setControlsEnabled(false);
    }

    fetch(serverMode + "?mode=" + currentMode)
        
}


function toggleMode1(state) {
    fetch(severMode + "?mode=" + state);
}

function setControlsEnabled(enabled) {
    document.getElementById("ledOnBtn").disabled = !enabled;
    document.getElementById("ledOffBtn").disabled = !enabled;
    document.getElementById("openGateBtn").disabled = !enabled;
    document.getElementById("closeGateBtn").disabled = !enabled;
}

function toggleLED(state) {
    let lightIcon = document.getElementById("lightStatus").querySelector(".material-icons");
    let lightText = document.getElementById("lightText");

    if (state === "on") {
        lightIcon.textContent = "lightbulb";
        lightText.textContent = "Light: On";
    } else {
        lightIcon.textContent = "lightbulb_outline";
        lightText.textContent = "Light: Off";
    }

    fetch(serverUrl + "?led=" + state)
        .then(response => response.json())
        .then(data => console.log("LED toggled:", data))
        .catch(error => console.error("Error toggling LED:", error));
}

function setServoAngle(angle) {
    let gateIcon = document.getElementById("gateStatus").querySelector(".material-icons");
    let gateText = document.getElementById("gateText");

    if (angle === "50") {
        gateIcon.textContent = "meeting_room";
        gateText.textContent = "Dam Gate: Open";
    } else {
        gateIcon.textContent = "door_front"
        gateText.textContent = "Dam Gate: Close";
    }

    fetch(serverUrl + "?servo=" + angle)
        .then(response => response.json())
        .then(data => console.log("Gate toggled:", data))
        .catch(error => console.error("Error toggling gate:", error));
}

function toggleMode1(state) {
    fetch(severMode + "?mode=" + state);
}
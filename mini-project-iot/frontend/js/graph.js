document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("myChart").getContext("2d");

    const gradientBlue = ctx.createLinearGradient(0, 0, 0, 400);
    gradientBlue.addColorStop(0, "rgba(0, 123, 255, 0.5)");
    gradientBlue.addColorStop(1, "rgba(0, 123, 255, 0.1)");

    const gradientRed = ctx.createLinearGradient(0, 0, 0, 400);
    gradientRed.addColorStop(0, "rgba(255, 99, 132, 0.5)");
    gradientRed.addColorStop(1, "rgba(255, 99, 132, 0.1)");

    const gradientGreen = ctx.createLinearGradient(0, 0, 0, 400);
    gradientGreen.addColorStop(0, "rgba(40, 167, 69, 0.5)");
    gradientGreen.addColorStop(1, "rgba(40, 167, 69, 0.1)");

    const gradientOrange = ctx.createLinearGradient(0, 0, 0, 400);
    gradientOrange.addColorStop(0, "rgba(255, 159, 64, 0.5)");
    gradientOrange.addColorStop(1, "rgba(255, 159, 64, 0.1)");

    const gradientPurple = ctx.createLinearGradient(0, 0, 0, 400);
    gradientPurple.addColorStop(0, "rgba(153, 102, 255, 0.5)");
    gradientPurple.addColorStop(1, "rgba(153, 102, 255, 0.1)");

    const myChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: [],
            datasets: [
                {
                    label: "Water Level",
                    data: [],
                    borderColor: "rgba(0, 123, 255, 1)",
                    backgroundColor: gradientBlue,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 0,
                },
                {
                    label: "Temperature",
                    data: [],
                    borderColor: "rgba(255, 99, 132, 1)",
                    backgroundColor: gradientRed,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 0,
                },
                {
                    label: "Humidity",
                    data: [],
                    borderColor: "rgba(40, 167, 69, 1)",
                    backgroundColor: gradientGreen,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 0,
                },
                {
                    label: "Light",
                    data: [],
                    borderColor: "rgba(255, 159, 64, 1)",
                    backgroundColor: gradientOrange,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 0,
                },
                {
                    label: "Vibration",
                    data: [],
                    borderColor: "rgba(153, 102, 255, 1)",
                    backgroundColor: gradientPurple,
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 0,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: "GRAPH SENSOR DATA",
                    font: {
                        size: 18,
                        weight: "bold",
                    },
                    color: "#333",
                    padding: 20,
                },
                legend: {
                    display: true,
                    position: "top",
                    labels: {
                        font: {
                            size: 18,
                            weight: "bold",
                        },
                        color: "#555",
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: "circle",
                    },
                },
                tooltip: {
                    mode: "index",
                    intersect: false,
                    backgroundColor: "rgba(0,0,0,0.8)",
                    titleColor: "#fff",
                    bodyColor: "#fff",
                    borderColor: "#ccc",
                    borderWidth: 1,
                    cornerRadius: 8,
                    titleFont: { size: 14, weight: "bold" },
                    bodyFont: { size: 12 },
                    padding: 12,
                },
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: "TIME",
                        color: "#555",
                        font: {
                            size: 15,
                            weight: "bold",
                        },
                        padding: 10,
                    },
                    ticks: {
                        color: "#333",
                        font: {
                            size: 12,
                        },
                    },
                    grid: {
                        color: "rgba(200, 200, 200, 0.2)",
                        lineWidth: 1,
                    },
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "VALUES",
                        color: "#555",
                        font: {
                            size: 15,
                            weight: "bold",
                        },
                        padding: 10,
                    },
                    ticks: {
                        color: "#333",
                        font: {
                            size: 12,
                        },
                    },
                    grid: {
                        color: "rgba(200, 200, 200, 0.2)",
                        lineWidth: 1,
                    },
                },
            },
            animation: false,
            interaction: {
                mode: "nearest",
                intersect: false,
            },
        },
    });

    async function fetchSensorData() {
        try {
            const response = await fetch("/mini-project-iot/backend/controllers/fetch_graph.php");
            const data = await response.json();

            if (data.error) {
                console.error("Error fetching data:", data.error);
                return;
            }

            const formattedLabels = data.map((item) => {
                const date = new Date(item.created_at);
                return date
                    .toLocaleString("en-GB", {
                        day: "2-digit",
                        month: "2-digit",
                        hour: "2-digit",
                        minute: "2-digit",
                        hour12: false,
                    })
                    .replace(",", "");
            });

            myChart.data.labels = formattedLabels;
            myChart.data.datasets[0].data = data.map((item) => item.water_level);
            myChart.data.datasets[1].data = data.map((item) => item.temperature);
            myChart.data.datasets[2].data = data.map((item) => item.humidity);
            myChart.data.datasets[3].data = data.map((item) => item.light);
            myChart.data.datasets[4].data = data.map((item) => item.vibration);

            myChart.update();
        } catch (error) {
            console.error("Error fetching sensor data:", error);
        }
    }

    setInterval(fetchSensorData, 500);
    fetchSensorData();
});

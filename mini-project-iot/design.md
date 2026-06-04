# UI/UX & Design Specification (design.md)

This document provides styling tokens, layouts, transitions, animations, and color guidelines implemented in the DPI Dashboard frontend.

---

## 🎨 Design Tokens & Color Palettes

The dashboard utilizes high-contrast layouts and modern typography to display environmental indicators clearly and intuitively.

### 1. Base Variables & Primary Themes
The colors are declared as CSS Variables within the `:root` pseudo-selector of [dashboard.css](file:///c:/D/iot/software_iot/miniproject-iot-smart-home/mini-project-iot/frontend/css/dashboard.css):
- **Primary / Success**: `#41f1b6` (Neon green color representing running systems).
- **Danger**: `#ff7782` (Warm red-pink color indicating system faults or threat warnings).
- **Dark**: `#363949` (Graphite-slate color for texts, header tags, and container elements).
- **Info Dark**: `#7d8da1` (Muted slate color for labels and subheadings).
- **Light / Background**: `rgba(132, 139, 200, 0.18)` / Soft pastel gradient transitions (`#f6f6f9` to `#ebfaf6`) creating a premium interface.

### 2. Environmental Warning States
Different color codes indicate warning severities for each indicator, loaded via [index.css](file:///c:/D/iot/software_iot/miniproject-iot-smart-home/mini-project-iot/frontend/css/index.css):

| Sensor Metric | Normal State | Warning State | Danger State | Special State |
| :--- | :--- | :--- | :--- | :--- |
| **Water Level** | `#168dcd` (Water Blue) | `#223c9b` (Deep Blue) | `#c30202` (Crimson Alert) | - |
| **Temperature** | `#36b9e1` (Cyan Normal) | `#c65c32` (Amber Warm) | `#ee2607` (Red Hot) | `#69b9ef` (Ice Cold) |
| **Humidity** | `#27d46f` (Soft Green) | `#23ccb3` (Sea Teal) | `#312694` (Rain Purple) | - |
| **Light Intensity** | `#e29015` (Sunny Yellow) | `rgb(206,136,44)` (Dusk Orange) | `rgb(173,132,78)` (Dim Brown) | - |
| **Vibration Level** | `#ad5511` (Soil Brown) | - | `#df0303` (Earthquake Red) | - |

---

## ✨ Micro-Animations & Dynamic Feedback

Visual animations help administrators identify anomalies at a single glance:

### 1. Earthquake Threat Vibration Alert
- **Class Trigger**: `.shake` (Defined in [index.css](file:///c:/D/iot/software_iot/miniproject-iot-smart-home/mini-project-iot/frontend/css/index.css#L399))
- **Logic**: Executes a keyframe animation `@keyframes shake` that oscillates the target element rapidly along X and Y axes (1-3px translation) and tilts it slightly (-1° to 1° rotation).
- **Trigger Condition**: When the vibration sensor reading exceeds a value of 10 inside [data.js](file:///c:/D/iot/software_iot/miniproject-iot-smart-home/mini-project-iot/frontend/js/data.js).

### 2. Low Light Pulsing Notice
- **Class Trigger**: `.blinking` (Defined in [index.css](file:///c:/D/iot/software_iot/miniproject-iot-smart-home/mini-project-iot/frontend/css/index.css#L419))
- **Logic**: Calls a pulsing keyframe animation `@keyframes blink` that smoothly decreases opacity to `0.3` and returns to `1.0` every 1.5 seconds.
- **Trigger Condition**: Activated when light levels drop below 30% to signal dark conditions.

### 3. Atmospheric Overlay Particles
Placeholder classes are prepared for rendering weather conditions directly onto the screen background:
- **Rain Particle Effect**: `.rain` drops white lines down the viewport utilizing `@keyframes rain-fall`.
- **Snow Particle Effect**: `.snowflake` falls down the viewport utilizing `@keyframes snowfall`.
- **Flood Simulation**: `.flood-container` and `.flood-wave` simulate rising blue water using `@keyframes wave-up-down` translation offsets.

---

## 📱 Component Design & Layouts

### 1. Interactive Button Toggles
- **Active Controls**: Styled with the primary neon background (`--clr-primary`) to display selection status.
- **Inactive Controls**: Styled with transparent backdrops and dark borders.
- **Disabled State**: When the dashboard is set to Sensor (Auto) Mode, controls for the LED and Dam Gate are appended with the `disabled` attribute, turning them light gray with a `not-allowed` pointer cursor to prevent command collisions.

### 2. Graphic Charting Canvas (Chart.js Configs)
The historical analytics line chart uses linear gradient fills beneath its trend lines (defined in [graph.js](file:///c:/D/iot/software_iot/miniproject-iot-smart-home/mini-project-iot/frontend/js/graph.js)):
- **Water Level**: Filled with soft blue gradient (`rgba(0, 123, 255, 0.5)` to `rgba(0, 123, 255, 0.1)`).
- **Temperature**: Filled with soft red gradient (`rgba(255, 99, 132, 0.5)` to `rgba(255, 99, 132, 0.1)`).
- **Humidity**: Filled with soft green gradient (`rgba(40, 167, 69, 0.5)` to `rgba(40, 167, 69, 0.1)`).
- **Light Intensity**: Filled with soft orange gradient (`rgba(255, 159, 64, 0.5)` to `rgba(255, 159, 64, 0.1)`).
- **Vibration**: Filled with soft purple gradient (`rgba(153, 102, 255, 0.5)` to `rgba(153, 102, 255, 0.1)`).

---

## ✍️ Guidelines for Frontend Developers & Designers
- **Typography**: The primary typeface is the Google Font **Kanit**, ensuring consistent readability for Thai and English characters.
- **Responsive Layout**: Designed with CSS Grid and Flexbox. Viewports narrower than 600px automatically scale control panel buttons to full width to facilitate mobile touch controls.
- **Hover Micro-interactions**: Interactive components have a CSS `transition: all 0.3s ease` that scales elements (`transform: scale(1.05)`) when hovered, providing tactile feedback.

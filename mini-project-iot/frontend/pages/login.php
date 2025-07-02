<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <div class="container">
        <div class="form-box login">
            <?php
            session_start();
            include_once(dirname(__DIR__, 2) . "/backend/config/database.php");
            include_once(dirname(__DIR__, 2) . "/backend/controllers/user-login.php");

            $connectDB = new Database();
            $db = $connectDB->getConnection();

            $user = new UserLogin($db);

            if (isset($_POST['signin'])) {
                $user->setUsername($_POST['username']);
                $user->setPassword($_POST['password']);

                if ($user->usernameNotExits()) {
                    echo "<div class='alert' role='alert'>ชื่อผู้ใช้ไม่ถูกต้อง</div>";
                } else {
                    if ($user->verifyPassword()) {
                        $_SESSION['username'] = $_POST['username'];
                        header("Location: dashboard.php");
                        exit();
                    } else {
                        echo "<div class='alert' role='alert'>รหัสผ่านไม่ถูกต้อง</div>";
                    }
                }
            }
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

                <h1>Login</h1>
                <div class="input-box">
                    <input type="text" name="username" placeholder="Username" required>
                    <i class='bx bxs-user'></i>
                </div>
                <div class="input-box">
                    <input type="password" name="password" placeholder="Password" required>
                    <i class='bx bxs-lock-alt'></i>
                </div>
                <button type="submit" name="signin" class="btn">Login</button>
            </form>
        </div>
        <div class="message-box">
            <div class="message-panel">
                <img src="../img/Build.png" class="img">
                <h2>Hello, Wellcome to</h2>
                <h1>DPI DASHBOARD</h1>
            </div>
        </div>
    </div>
</body>

</html>
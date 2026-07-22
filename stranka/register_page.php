<?php
session_start();
require 'db_config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];

    if($password !== $password_repeat){
        $error = "Heslá sa nezhodujú!";
    } else {
        // hash hesla
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // kontrola či už existuje username
        $check = $pdo->prepare("SELECT * FROM pouzivatelia WHERE username = ?");
        $check->execute([$username]);
        if($check->rowCount() > 0){
            $error = "Používateľ s týmto menom už existuje!";
        } else {
            $insert = $pdo->prepare("INSERT INTO pouzivatelia (username, email, password) VALUES (?, ?, ?)");
            $insert->execute([$username, $email, $password_hash]);
            $_SESSION['username'] = $username;
            header("Location: rezervacia.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>
<link rel="stylesheet" href="style.css?v=2">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="register-page">
<div class="wrapper">
    <form action="register_page.php" method="post">
        <h1>REGISTER</h1>

        <div class="input-box">
            <input type="text" name="username" placeholder="Username" required>
            <i class='bx bxs-user'></i>
        </div>

        <div class="input-box">
            <input type="email" name="email" placeholder="Your Email" required>
            <i class='bx bxl-gmail' ></i>
        </div>

        <div class="input-box">
            <input type="password" name="password" placeholder="Password" required>     
            <i class='bx bxs-lock-alt' ></i>
        </div>

        <div class="input-box">
            <input type="password" name="password_repeat" placeholder="Repeat your password" required>     
            <i class='bx bxs-lock-alt' ></i>
        </div>

        <div class="remember-forget">
            <label> 
                <input type="checkbox" required>
                 <img class="prvy" src="obrazky/checkbox1.png">
                <img class="hover" src="obrazky/hover.png">
                <img class="druhy" src="obrazky/checkbox.png"> 
            <span class="suhlasim">I agree all statements in <a href="#" class="pravidla"> Terms of service</a></span></label>
        </div>

        <button type="submit" class="btn"> Sign up </button>

        <?php if(isset($error)) echo "<p class='rezervovane'>$error</p>"; ?>

        <div class="login-link">
            <p>Already have an account? <a href="login_page.php" class="pravidla">Login here</a></p>
        </div>
    </form>
</div>
</body>
</html>

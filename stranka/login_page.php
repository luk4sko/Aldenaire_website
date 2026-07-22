<?php
session_start();
require 'db_config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['Username'];
    $password = $_POST['Password'];

    $stmt = $pdo->prepare("SELECT * FROM pouzivatelia WHERE username = ?");
    $stmt->execute([$username]);
    if($stmt->rowCount() > 0){
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if(password_verify($password, $user['password'])){
            $_SESSION['username'] = $username;
            header("Location: rezervacia.php");
            exit();
        } else {
            $error = "Nesprávne údaje!";
        }
    } else {
        $error = "Používateľ neexistuje!";
    }
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" href="style.css?v=8">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="login-page">
<div class="wrapper">
    <form action="login_page.php" method="post">  
      <h1> LOGIN </h1>

        <div class="input-box">
            <input type="text" name="Username" placeholder="Username" required>
            <i class='bx bxs-user'></i>
        </div>

        <div class="input-box">
            <input type="password" name="Password" placeholder="Password" required>     
            <i class='bx bxs-lock-alt' ></i>
        </div>

        <div class="remember-forget">
            <label> 
                <input type="checkbox">
                <img class="prvy" src="obrazky/checkbox1.png">
                <img class="hover" src="obrazky/hover.png">
                <img class="druhy" src="obrazky/checkbox.png">
                <span class="pamataj">Remember me</span>
            </label>
            <a href="#" class="zabudol"> Forgot password? </a>
        </div>

        <button type="submit" class="btn"> Login </button>

        <?php if(isset($error)) echo "<p class='rezervovane'>$error</p>"; ?>

        <div class="register-link">
            <p>Don't have an account? <a href="register_page.php" class="registerr">Register</a></p>
        </div>

    </form>
</div>
</body>
</html>

<?php
/*
 * login_page.php – prihlásenie používateľa.
 * Skontroluje meno a heslo oproti databáze. Ak sedia, uloží meno do
 * $_SESSION (session = "pamäť" prihlásenia) a presmeruje na rezerváciu.
 */
/*
 * "Zapamätať si ma": ak používateľ zaškrtol políčko, predĺžime platnosť
 * prihlásenia (session cookie) na 30 dní. Inak platí len do zatvorenia
 * prehliadača. Toto sa MUSÍ nastaviť ešte pred session_start().
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remember'])) {
    session_set_cookie_params(30 * 24 * 60 * 60); // 30 dní (v sekundách)
}

session_start();               // spustí session – aby si web pamätal, kto je prihlásený
require 'db_config.php';        // pripojenie k databáze ($pdo)

// Kód sa vykoná len keď používateľ odoslal formulár (metóda POST)
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = $_POST['Username'];   // meno z formulára
    $password = $_POST['Password'];   // heslo z formulára

    // Nájdeme používateľa v databáze podľa mena.
    // "?" je zástupný znak – hodnotu doň bezpečne dosadí execute() (ochrana pred SQL injection).
    $stmt = $pdo->prepare("SELECT * FROM pouzivatelia WHERE username = ?");
    $stmt->execute([$username]);

    if($stmt->rowCount() > 0){                     // ak taký používateľ existuje
        $user = $stmt->fetch(PDO::FETCH_ASSOC);     // načítame jeho údaje

        // Heslá sú v databáze zašifrované. password_verify porovná zadané heslo so zašifrovaným.
        if(password_verify($password, $user['password'])){
            $_SESSION['username'] = $username;      // zapamätáme si prihláseného používateľa
            header("Location: rezervacia.php");     // presmerujeme ho ďalej
            exit();
        } else {
            $error = "Nesprávne údaje!";            // zlé heslo
        }
    } else {
        $error = "Používateľ neexistuje!";          // také meno v databáze nie je
    }
}
?>

<!DOCTYPE html>
<html lang="sk">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Prihlásenie</title>
<link rel="stylesheet" href="style.css?v=12">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="login-page">
<div class="wrapper">
    <form action="login_page.php" method="post">
      <h1> PRIHLÁSENIE </h1>

        <div class="input-box">
            <input type="text" name="Username" placeholder="Používateľské meno" required>
            <i class='bx bxs-user'></i>
        </div>

        <div class="input-box">
            <input type="password" name="Password" placeholder="Heslo" required>
            <i class='bx bxs-lock-alt' ></i>
        </div>

        <div class="remember-forget">
            <label>
                <!-- name="remember" -> podľa neho PHP zistí, či je políčko zaškrtnuté -->
                <input type="checkbox" name="remember">
                <img class="prvy" src="obrazky/checkbox1.png">
                <img class="hover" src="obrazky/hover.png">
                <img class="druhy" src="obrazky/checkbox.png">
                <span class="pamataj">Zapamätať si ma</span>
            </label>
            <a href="#" class="zabudol"> Zabudol si heslo? </a>
        </div>

        <button type="submit" class="btn"> Prihlásiť sa </button>

        <?php if(isset($error)) echo "<p class='rezervovane'>$error</p>"; ?>

        <div class="register-link">
            <p>Nemáš účet? <a href="register_page.php" class="registerr">Zaregistruj sa</a></p>
        </div>

    </form>
</div>
</body>
</html>

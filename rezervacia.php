<?php
session_start();
date_default_timezone_set('Europe/Bratislava');
if(!isset($_SESSION['username'])){
    header("Location: login_page.php");
    exit();
}

require 'db_config.php';

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $typ = $_POST['Typ'];
    $trener = $_POST['Trener'];
    $datum = $_POST['Datum'];
    $cas = $_POST['Cas'];

    // Nastavenie ceny podľa trénera
if ($trener === "Marek") {
    $cena = 25;
} elseif ($trener === "Peto") {
    $cena = 25;
} elseif ($trener === "Marko") {
    $cena = 35;
}


    if (strtotime($datum) < strtotime(date('Y-m-d'))) {
        $rezervovane = "Nemôžeš zadať dátum z minulosti!";
    } else {

    // kontrola času ak je dnes
if ($datum == date('Y-m-d')) {

    // začiatok intervalu (napr 15:00 z 15:00-17:00)
    $casStart = explode('-', $cas)[0];

    // spoj datum + cas
    $startDateTime = strtotime($datum . ' ' . $casStart);
    $now = time();

    if ($now >= $startDateTime) {
        $rezervovane = "Tento čas už prešiel!";
    }
}
        if(!isset($rezervovane)) {
        $check_stmt = $pdo->prepare("SELECT * FROM treningy WHERE datum = ? AND cas = ? AND trener = ?");
        $check_stmt->execute([$datum, $cas, $trener]);

        if($check_stmt->rowCount() > 0){
            $rezervovane = "Tento tréning už je rezervovaný v zadanom čase!";
        } else {
            $insert_stmt = $pdo->prepare("INSERT INTO treningy (meno, typ, trener, cena, datum, cas) VALUES (?, ?, ?, ?, ?, ?)");
            if($insert_stmt->execute([$username, $typ, $trener, $cena, $datum, $cas])) {
                $odpoved = "Tréning úspešne pridaný!";
            } else {
                $odpoved = "Chyba pri ukladaní tréningu!";
            }
        }
    }
}
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
<meta charset="UTF-8">
<title>Tréningy</title>
<link rel="stylesheet" href="style.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="rezervacia_page">
<div class="fixed-header">
    <?php include 'includes/header.php'; ?>
    </div>
<main>
    <a href="logout.php" class="logout-btn">Odhlásiť sa</a>
    <div class="container">
        <div class="left-column">
            <h1>Pridať tréning</h1>

            <?php if(isset($odpoved)) echo "<p class='odpoved'>$odpoved</p>"; ?>
            <?php if(isset($rezervovane)) echo "<p class='rezervovane'>$rezervovane</p>"; ?>

            <form action="" method="post">
                <label>Typ tréningu:</label>
                <select name="Typ" class="arrow" required>
                    <option value="Beh">Beh</option>
                    <option value="Fitko">Fitko</option>
                </select>

                <label>Tréner:</label>
                <select name="Trener" class="arrow" required>
                    <option value="Peto">Peto - 25€</option>
                    <option value="Marko">⭐ Marko - 35€ </option>
                    <option value="Marek">Marek - 25€</option>
                </select>

                <label>Dátum:</label>
                <input type="date" name="Datum" required min="<?php echo date('Y-m-d'); ?>">

                <label>Časové rozhranie:</label>
                <select name="Cas" class="arrow" required>
                    <option value="8:00-10:00">8:00-10:00</option>
                    <option value="11:00-13:00">11:00-13:00</option>
                    <option value="15:00-17:00">15:00-17:00</option>
                </select>

                <input type="submit" value="Odoslať">
            </form>
        </div>

        <div class="right-column">
            <h2>Všetky tréningy</h2>
            <table>
                <tr>
                    <th>Meno</th>
                    <th>Typ</th>
                    <th>Tréner</th>
                    <th>Cena</th>
                    <th>Dátum</th>
                    <th>Čas</th>
                </tr>
                <?php
                $result = $pdo->query("SELECT * FROM treningy ORDER BY datum, cas");
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                            <td>{$row['meno']}</td>
                            <td>{$row['typ']}</td>
                            <td>{$row['trener']}</td>
                            <td>{$row['cena']}€</td>
                            <td>".date('d.m.Y', strtotime($row['datum']))."</td>
                            <td>{$row['cas']}</td>
                          </tr>";
                }
                ?>
            </table>
        </div>
    </div>
</main>
    <?php include 'includes/footer.php'; ?>
</body>
</html>



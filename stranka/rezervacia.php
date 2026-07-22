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

    // Nastavenie ceny podؤ¾a trأ©nera
if ($trener === "Marek") {
    $cena = 25;
} elseif ($trener === "Peto") {
    $cena = 25;
} elseif ($trener === "Marko") {
    $cena = 35;
}


    if (strtotime($datum) < strtotime(date('Y-m-d'))) {
        $rezervovane = "Nemأ´إ¾eإ، zadaإ¥ dأ،tum z minulosti!";
    } else {

    // kontrola ؤچasu ak je dnes
if ($datum == date('Y-m-d')) {

    // zaؤچiatok intervalu (napr 15:00 z 15:00-17:00)
    $casStart = explode('-', $cas)[0];

    // spoj datum + cas
    $startDateTime = strtotime($datum . ' ' . $casStart);
    $now = time();

    if ($now >= $startDateTime) {
        $rezervovane = "Tento ؤچas uإ¾ preإ،iel!";
    }
}
        if(!isset($rezervovane)) {
        $check_stmt = $pdo->prepare("SELECT * FROM treningy WHERE datum = ? AND cas = ? AND trener = ?");
        $check_stmt->execute([$datum, $cas, $trener]);

        if($check_stmt->rowCount() > 0){
            $rezervovane = "Tento trأ©ning uإ¾ je rezervovanأ½ v zadanom ؤچase!";
        } else {
            $insert_stmt = $pdo->prepare("INSERT INTO treningy (meno, typ, trener, cena, datum, cas) VALUES (?, ?, ?, ?, ?, ?)");
            if($insert_stmt->execute([$username, $typ, $trener, $cena, $datum, $cas])) {
                $odpoved = "Trأ©ning أ؛speإ،ne pridanأ½!";
            } else {
                $odpoved = "Chyba pri ukladanأ­ trأ©ningu!";
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
<title>Trأ©ningy</title>
<link rel="stylesheet" href="style.css?v=6">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="rezervacia_page">
<div class="fixed-header">
    <?php include 'includes/header.php'; ?>
    </div>
<main>
    <a href="logout.php" class="logout-btn">Odhlأ،siإ¥ sa</a>
    <div class="container">
        <div class="left-column">
            <h1>Pridaإ¥ trأ©ning</h1>

            <?php if(isset($odpoved)) echo "<p class='odpoved'>$odpoved</p>"; ?>
            <?php if(isset($rezervovane)) echo "<p class='rezervovane'>$rezervovane</p>"; ?>

            <form action="" method="post">
                <label>Typ trأ©ningu:</label>
                <select name="Typ" class="arrow" required>
                    <option value="Beh">Beh</option>
                    <option value="Fitko">Fitko</option>
                </select>

                <label>Trأ©ner:</label>
                <select name="Trener" class="arrow" required>
                    <option value="Peto">Peto - 25â‚¬</option>
                    <option value="Marko">â­گ Marko - 35â‚¬ </option>
                    <option value="Marek">Marek - 25â‚¬</option>
                </select>

                <label>Dأ،tum:</label>
                <input type="date" name="Datum" required min="<?php echo date('Y-m-d'); ?>">

                <label>ؤŒasovأ© rozhranie:</label>
                <select name="Cas" class="arrow" required>
                    <option value="8:00-10:00">8:00-10:00</option>
                    <option value="11:00-13:00">11:00-13:00</option>
                    <option value="15:00-17:00">15:00-17:00</option>
                </select>

                <input type="submit" value="Odoslaإ¥">
            </form>
        </div>

        <div class="right-column">
            <h2>Vإ،etky trأ©ningy</h2>
            <table>
                <tr>
                    <th>Meno</th>
                    <th>Typ</th>
                    <th>Trأ©ner</th>
                    <th>Cena</th>
                    <th>Dأ،tum</th>
                    <th>ؤŒas</th>
                </tr>
                <?php
                $result = $pdo->query("SELECT * FROM treningy ORDER BY datum, cas");
                while($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                            <td>{$row['meno']}</td>
                            <td>{$row['typ']}</td>
                            <td>{$row['trener']}</td>
                            <td>{$row['cena']}â‚¬</td>
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



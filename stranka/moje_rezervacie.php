<?php
session_start();
date_default_timezone_set('Europe/Bratislava');
if (!isset($_SESSION['username'])) {
    header("Location: login_page.php");
    exit();
}
require 'db_config.php';

$username = $_SESSION['username'];

// Zrušenie rezervácie (len vlastnej)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['zrusit_id'])) {
    $id = (int)$_POST['zrusit_id'];
    $del = $pdo->prepare("DELETE FROM treningy WHERE id = ? AND meno = ?");
    $del->execute([$id, $username]);
    $odpoved = $del->rowCount() > 0 ? "Rezervácia bola zrušená." : "Rezerváciu sa nepodarilo zrušiť.";
}

// Načítanie rezervácií používateľa
$stmt = $pdo->prepare("SELECT * FROM treningy WHERE meno = ? ORDER BY datum, cas");
$stmt->execute([$username]);
$rezervacie = $stmt->fetchAll(PDO::FETCH_ASSOC);
$now = time();
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moje rezervácie</title>
    <link rel="stylesheet" href="style.css?v=6">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="rezervacie_page">

    <div class="fixed-header">
        <?php include 'includes/header.php'; ?>
    </div>

<main class="moje-rezervacie-page">
    <h1>Moje rezervácie</h1>

    <?php if (isset($odpoved)): ?><p class="odpoved profil-msg"><?php echo htmlspecialchars($odpoved); ?></p><?php endif; ?>

    <div class="rezervacie-actions">
        <a href="rezervacia.php" class="btn"><i class='bx bx-plus'></i> Nová rezervácia</a>
    </div>

    <?php if (count($rezervacie) === 0): ?>
        <p class="no-reviews">Zatiaľ nemáš žiadne rezervácie. <a href="rezervacia.php">Vytvor si prvú!</a></p>
    <?php else: ?>
        <div class="rezervacie-grid">
            <?php foreach ($rezervacie as $r):
                $casStart = explode('-', $r['cas'])[0];
                $start = strtotime($r['datum'] . ' ' . $casStart);
                $preslo = $start < $now;
            ?>
                <div class="rezervacia-card <?php echo $preslo ? 'preslo' : ''; ?>">
                    <div class="rez-header">
                        <span class="rez-typ"><i class='bx bx-dumbbell'></i> <?php echo htmlspecialchars($r['typ']); ?></span>
                        <?php if ($preslo): ?>
                            <span class="rez-badge past">Prešlo</span>
                        <?php else: ?>
                            <span class="rez-badge upcoming">Nadchádzajúce</span>
                        <?php endif; ?>
                    </div>
                    <ul class="rez-detaily">
                        <li><i class='bx bx-user-voice'></i> Tréner: <strong><?php echo htmlspecialchars($r['trener']); ?></strong></li>
                        <li><i class='bx bx-calendar'></i> <?php echo date('d.m.Y', strtotime($r['datum'])); ?></li>
                        <li><i class='bx bx-time'></i> <?php echo htmlspecialchars($r['cas']); ?></li>
                        <li><i class='bx bx-euro'></i> <?php echo (int)$r['cena']; ?>€</li>
                    </ul>
                    <form action="" method="post" onsubmit="return confirm('Naozaj chceš zrušiť túto rezerváciu?');">
                        <input type="hidden" name="zrusit_id" value="<?php echo (int)$r['id']; ?>">
                        <button type="submit" class="btn rez-zrusit"><i class='bx bx-trash'></i> Zrušiť</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>

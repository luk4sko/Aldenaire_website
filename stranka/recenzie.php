<?php
session_start();
require 'db_config.php';

// Spracovanie odoslanej recenzie (len ak je používateľ prihlásený)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['username'])) {
        $chyba = "Pre pridanie recenzie musíš byť prihlásený!";
    } else {
        $recenzia = trim($_POST['recenzia'] ?? '');
        $hviezdicky = (int)($_POST['hviezdicky'] ?? 0);

        if ($recenzia === '' || $hviezdicky < 1 || $hviezdicky > 5) {
            $chyba = "Prosím vyber počet hviezdičiek a napíš text recenzie.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO reviews (meno, recenzia, hviezdicky) VALUES (?, ?, ?)");
            $stmt->execute([$_SESSION['username'], $recenzia, $hviezdicky]);
            $odpoved = "Ďakujeme za tvoju recenziu!";
        }
    }
}

// Načítanie všetkých recenzií (najnovšie hore)
$reviews = $pdo->query("SELECT * FROM reviews ORDER BY datum DESC")->fetchAll(PDO::FETCH_ASSOC);

// Priemerné hodnotenie
$pocet = count($reviews);
$priemer = 0;
if ($pocet > 0) {
    $sucet = array_sum(array_column($reviews, 'hviezdicky'));
    $priemer = round($sucet / $pocet, 1);
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recenzie</title>
    <link rel="stylesheet" href="style.css?v=12">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="recenzie_page">

    <div class="fixed-header">
        <?php include 'includes/header.php'; ?>
    </div>

<main class="reviews-page">
    <h1>Recenzie</h1>

    <?php if ($pocet > 0): ?>
        <div class="reviews-summary">
            <span class="avg-number"><?php echo $priemer; ?></span>
            <span class="avg-stars">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <i class='bx <?php echo $i <= round($priemer) ? "bxs-star" : "bx-star"; ?>'></i>
                <?php endfor; ?>
            </span>
            <span class="avg-count">(<?php echo $pocet; ?> recenzií)</span>
        </div>
    <?php endif; ?>

    <!-- FORMULÁR NA PRIDANIE RECENZIE -->
    <div class="review-form-card">
        <?php if (isset($_SESSION['username'])): ?>
            <h2>Napíš svoju recenziu</h2>

            <?php if (isset($odpoved)) echo "<p class='odpoved'>$odpoved</p>"; ?>
            <?php if (isset($chyba)) echo "<p class='rezervovane'>$chyba</p>"; ?>

            <form action="" method="post" class="review-form">
                <label>Tvoje hodnotenie:</label>
                <div class="star-rating">
                    <input type="radio" id="star5" name="hviezdicky" value="5"><label for="star5"><i class='bx bxs-star'></i></label>
                    <input type="radio" id="star4" name="hviezdicky" value="4"><label for="star4"><i class='bx bxs-star'></i></label>
                    <input type="radio" id="star3" name="hviezdicky" value="3"><label for="star3"><i class='bx bxs-star'></i></label>
                    <input type="radio" id="star2" name="hviezdicky" value="2"><label for="star2"><i class='bx bxs-star'></i></label>
                    <input type="radio" id="star1" name="hviezdicky" value="1"><label for="star1"><i class='bx bxs-star'></i></label>
                </div>

                <label for="recenzia">Tvoja recenzia:</label>
                <textarea name="recenzia" id="recenzia" rows="4" placeholder="Napíš svoju skúsenosť..." required></textarea>

                <button type="submit" class="btn review-submit">Odoslať recenziu</button>
            </form>
        <?php else: ?>
            <p class="review-login-note">
                Pre pridanie recenzie sa musíš <a href="login_page.php">prihlásiť</a>.
            </p>
        <?php endif; ?>
    </div>

    <!-- ZOZNAM RECENZIÍ -->
    <div class="reviews-grid">
        <?php if ($pocet === 0): ?>
            <p class="no-reviews">Zatiaľ tu nie sú žiadne recenzie. Buď prvý!</p>
        <?php else: ?>
            <?php foreach ($reviews as $r): ?>
                <div class="review-card">
                    <div class="review-header">
                        <span class="review-name"><?php echo htmlspecialchars($r['meno']); ?></span>
                        <span class="review-stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i class='bx <?php echo $i <= $r['hviezdicky'] ? "bxs-star" : "bx-star"; ?>'></i>
                            <?php endfor; ?>
                        </span>
                    </div>
                    <p class="review-text"><?php echo nl2br(htmlspecialchars($r['recenzia'])); ?></p>
                    <span class="review-date"><?php echo date('d.m.Y', strtotime($r['datum'])); ?></span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>

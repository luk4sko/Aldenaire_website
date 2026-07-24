<?php
session_start();
date_default_timezone_set('Europe/Bratislava');
require 'db_config.php';
require 'produkty.php';

// cena dopravy podľa spôsobu doručenia
$DOPRAVA = ['adresa' => 3.90, 'packeta' => 2.90];

if (!isset($_SESSION['kosik'])) {
    $_SESSION['kosik'] = [];
}

// pridanie produktu do košíka
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pridat'])) {
    $id = (int)$_POST['pridat'];
    if (isset($produkty[$id]) && $produkty[$id]['status'] === 'Na predaj') {
        $_SESSION['kosik'][$id] = ($_SESSION['kosik'][$id] ?? 0) + 1;
    }
    header('Location: kosik.php');
    exit();
}

// pridať kus
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pripocitaj'])) {
    $id = (int)$_POST['pripocitaj'];
    if (isset($produkty[$id])) {
        $_SESSION['kosik'][$id] = ($_SESSION['kosik'][$id] ?? 0) + 1;
    }
    header('Location: kosik.php');
    exit();
}

// ubrať kus (pri 0 sa položka odstráni)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['uber'])) {
    $id = (int)$_POST['uber'];
    if (isset($_SESSION['kosik'][$id])) {
        $_SESSION['kosik'][$id]--;
        if ($_SESSION['kosik'][$id] <= 0) {
            unset($_SESSION['kosik'][$id]);
        }
    }
    header('Location: kosik.php');
    exit();
}

// odstrániť položku
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['odobrat'])) {
    $id = (int)$_POST['odobrat'];
    unset($_SESSION['kosik'][$id]);
    header('Location: kosik.php');
    exit();
}

// odoslanie objednávky
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['objednavka'])) {
    $meno    = trim($_POST['meno'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $telefon = trim($_POST['telefon'] ?? '');
    $sposob  = $_POST['sposob'] ?? '';

    // podľa spôsobu doručenia poskladáme adresu
    if ($sposob === 'adresa') {
        $ulica = trim($_POST['ulica'] ?? '');
        $mesto = trim($_POST['mesto'] ?? '');
        $psc   = trim($_POST['psc'] ?? '');
        $adresa   = "$ulica, $psc $mesto";
        $adresaOk = ($ulica !== '' && $mesto !== '' && $psc !== '');
    } elseif ($sposob === 'packeta') {
        $miesto   = trim($_POST['packeta_miesto'] ?? '');
        $adresa   = "Packeta – výdajné miesto: $miesto";
        $adresaOk = ($miesto !== '');
    } else {
        $adresa   = '';
        $adresaOk = false;
    }

    if (empty($_SESSION['kosik'])) {
        $chyba = "Košík je prázdny.";
    } elseif ($meno === '' || $email === '' || $telefon === '' || !$adresaOk) {
        $chyba = "Prosím vyplň všetky povinné údaje.";
    } else {
        // text položiek a suma
        $polozkyText = [];
        $medzisucet  = 0;
        foreach ($_SESSION['kosik'] as $id => $ks) {
            if (!isset($produkty[$id])) continue;
            $p = $produkty[$id];
            $polozkyText[] = "{$p['name']} x{$ks}";
            $medzisucet += $p['price'] * $ks;
        }
        $doprava = $DOPRAVA[$sposob];
        $spolu   = $medzisucet + $doprava;
        $polozky = implode(', ', $polozkyText);

        $stmt = $pdo->prepare("INSERT INTO objednavky (meno, email, telefon, sposob_dorucenia, adresa, polozky, spolu)
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$meno, $email, $telefon, $sposob, $adresa, $polozky, $spolu]);

        $_SESSION['kosik'] = [];   // vyprázdnime košík
        $hotovo = ['polozky' => $polozky, 'spolu' => $spolu];
    }
}

// príprava údajov na zobrazenie
$polozkyKosik = [];
$medzisucet   = 0;
foreach ($_SESSION['kosik'] as $id => $ks) {
    if (!isset($produkty[$id])) continue;
    $p = $produkty[$id];
    $spoluPolozka = $p['price'] * $ks;
    $medzisucet  += $spoluPolozka;
    $polozkyKosik[] = [
        'id' => $id, 'name' => $p['name'], 'img' => $p['img'],
        'price' => $p['price'], 'ks' => $ks, 'spolu' => $spoluPolozka,
    ];
}
$predMeno = $_SESSION['username'] ?? '';   // meno predvyplníme, ak je používateľ prihlásený
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Košík</title>
    <link rel="stylesheet" href="style.css?v=12">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="kosik_page">

    <div class="fixed-header">
        <?php include 'includes/header.php'; ?>
    </div>

<main class="kosik-page">
    <h1>Košík</h1>

    <?php if (isset($chyba)): ?>
        <p class="rezervovane profil-msg"><?php echo htmlspecialchars($chyba); ?></p>
    <?php endif; ?>

    <?php if (isset($hotovo)): ?>
        <!-- POTVRDENIE OBJEDNÁVKY -->
        <div class="kosik-hotovo">
            <i class='bx bx-check-circle'></i>
            <h2>Ďakujeme za objednávku!</h2>
            <p>Objednávka bola prijatá. Čoskoro ťa budeme kontaktovať.</p>
            <p class="kosik-hotovo-detail"><strong>Položky:</strong> <?php echo htmlspecialchars($hotovo['polozky']); ?></p>
            <p class="kosik-hotovo-detail"><strong>Spolu:</strong> <?php echo number_format($hotovo['spolu'], 2); ?> €</p>
            <a href="cennik.php" class="btn trainer-btn">Späť do obchodu</a>
        </div>

    <?php elseif (empty($polozkyKosik)): ?>
        <!-- PRÁZDNY KOŠÍK -->
        <p class="no-reviews">Košík je prázdny. <a href="cennik.php">Prejsť do obchodu</a></p>

    <?php else: ?>
        <div class="kosik-layout">

            <!-- ZOZNAM POLOŽIEK V KOŠÍKU -->
            <div class="kosik-polozky">
                <?php foreach ($polozkyKosik as $item): ?>
                    <div class="kosik-item">
                        <img src="<?php echo $item['img']; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                        <div class="kosik-item-info">
                            <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                            <p class="kosik-item-cena"><?php echo $item['price']; ?> € / kus</p>
                        </div>

                        <!-- Ovládanie počtu kusov -->
                        <div class="kosik-mnozstvo">
                            <form action="kosik.php" method="post">
                                <input type="hidden" name="uber" value="<?php echo $item['id']; ?>">
                                <button type="submit" title="Uber kus">−</button>
                            </form>
                            <span><?php echo $item['ks']; ?></span>
                            <form action="kosik.php" method="post">
                                <input type="hidden" name="pripocitaj" value="<?php echo $item['id']; ?>">
                                <button type="submit" title="Pridaj kus">+</button>
                            </form>
                        </div>

                        <div class="kosik-item-spolu"><?php echo number_format($item['spolu'], 2); ?> €</div>

                        <form action="kosik.php" method="post">
                            <input type="hidden" name="odobrat" value="<?php echo $item['id']; ?>">
                            <button type="submit" class="kosik-odstranit" title="Odstrániť"><i class='bx bx-trash'></i></button>
                        </form>
                    </div>
                <?php endforeach; ?>

                <p class="kosik-medzisucet">Medzisúčet: <strong><?php echo number_format($medzisucet, 2); ?> €</strong></p>
            </div>

            <!-- POKLADŇA – ÚDAJE A DORUČENIE -->
            <div class="kosik-pokladna">
                <h2>Doručenie a údaje</h2>
                <form action="kosik.php" method="post" class="pokladna-form">
                    <input type="hidden" name="objednavka" value="1">

                    <label>Meno a priezvisko *</label>
                    <input type="text" name="meno" value="<?php echo htmlspecialchars($predMeno); ?>" required>

                    <label>Email *</label>
                    <input type="email" name="email" required>

                    <label>Telefón *</label>
                    <input type="text" name="telefon" required>

                    <label>Spôsob doručenia *</label>
                    <div class="doprava-vyber">
                        <label class="doprava-moznost">
                            <input type="radio" name="sposob" value="adresa" checked onchange="prepniDorucenie()">
                            <span><i class='bx bx-home'></i> Na adresu (<?php echo number_format($DOPRAVA['adresa'], 2); ?> €)</span>
                        </label>
                        <label class="doprava-moznost">
                            <input type="radio" name="sposob" value="packeta" onchange="prepniDorucenie()">
                            <span><i class='bx bx-package'></i> Packeta – výdajné miesto (<?php echo number_format($DOPRAVA['packeta'], 2); ?> €)</span>
                        </label>
                    </div>

                    <!-- Polia pre doručenie NA ADRESU -->
                    <div id="poleAdresa" class="doprava-polia">
                        <label>Ulica a číslo *</label>
                        <input type="text" name="ulica">
                        <label>Mesto *</label>
                        <input type="text" name="mesto">
                        <label>PSČ *</label>
                        <input type="text" name="psc">
                    </div>

                    <!-- Pole pre PACKETA (spočiatku skryté) -->
                    <div id="polePacketa" class="doprava-polia" style="display:none;">
                        <label>Výdajné miesto Packeta *</label>
                        <input type="text" name="packeta_miesto" placeholder="napr. Likavka – Potraviny COOP Jednota">
                        <p class="packeta-hint">Napíš, kde si chceš balík vyzdvihnúť.</p>
                    </div>

                    <button type="submit" class="btn trainer-btn">Objednať</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>

<script>
// Prepínanie polí podľa zvoleného spôsobu doručenia (adresa vs. Packeta)
function prepniDorucenie() {
    var jeAdresa = document.querySelector('input[name="sposob"]:checked').value === 'adresa';
    document.getElementById('poleAdresa').style.display  = jeAdresa ? 'block' : 'none';
    document.getElementById('polePacketa').style.display = jeAdresa ? 'none'  : 'block';
}
</script>
</body>
</html>

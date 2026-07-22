<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login_page.php");
    exit();
}
require 'db_config.php';

$uploadDir = 'uploads/profilovky/';

// Načítanie aktuálneho používateľa
$stmt = $pdo->prepare("SELECT * FROM pouzivatelia WHERE username = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $akcia = $_POST['akcia'] ?? '';

    // --- ZMENA MENA A EMAILU ---
    if ($akcia === 'udaje') {
        $noveMeno  = trim($_POST['username'] ?? '');
        $novyEmail = trim($_POST['email'] ?? '');

        if ($noveMeno === '' || $novyEmail === '') {
            $chyba = "Meno a email nesmú byť prázdne.";
        } else {
            // Ak sa mení meno, over či nie je obsadené
            $obsadene = false;
            if ($noveMeno !== $user['username']) {
                $c = $pdo->prepare("SELECT 1 FROM pouzivatelia WHERE username = ?");
                $c->execute([$noveMeno]);
                $obsadene = (bool)$c->fetchColumn();
            }

            if ($obsadene) {
                $chyba = "Používateľ s týmto menom už existuje!";
            } else {
                try {
                    $pdo->beginTransaction();
                    $pdo->prepare("UPDATE pouzivatelia SET username = ?, email = ? WHERE id = ?")
                        ->execute([$noveMeno, $novyEmail, $user['id']]);

                    // Ak sa zmenilo meno, prepíš ho aj v rezerváciách a recenziách
                    if ($noveMeno !== $user['username']) {
                        $pdo->prepare("UPDATE treningy SET meno = ? WHERE meno = ?")
                            ->execute([$noveMeno, $user['username']]);
                        $pdo->prepare("UPDATE reviews SET meno = ? WHERE meno = ?")
                            ->execute([$noveMeno, $user['username']]);
                    }
                    $pdo->commit();
                    $_SESSION['username'] = $noveMeno;
                    $odpoved = "Údaje boli uložené.";
                } catch (Exception $e) {
                    $pdo->rollBack();
                    $chyba = "Chyba pri ukladaní údajov.";
                }
            }
        }
    }

    // --- ZMENA HESLA ---
    if ($akcia === 'heslo') {
        $stare = $_POST['stare_heslo'] ?? '';
        $nove  = $_POST['nove_heslo'] ?? '';
        $nove2 = $_POST['nove_heslo2'] ?? '';

        if (!password_verify($stare, $user['password'])) {
            $chyba = "Súčasné heslo je nesprávne.";
        } elseif (strlen($nove) < 4) {
            $chyba = "Nové heslo musí mať aspoň 4 znaky.";
        } elseif ($nove !== $nove2) {
            $chyba = "Nové heslá sa nezhodujú.";
        } else {
            $hash = password_hash($nove, PASSWORD_DEFAULT);
            $pdo->prepare("UPDATE pouzivatelia SET password = ? WHERE id = ?")
                ->execute([$hash, $user['id']]);
            $odpoved = "Heslo bolo zmenené.";
        }
    }

    // --- PROFILOVÁ FOTKA ---
    if ($akcia === 'fotka') {
        if (!isset($_FILES['profilovka']) || $_FILES['profilovka']['error'] !== UPLOAD_ERR_OK) {
            $chyba = "Vyber prosím obrázok.";
        } else {
            $f = $_FILES['profilovka'];
            $maxSize = 3 * 1024 * 1024; // 3 MB
            $info = @getimagesize($f['tmp_name']);
            $povolene = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/gif'  => 'gif',
                'image/webp' => 'webp',
            ];

            if ($f['size'] > $maxSize) {
                $chyba = "Obrázok je príliš veľký (max 3 MB).";
            } elseif (!$info || !isset($povolene[$info['mime']])) {
                $chyba = "Nepodporovaný formát. Použi JPG, PNG, GIF alebo WEBP.";
            } else {
                $ext = $povolene[$info['mime']];
                $filename = 'user_' . $user['id'] . '_' . time() . '.' . $ext;

                if (move_uploaded_file($f['tmp_name'], $uploadDir . $filename)) {
                    // Zmaž starú fotku
                    if (!empty($user['profilovka']) && file_exists($uploadDir . $user['profilovka'])) {
                        @unlink($uploadDir . $user['profilovka']);
                    }
                    $pdo->prepare("UPDATE pouzivatelia SET profilovka = ? WHERE id = ?")
                        ->execute([$filename, $user['id']]);
                    $odpoved = "Profilová fotka bola aktualizovaná.";
                } else {
                    $chyba = "Nepodarilo sa uložiť obrázok.";
                }
            }
        }
    }

    // Znovu načítaj aktualizovaného používateľa
    $stmt = $pdo->prepare("SELECT * FROM pouzivatelia WHERE id = ?");
    $stmt->execute([$user['id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
    <link rel="stylesheet" href="style.css?v=6">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="profil_page">

    <div class="fixed-header">
        <?php include 'includes/header.php'; ?>
    </div>

<main class="profil-page">
    <h1>Môj profil</h1>

    <?php if (isset($odpoved)): ?><p class="odpoved profil-msg"><?php echo htmlspecialchars($odpoved); ?></p><?php endif; ?>
    <?php if (isset($chyba)): ?><p class="rezervovane profil-msg"><?php echo htmlspecialchars($chyba); ?></p><?php endif; ?>

    <div class="profil-container">

        <!-- PROFILOVÁ FOTKA -->
        <div class="profil-card profil-avatar-card">
            <div class="profil-avatar-preview">
                <?php if (!empty($user['profilovka'])): ?>
                    <img src="uploads/profilovky/<?php echo htmlspecialchars($user['profilovka']); ?>" alt="Profilová fotka">
                <?php else: ?>
                    <i class='bx bx-user'></i>
                <?php endif; ?>
            </div>
            <h2><?php echo htmlspecialchars($user['username']); ?></h2>
            <form action="" method="post" enctype="multipart/form-data" class="profil-form">
                <input type="hidden" name="akcia" value="fotka">
                <label class="file-label">
                    <i class='bx bx-image-add'></i> Vybrať obrázok
                    <input type="file" name="profilovka" accept="image/*" required>
                </label>
                <button type="submit" class="btn">Nahrať fotku</button>
            </form>
        </div>

        <!-- ÚDAJE + HESLO -->
        <div class="profil-card profil-details-card">
            <h2>Údaje</h2>
            <form action="" method="post" class="profil-form">
                <input type="hidden" name="akcia" value="udaje">
                <label for="username">Používateľské meno</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <button type="submit" class="btn">Uložiť údaje</button>
            </form>

            <hr class="profil-hr">

            <h2>Zmena hesla</h2>
            <form action="" method="post" class="profil-form">
                <input type="hidden" name="akcia" value="heslo">
                <label for="stare_heslo">Súčasné heslo</label>
                <input type="password" id="stare_heslo" name="stare_heslo" required>

                <label for="nove_heslo">Nové heslo</label>
                <input type="password" id="nove_heslo" name="nove_heslo" required>

                <label for="nove_heslo2">Zopakuj nové heslo</label>
                <input type="password" id="nove_heslo2" name="nove_heslo2" required>

                <button type="submit" class="btn">Zmeniť heslo</button>
            </form>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>

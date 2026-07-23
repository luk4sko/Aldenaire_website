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
    // Prijímame orezaný štvorcový obrázok (PNG) z prehliadača ako base64 data URL
    if ($akcia === 'fotka') {
        $data = $_POST['cropped_image'] ?? '';
        $prefix = 'data:image/png;base64,';

        if (strpos($data, $prefix) !== 0) {
            $chyba = "Vyber prosím obrázok.";
        } else {
            $raw = base64_decode(substr($data, strlen($prefix)), true);

            if ($raw === false) {
                $chyba = "Neplatný obrázok.";
            } elseif (strlen($raw) > 3 * 1024 * 1024) {
                $chyba = "Obrázok je príliš veľký (max 3 MB).";
            } else {
                $info = @getimagesizefromstring($raw);
                if (!$info || $info['mime'] !== 'image/png') {
                    $chyba = "Neplatný obrázok.";
                } else {
                    $filename = 'user_' . $user['id'] . '_' . time() . '.png';

                    if (file_put_contents($uploadDir . $filename, $raw) !== false) {
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
    <link rel="stylesheet" href="style.css?v=10">
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
            <form action="" method="post" class="profil-form" id="fotkaForm">
                <input type="hidden" name="akcia" value="fotka">
                <input type="hidden" name="cropped_image" id="croppedImage">

                <label class="file-label">
                    <i class='bx bx-image-add'></i> Vybrať obrázok
                    <input type="file" id="fileInput" accept="image/*">
                </label>

                <!-- Orezávač (viditeľný až po výbere obrázka) -->
                <div class="cropper-wrap" id="cropperWrap">
                    <div class="cropper" id="cropper">
                        <img id="cropImg" alt="" draggable="false">
                    </div>
                    <label class="zoom-label">
                        <i class='bx bx-search'></i>
                        <input type="range" id="zoom" min="1" max="3" step="0.01" value="1">
                    </label>
                    <p class="cropper-hint">Potiahni obrázok a nastav priblíženie.</p>
                </div>

                <button type="submit" class="btn" id="uploadBtn">Nahrať fotku</button>
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

<script>
(function () {
    const CROP = 240;    // veľkosť orezávacieho okna (px)
    const OUT  = 400;    // veľkosť výsledného štvorca (px)

    const fileInput   = document.getElementById('fileInput');
    const cropperWrap = document.getElementById('cropperWrap');
    const cropper     = document.getElementById('cropper');
    const img         = document.getElementById('cropImg');
    const zoom        = document.getElementById('zoom');
    const form        = document.getElementById('fotkaForm');
    const hidden      = document.getElementById('croppedImage');

    let natW = 0, natH = 0;   // pôvodné rozmery
    let baseScale = 1;        // mierka aby obrázok pokryl okno
    let scale = 1;            // efektívna mierka
    let posX = 0, posY = 0;   // posun ľavého horného rohu obrázka voči oknu
    let dragging = false, startX = 0, startY = 0;

    function clamp() {
        const w = natW * scale, h = natH * scale;
        // obrázok musí vždy pokryť celé okno (žiadne prázdne miesta)
        posX = Math.min(0, Math.max(CROP - w, posX));
        posY = Math.min(0, Math.max(CROP - h, posY));
    }

    function render() {
        img.style.width  = (natW * scale) + 'px';
        img.style.height = (natH * scale) + 'px';
        img.style.transform = 'translate(' + posX + 'px,' + posY + 'px)';
    }

    fileInput.addEventListener('change', function () {
        const file = this.files && this.files[0];
        if (!file) return;
        if (!file.type.startsWith('image/')) { alert('Vyber prosím obrázok.'); return; }

        const reader = new FileReader();
        reader.onload = function (e) {
            img.onload = function () {
                natW = img.naturalWidth;
                natH = img.naturalHeight;
                baseScale = Math.max(CROP / natW, CROP / natH);
                zoom.value = 1;
                scale = baseScale;
                // vycentruj
                posX = (CROP - natW * scale) / 2;
                posY = (CROP - natH * scale) / 2;
                clamp();
                render();
                cropperWrap.classList.add('active');
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    });

    // Priblíženie – zachovaj stred okna
    zoom.addEventListener('input', function () {
        if (!natW) return;
        const cx = (CROP / 2 - posX) / scale;   // bod v obrázku pod stredom okna
        const cy = (CROP / 2 - posY) / scale;
        scale = baseScale * parseFloat(this.value);
        posX = CROP / 2 - cx * scale;
        posY = CROP / 2 - cy * scale;
        clamp();
        render();
    });

    // Ťahanie
    function pointerDown(x, y) { dragging = true; startX = x - posX; startY = y - posY; }
    function pointerMove(x, y) {
        if (!dragging) return;
        posX = x - startX;
        posY = y - startY;
        clamp();
        render();
    }
    function pointerUp() { dragging = false; }

    cropper.addEventListener('mousedown', e => { e.preventDefault(); pointerDown(e.clientX, e.clientY); });
    window.addEventListener('mousemove', e => pointerMove(e.clientX, e.clientY));
    window.addEventListener('mouseup', pointerUp);
    cropper.addEventListener('touchstart', e => { const t = e.touches[0]; pointerDown(t.clientX, t.clientY); }, { passive: true });
    cropper.addEventListener('touchmove', e => { const t = e.touches[0]; pointerMove(t.clientX, t.clientY); e.preventDefault(); }, { passive: false });
    window.addEventListener('touchend', pointerUp);

    // Odoslanie – vykresli viditeľnú časť do canvasu a pošli ako base64 PNG
    form.addEventListener('submit', function (e) {
        if (!natW) { e.preventDefault(); alert('Vyber prosím obrázok.'); return; }
        const srcX = -posX / scale;
        const srcY = -posY / scale;
        const srcSize = CROP / scale;

        const canvas = document.createElement('canvas');
        canvas.width = OUT; canvas.height = OUT;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(img, srcX, srcY, srcSize, srcSize, 0, 0, OUT, OUT);
        hidden.value = canvas.toDataURL('image/png');
    });
})();
</script>
</body>
</html>

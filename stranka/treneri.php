<?php
/*
 * treneri.php – stránka Tréneri.
 *
 * ===========================================================================
 *  AKO ZMENIŤ TRÉNEROV:
 *  Všetci tréneri sú v poli $treneri hneď nižšie. Každý tréner = jeden blok
 *  medzi [ ... ]. Stačí upraviť text v úvodzovkách:
 *     "meno"          -> meno trénera (musí sedieť s ponukou v rezervacia.php)
 *     "foto"          -> názov súboru fotky v priečinku obrazky/
 *     "popis"         -> krátky text o trénerovi
 *     "specializacie" -> štítky (koľko chceš, oddelené čiarkou)
 *     "roky"          -> text o praxi
 *     "zameranie"     -> na čo sa zameriava
 *     "cena"          -> cena tréningu v eurách (len číslo)
 *     "top"           -> true = zvýrazní trénera odznakom "Top tréner"
 *
 *  Novú fotku ulož do priečinka obrazky/ a sem napíš jej názov.
 *  Nového trénera pridáš skopírovaním jedného bloku [ ... ], (nezabudni čiarku).
 * ===========================================================================
 */
$treneri = [
    [
        "meno"          => "Marek",
        "foto"          => "obrazky/marek.png",
        "popis"         => "Silový tréner s viac ako 10-ročnou praxou. Vybuduje ti silu a svalovú hmotu s dôrazom na správnu techniku.",
        "specializacie" => ["Silový tréning", "Svalová hmota", "Tréningové plány"],
        "roky"          => "10 rokov praxe",
        "zameranie"     => "Sila & hmota",
        "cena"          => 25,
        "top"           => false,
    ],
    [
        "meno"          => "Peto",
        "foto"          => "obrazky/peto.png",
        "popis"         => "Odborník na kardio a funkčný tréning s viac ako 8-ročnou praxou. Prispôsobí tréning tvojej kondícii a udrží ťa motivovaného.",
        "specializacie" => ["Kardio", "Funkčný tréning", "Kondícia"],
        "roky"          => "8 rokov praxe",
        "zameranie"     => "Kardio & kondícia",
        "cena"          => 25,
        "top"           => false,
    ],
    [
        "meno"          => "Marko",
        "foto"          => "obrazky/robko.png",
        "popis"         => "Expert na flexibilitu a regeneráciu s viac ako 9-ročnou praxou. Pomôže ti predchádzať zraneniam a zlepšiť pohyblivosť.",
        "specializacie" => ["Flexibilita", "Regenerácia", "Prevencia zranení"],
        "roky"          => "9 rokov praxe",
        "zameranie"     => "Flexibilita & regenerácia",
        "cena"          => 35,
        "top"           => true,
    ],
];
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tréneri</title>
    <link rel="stylesheet" href="style.css?v=12">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="treneri_page">

    <div class="fixed-header">
        <?php include 'includes/header.php'; ?>
    </div>

<main class="trainers-page">
    <h1>Tréneri</h1>
    <p class="trainers-intro">Vyber si trénera, ktorý ti pomôže dosiahnuť tvoje ciele.</p>

    <div class="trainers-grid">
        <?php foreach ($treneri as $t): ?>
            <!-- Jedna kartička trénera (vytvorí sa automaticky pre každého v poli $treneri) -->
            <div class="trainer-card <?php echo $t['top'] ? 'featured' : ''; ?>">
                <?php if ($t['top']): ?>
                    <span class="trainer-badge"><i class='bx bxs-star'></i> Top tréner</span>
                <?php endif; ?>

                <div class="trainer-photo">
                    <img src="<?php echo $t['foto']; ?>" alt="<?php echo htmlspecialchars($t['meno']); ?>">
                </div>

                <div class="trainer-body">
                    <h2><?php echo htmlspecialchars($t['meno']); ?></h2>

                    <div class="trainer-chips">
                        <?php foreach ($t['specializacie'] as $chip): ?>
                            <span class="chip"><?php echo htmlspecialchars($chip); ?></span>
                        <?php endforeach; ?>
                    </div>

                    <p class="trainer-bio"><?php echo htmlspecialchars($t['popis']); ?></p>

                    <ul class="trainer-stats">
                        <li><i class='bx bx-medal'></i> <?php echo htmlspecialchars($t['roky']); ?></li>
                        <li><i class='bx bx-target-lock'></i> <?php echo htmlspecialchars($t['zameranie']); ?></li>
                        <li><i class='bx bx-euro'></i> <?php echo (int)$t['cena']; ?>€ / 2 hodiny</li>
                    </ul>

                    <!-- Odkaz vopred vyberie tohto trénera v rezervačnom formulári -->
                    <a href="rezervacia.php?trener=<?php echo urlencode($t['meno']); ?>" class="btn trainer-btn">Rezervuj</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>

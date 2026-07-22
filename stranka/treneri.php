<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tréneri</title>
    <link rel="stylesheet" href="style.css?v=9">
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

        <!-- Tréner Marek -->
        <div class="trainer-card">
            <div class="trainer-photo">
                <img src="obrazky/marek.png" alt="Marek">
            </div>
            <div class="trainer-body">
                <h2>Marek</h2>
                <div class="trainer-chips">
                    <span class="chip">Silový tréning</span>
                    <span class="chip">Svalová hmota</span>
                    <span class="chip">Tréningové plány</span>
                </div>
                <p class="trainer-bio">Silový tréner s viac ako 10-ročnou praxou. Vybuduje ti silu a svalovú hmotu s dôrazom na správnu techniku.</p>
                <ul class="trainer-stats">
                    <li><i class='bx bx-medal'></i> 10 rokov praxe</li>
                    <li><i class='bx bx-target-lock'></i> Sila &amp; hmota</li>
                    <li><i class='bx bx-euro'></i> 25€ / 2 hodiny</li>
                </ul>
                <a href="rezervacia.php?trener=Marek" class="btn trainer-btn">Rezervuj</a>
            </div>
        </div>

        <!-- Tréner Peto -->
        <div class="trainer-card">
            <div class="trainer-photo">
                <img src="obrazky/peto.png" alt="Peto">
            </div>
            <div class="trainer-body">
                <h2>Peto</h2>
                <div class="trainer-chips">
                    <span class="chip">Kardio</span>
                    <span class="chip">Funkčný tréning</span>
                    <span class="chip">Kondícia</span>
                </div>
                <p class="trainer-bio">Odborník na kardio a funkčný tréning s viac ako 8-ročnou praxou. Prispôsobí tréning tvojej kondícii a udrží ťa motivovaného.</p>
                <ul class="trainer-stats">
                    <li><i class='bx bx-medal'></i> 8 rokov praxe</li>
                    <li><i class='bx bx-target-lock'></i> Kardio &amp; kondícia</li>
                    <li><i class='bx bx-euro'></i> 25€ / 2 hodiny</li>
                </ul>
                <a href="rezervacia.php?trener=Peto" class="btn trainer-btn">Rezervuj</a>
            </div>
        </div>

        <!-- Tréner Marko -->
        <div class="trainer-card featured">
            <span class="trainer-badge"><i class='bx bxs-star'></i> Top tréner</span>
            <div class="trainer-photo">
                <img src="obrazky/robko.png" alt="Marko">
            </div>
            <div class="trainer-body">
                <h2>Marko</h2>
                <div class="trainer-chips">
                    <span class="chip">Flexibilita</span>
                    <span class="chip">Regenerácia</span>
                    <span class="chip">Prevencia zranení</span>
                </div>
                <p class="trainer-bio">Expert na flexibilitu a regeneráciu s viac ako 9-ročnou praxou. Pomôže ti predchádzať zraneniam a zlepšiť pohyblivosť.</p>
                <ul class="trainer-stats">
                    <li><i class='bx bx-medal'></i> 9 rokov praxe</li>
                    <li><i class='bx bx-target-lock'></i> Flexibilita &amp; regenerácia</li>
                    <li><i class='bx bx-euro'></i> 35€ / 2 hodiny</li>
                </ul>
                <a href="rezervacia.php?trener=Marko" class="btn trainer-btn">Rezervuj</a>
            </div>
        </div>

    </div>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>

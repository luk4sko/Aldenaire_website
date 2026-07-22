<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tréneri</title>
    <link rel="stylesheet" href="style.css?v=3">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="treneri_page">

    <div class="fixed-header">
        <?php include 'includes/header.php'; ?>
    </div>

<main class="trainers-page">

    <!-- Tréner Marek -->
    <div class="trainer-card">
        <section class="trainer">
            <div class="trainer-image">
                <img src="obrazky/marek.png" alt="Marek">
            </div>
            <div class="trainer-info">
                <h2>Marek</h2>
                <p>Marek je silový tréner s viac ako 10-ročnou praxou. Pomôže ti vybudovať silu a svalovú hmotu a vždy dbá na správnu techniku cvičenia.</p>
                <p><span class="specialization">Špecializácie:</span> Silový tréning, budovanie svalovej hmoty, individuálne tréningové plány.</p>
                <p>Marek je známy svojim profesionálnym prístupom a motivuje klientov dosiahnuť ich ciele efektívne a bezpečne.</p>
                <p class="price">Cena tréningu: 25€ / 2 hodiny</p>
                <a href="rezervacia.php" class="btn">Rezervuj</a>
            </div>
        </section>
    </div>

    <!-- Tréner Peto -->
    <div class="trainer-card reverse">
        <section class="trainer">
            <div class="trainer-image">
                <img src="obrazky/peto.png" alt="Peto">
            </div>
            <div class="trainer-info">
                <h2>Peto</h2>
                <p>Peto je odborník na kardio a funkčný tréning s viac ako 8-ročnou praxou. Motivuje každého klienta a prispôsobuje tréning podľa jeho možností.</p>
                <p><span class="specialization">Špecializácie:</span> Kardio, funkčný tréning, zlepšenie kondície a vytrvalosti.</p>
                <p>Peto sa stará aj o motiváciu a psychologickú podporu, aby tréningy boli zábavné a efektívne.</p>
                <p class="price">Cena tréningu: 25€ / 2 hodiny</p>
                <a href="rezervacia.php" class="btn">Rezervuj</a>
            </div>
        </section>
    </div>

    <!-- Tréner Robko -->
    <div class="trainer-card">
        <section class="trainer">
            <div class="trainer-image">
                <img src="obrazky/robko.png" alt="Robko">
            </div>
            <div class="trainer-info">
                <h2>Marko</h2>
                <p>Marko je expert na flexibilitu a regeneráciu. Pomáha klientom predchádzať zraneniam a zlepšiť pohyblivosť.</p>
                <p><span class="specialization">Špecializácie:</span> Flexibilita, regenerácia, prevencia zranení, funkčný tréning.</p>
                <p>Marko sa zameriava na individuálny prístup a dlhodobé zlepšenie zdravia a kondície klientov.</p>
                <p class="price">Cena tréningu: 35€ / 2 hodiny</p>
                <a href="rezervacia.php" class="btn">Rezervuj</a>
            </div>
        </section>
    </div>

</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>

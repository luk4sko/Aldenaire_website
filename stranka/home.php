<?php
require 'db_config.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <link rel="stylesheet" href="style.css?v=8">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="home_page">
    <?php include 'includes/header.php'; ?>
<main>
    <section class="hero">
        <div class="hero-left">
            <h1>Dosiahni svoju najlepšiu formu!</h1>
            <p>Pripoj sa k nám a začni trénovať s profesionálnym trénerom.</p>
            <a href="rezervacia.php" class="hero-btn">Rezervuj tréning teraz</a>
        </div>
        <div class="hero-right">
            <img src="obrazky/trener.png" alt="Svalnatý tréner">
        </div>
    </section>


    <section class="coaches">
    <h2>Naši tréneri</h2>
    <div class="coaches-grid">
        <div class="coach-card">
            <img src="obrazky/marek.png" alt="Marek">
            <h3>Marek</h3>
            <p>Silový tréner, ktorý ti pomôže vybudovať silu a svalovú hmotu.</p>
        </div>
        <div class="coach-card">
            <img src="obrazky/peto.png" alt="Peto">
            <h3>Peto</h3>
            <p>Kardio a funkčný tréning sú jeho špecialitou. Motivuje každého klienta.</p>
        </div>
        <div class="coach-card">
            <img src="obrazky/robko.png" alt="Robko">
            <h3>Marko</h3>
            <p>Odborník na rast svalov. S ním budeš mať najlepší progress a táku pumpu, že ti cicky vybuchnú</p>
        </div>
    </div>
</section>

<section class="trainings">
    <!-- DOPLNKY -->
    <div class="extras-cards">
        <h2>Doplnkové produkty</h2>
        <div class="extras-grid">
            <div class="extra-card">
                <img src="obrazky/chocolate.png" alt="Protein 1">
                <h3>Protein Chocolate</h3>
                <p class="price">25€</p>
                <a href="#" class="btn add-to-cart">Pridať do košíka</a>
            </div>
            <div class="extra-card">
                <img src="obrazky/vanilla.png" alt="Protein 2">
                <h3>Protein Vanilla</h3>
                <p class="price">28€</p>
                <a href="#" class="btn add-to-cart">Pridať do košíka</a>
            </div>
            <div class="extra-card">
                <img src="obrazky/strawberry.png" alt="Protein 3">
                <h3>Protein Strawberry</h3>
                <p class="price">30€</p>
                <a href="#" class="btn add-to-cart">Pridať do košíka</a>
            </div>
        </div>
    </div>
</section>
</main>    
<footer>
<?php include 'includes/footer.php'; ?>
</footer>
</body>
</html>
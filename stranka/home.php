<?php
require 'db_config.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomePage</title>
    <link rel="stylesheet" href="style.css?v=6">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="home_page">
    <?php include 'includes/header.php'; ?>
<main>
    <section class="hero">
        <div class="hero-left">
            <h1>Dosiahni svoju najlepإ،iu formu!</h1>
            <p>Pripoj sa k nأ،m a zaؤچni trأ©novaإ¥ s profesionأ،lnym trأ©nerom.</p>
            <a href="rezervacia.php" class="hero-btn">Rezervuj trأ©ning teraz</a>
        </div>
        <div class="hero-right">
            <img src="obrazky/trener.png" alt="Svalnatأ½ trأ©ner">
        </div>
    </section>


    <section class="coaches">
    <h2>Naإ،i trأ©neri</h2>
    <div class="coaches-grid">
        <div class="coach-card">
            <img src="obrazky/marek.png" alt="Marek">
            <h3>Marek</h3>
            <p>Silovأ½ trأ©ner, ktorأ½ ti pomأ´إ¾e vybudovaإ¥ silu a svalovأ؛ hmotu.</p>
        </div>
        <div class="coach-card">
            <img src="obrazky/peto.png" alt="Peto">
            <h3>Peto</h3>
            <p>Kardio a funkؤچnأ½ trأ©ning sأ؛ jeho إ،pecialitou. Motivuje kaإ¾dأ©ho klienta.</p>
        </div>
        <div class="coach-card">
            <img src="obrazky/robko.png" alt="Robko">
            <h3>Marko</h3>
            <p>Odbornأ­k na rast svalov. S nأ­m budeإ، maإ¥ najlepإ،أ­ progress a tأ،ku pumpu, إ¾e ti cicky vybuchnأ؛</p>
        </div>
    </div>
</section>

<section class="trainings">
    <!-- DOPLNKY -->
    <div class="extras-cards">
        <h2>Doplnkovأ© produkty</h2>
        <div class="extras-grid">
            <div class="extra-card">
                <img src="obrazky/chocolate.png" alt="Protein 1">
                <h3>Protein Chocolate</h3>
                <p class="price">25â‚¬</p>
                <a href="#" class="btn add-to-cart">Pridaإ¥ do koإ،أ­ka</a>
            </div>
            <div class="extra-card">
                <img src="obrazky/vanilla.png" alt="Protein 2">
                <h3>Protein Vanilla</h3>
                <p class="price">28â‚¬</p>
                <a href="#" class="btn add-to-cart">Pridaإ¥ do koإ،أ­ka</a>
            </div>
            <div class="extra-card">
                <img src="obrazky/strawberry.png" alt="Protein 3">
                <h3>Protein Strawberry</h3>
                <p class="price">30â‚¬</p>
                <a href="#" class="btn add-to-cart">Pridaإ¥ do koإ،أ­ka</a>
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
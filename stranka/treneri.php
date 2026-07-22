<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trأ©neri</title>
    <link rel="stylesheet" href="style.css?v=6">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="treneri_page">

    <div class="fixed-header">
        <?php include 'includes/header.php'; ?>
    </div>

<main class="trainers-page">

    <!-- Trأ©ner Marek -->
    <div class="trainer-card">
        <section class="trainer">
            <div class="trainer-image">
                <img src="obrazky/marek.png" alt="Marek">
            </div>
            <div class="trainer-info">
                <h2>Marek</h2>
                <p>Marek je silovأ½ trأ©ner s viac ako 10-roؤچnou praxou. Pomأ´إ¾e ti vybudovaإ¥ silu a svalovأ؛ hmotu a vإ¾dy dbأ، na sprأ،vnu techniku cviؤچenia.</p>
                <p><span class="specialization">إ pecializأ،cie:</span> Silovأ½ trأ©ning, budovanie svalovej hmoty, individuأ،lne trأ©ningovأ© plأ،ny.</p>
                <p>Marek je znأ،my svojim profesionأ،lnym prأ­stupom a motivuje klientov dosiahnuإ¥ ich ciele efektأ­vne a bezpeؤچne.</p>
                <p class="price">Cena trأ©ningu: 25â‚¬ / 2 hodiny</p>
                <a href="rezervacia.php" class="btn">Rezervuj</a>
            </div>
        </section>
    </div>

    <!-- Trأ©ner Peto -->
    <div class="trainer-card reverse">
        <section class="trainer">
            <div class="trainer-image">
                <img src="obrazky/peto.png" alt="Peto">
            </div>
            <div class="trainer-info">
                <h2>Peto</h2>
                <p>Peto je odbornأ­k na kardio a funkؤچnأ½ trأ©ning s viac ako 8-roؤچnou praxou. Motivuje kaإ¾dأ©ho klienta a prispأ´sobuje trأ©ning podؤ¾a jeho moإ¾nostأ­.</p>
                <p><span class="specialization">إ pecializأ،cie:</span> Kardio, funkؤچnأ½ trأ©ning, zlepإ،enie kondأ­cie a vytrvalosti.</p>
                <p>Peto sa starأ، aj o motivأ،ciu a psychologickأ؛ podporu, aby trأ©ningy boli zأ،bavnأ© a efektأ­vne.</p>
                <p class="price">Cena trأ©ningu: 25â‚¬ / 2 hodiny</p>
                <a href="rezervacia.php" class="btn">Rezervuj</a>
            </div>
        </section>
    </div>

    <!-- Trأ©ner Robko -->
    <div class="trainer-card">
        <section class="trainer">
            <div class="trainer-image">
                <img src="obrazky/robko.png" alt="Robko">
            </div>
            <div class="trainer-info">
                <h2>Marko</h2>
                <p>Marko je expert na flexibilitu a regenerأ،ciu. Pomأ،ha klientom predchأ،dzaإ¥ zraneniam a zlepإ،iإ¥ pohyblivosإ¥.</p>
                <p><span class="specialization">إ pecializأ،cie:</span> Flexibilita, regenerأ،cia, prevencia zranenأ­, funkؤچnأ½ trأ©ning.</p>
                <p>Marko sa zameriava na individuأ،lny prأ­stup a dlhodobأ© zlepإ،enie zdravia a kondأ­cie klientov.</p>
                <p class="price">Cena trأ©ningu: 35â‚¬ / 2 hodiny</p>
                <a href="rezervacia.php" class="btn">Rezervuj</a>
            </div>
        </section>
    </div>

</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>

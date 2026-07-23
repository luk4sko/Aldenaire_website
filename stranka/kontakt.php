<?php
/*
 * kontakt.php – kontaktná stránka.
 * Statická stránka: kontaktné údaje firmy, otváracie hodiny, odkazy na
 * sociálne siete a vložená mapa Google s adresou prevádzky.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();   // session kvôli hlavičke (aby vedela, či je niekto prihlásený)
}
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontakt</title>
    <link rel="stylesheet" href="style.css?v=12">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="kontakt_page">

    <div class="fixed-header">
        <?php include 'includes/header.php'; ?>
    </div>

<main class="contact-page">
    <h1>Kontakt</h1>

    <div class="contact-container">
        <!-- INFORMÁCIE O SPOLOČNOSTI -->
        <div class="contact-info-card">
            <h2>Aldenaire Fitness Club</h2>
            <p class="contact-intro">Máš otázku alebo sa chceš objednať na tréning? Neváhaj nás kontaktovať!</p>

            <ul class="contact-list">
                <li><i class='bx bxs-map'></i> <span>Likavka 1090, 034 95 Likavka</span></li>
                <li><i class='bx bxs-envelope'></i> <span>info@aldenaire.sk</span></li>
                <li><i class='bx bxs-phone'></i> <span>+421 905 436 519</span></li>
            </ul>

            <h3>Otváracie hodiny</h3>
            <ul class="contact-hours">
                <li><span>Pondelok – Piatok</span><span>6:00 – 22:00</span></li>
                <li><span>Sobota</span><span>8:00 – 20:00</span></li>
                <li><span>Nedeľa</span><span>8:00 – 18:00</span></li>
            </ul>

            <div class="contact-socials">
                <a href="https://www.facebook.com/profile.php?id=100086217064259"><i class='bx bxl-facebook'></i></a>
                <a href="https://www.instagram.com/luk4sko/"><i class='bx bxl-instagram'></i></a>
                <a href="#"><i class='bx bxl-twitter'></i></a>
            </div>
        </div>

        <!-- MAPA -->
        <div class="contact-map-card">
            <iframe
                src="https://www.google.com/maps?q=Likavka%201090,%20034%2095%20Likavka&z=15&output=embed"
                width="100%"
                height="100%"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
</body>
</html>

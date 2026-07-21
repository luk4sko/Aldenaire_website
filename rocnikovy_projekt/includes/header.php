<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}
?>
<header class="home-header">
    <div class="header-inner">
        
        <!-- LOGO -->
        <a href="home.php">
        <img src="obrazky/logo.png" alt="Logo" class="home-logo">
        </a>
        <!-- NAVIGATION -->
        <nav class="home-nav">
            <a href="home.php">Domov</a>
            <a href="treneri.php">Tréneri</a>
            <a href="cennik.php">Obchod</a>
            <a href="#">Recenzie</a>
            <a href="#">Kontakt</a>
        </nav>

        <!-- SEARCH + PROFILE -->
 <div class="profile-wrapper">
    <div class="profile-icon" id="profileToggle">
        <i class='bx bx-user'></i>
    </div>
    </div>
    </div>
    <div class="profile-dropdown" id="profileDropdown">
        <a href="#">Moznost 1</a>
        <a href="#">Moznost 2</a>
        <a href="#">Moznost 3</a>
    </div>
</div>
<script src="script.js"></script>
</header>
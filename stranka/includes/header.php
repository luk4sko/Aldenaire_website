<?php
if(session_status() === PHP_SESSION_NONE){
    session_start();
}

// profilová fotka prihláseného používateľa (pre ikonu v hlavičke)
$__avatar = null;
if (isset($_SESSION['username'])) {
    if (!isset($pdo)) {
        require 'db_config.php';
    }
    $__s = $pdo->prepare("SELECT profilovka FROM pouzivatelia WHERE username = ?");
    $__s->execute([$_SESSION['username']]);
    $__avatar = $__s->fetchColumn();
}

// počet kusov v košíku
$__kosikPocet = empty($_SESSION['kosik']) ? 0 : array_sum($_SESSION['kosik']);
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
            <a href="recenzie.php">Recenzie</a>
            <a href="kontakt.php">Kontakt</a>
        </nav>

        <!-- KOŠÍK + PROFIL (pravá strana hlavičky) -->
        <div class="header-right">

        <!-- Ikona košíka s počtom kusov -->
        <a href="kosik.php" class="cart-icon" title="Košík">
            <i class='bx bx-cart'></i>
            <?php if ($__kosikPocet > 0): ?>
                <span class="cart-badge"><?php echo $__kosikPocet; ?></span>
            <?php endif; ?>
        </a>

        <div class="profile-wrapper">
            <div class="profile-icon" id="profileToggle">
                <?php if ($__avatar): ?>
                    <img src="uploads/profilovky/<?php echo htmlspecialchars($__avatar); ?>" alt="Profil" class="profile-avatar-img">
                <?php else: ?>
                    <i class='bx bx-user'></i>
                <?php endif; ?>
            </div>
            <div class="profile-dropdown" id="profileDropdown">
                <?php if (isset($_SESSION['username'])): ?>
                    <div class="dropdown-user">
                        <?php if ($__avatar): ?>
                            <img src="uploads/profilovky/<?php echo htmlspecialchars($__avatar); ?>" alt="" class="dropdown-avatar">
                        <?php else: ?>
                            <i class='bx bx-user'></i>
                        <?php endif; ?>
                        <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                    </div>
                    <a href="profil.php"><i class='bx bx-user-circle'></i> Profil</a>
                    <a href="moje_rezervacie.php"><i class='bx bx-calendar'></i> Moje rezervácie</a>
                    <div class="dropdown-divider"></div>
                    <a href="logout.php" class="dropdown-logout"><i class='bx bx-log-out'></i> Odhlásiť sa</a>
                <?php else: ?>
                    <a href="login_page.php"><i class='bx bx-log-in'></i> Prihlásiť sa</a>
                    <a href="register_page.php"><i class='bx bx-user-plus'></i> Registrovať sa</a>
                <?php endif; ?>
            </div>
        </div><!-- /.profile-wrapper -->

        </div><!-- /.header-right -->
    </div>
<script src="script.js"></script>
</header>
<?php
/*
 * logout.php – odhlásenie používateľa.
 * Vymaže session (pamäť prihlásenia) a presmeruje späť na úvod.
 */
session_start();
session_unset();    // odstráni všetky premenné zo session (napr. username)
session_destroy();  // úplne zruší session
header("Location: home.php");  // presmerovanie na úvodnú stránku
exit();
?>

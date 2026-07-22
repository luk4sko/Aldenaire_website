<?php
session_start();
session_unset(); // odstráni všetky premenné session
session_destroy(); // zničí session
header("Location: home.php"); // presmerovanie na home page
exit();
?>
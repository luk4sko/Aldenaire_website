<?php
// Vzor pripojenia k databáze.
// Skopíruj tento súbor ako db_config.php a doplň svoje údaje.
// (db_config.php je v .gitignore, aby sa heslo nedostalo na GitHub.)
$pdo = new PDO(
    "pgsql:host=ADRESA_SERVERA;port=5432;dbname=postgres",
    "POUZIVATELSKE_MENO",
    "TVOJE_HESLO"
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

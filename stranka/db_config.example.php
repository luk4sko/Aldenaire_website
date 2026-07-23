<?php
/*
 * db_config.example.php – VZOR (šablóna) pripojenia k databáze.
 *
 * Skutočný súbor "db_config.php" zámerne NIE JE na GitHube – je uvedený
 * v súbore .gitignore, aby sa heslo k databáze nikdy nezverejnilo.
 *
 * AKO TO SPREVÁDZKOVAŤ:
 *   1) Skopíruj tento súbor a kópiu premenuj na  db_config.php
 *   2) Do kópie doplň vlastné údaje (adresa servera, meno, heslo).
 *
 * Ostatné stránky si potom pripojenie vyžiadajú cez:  require 'db_config.php';
 */

$pdo = new PDO(
    "pgsql:host=ADRESA_SERVERA;port=5432;dbname=postgres",
    "POUZIVATELSKE_MENO",
    "TVOJE_HESLO"
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

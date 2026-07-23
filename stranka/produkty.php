<?php
/*
 * produkty.php – zoznam produktov v obchode.
 * Používa ho stránka obchodu (cennik.php) aj košík (kosik.php),
 * aby boli produkty definované len na JEDNOM mieste.
 *
 * Každý produkt má svoje "id" (číslo v hranatej zátvorke vľavo) – podľa neho
 * ho košík rozpozná. Polia:
 *     "name"   -> názov produktu
 *     "img"    -> obrázok v priečinku obrazky/
 *     "status" -> "Na predaj" alebo "Vypredané"
 *     "price"  -> cena v eurách (len číslo)
 *
 * Pridať produkt = pridať nový riadok s ďalším voľným id.
 */
$produkty = [
    1  => ["name" => "Tričko",             "img" => "obrazky/tricko-pred.png", "status" => "Na predaj", "price" => 20],
    2  => ["name" => "Mikina",             "img" => "obrazky/mikina.png",      "status" => "Na predaj", "price" => 40],
    3  => ["name" => "Čiapka",             "img" => "obrazky/ciapka.png",      "status" => "Vypredané", "price" => 15],
    4  => ["name" => "Protein Chocolate",  "img" => "obrazky/chocolate.png",   "status" => "Vypredané", "price" => 25],
    5  => ["name" => "Protein Vanilla",    "img" => "obrazky/vanilla.png",     "status" => "Vypredané", "price" => 28],
    6  => ["name" => "Protein Strawberry", "img" => "obrazky/strawberry.png",  "status" => "Vypredané", "price" => 30],
    7  => ["name" => "Kreatin",            "img" => "obrazky/kreatin.webp",    "status" => "Vypredané", "price" => 35],
    8  => ["name" => "Športové rukavice",  "img" => "obrazky/rukavice.png",    "status" => "Vypredané", "price" => 10],
    9  => ["name" => "Šiltovka",           "img" => "obrazky/siltovka.png",    "status" => "Vypredané", "price" => 12],
    10 => ["name" => "Fitness opasok",     "img" => "obrazky/opasok.png",      "status" => "Vypredané", "price" => 18],
    11 => ["name" => "Šejker",             "img" => "obrazky/sejker.png",      "status" => "Vypredané", "price" => 8],
    12 => ["name" => "Bandáž na zápästie", "img" => "obrazky/bandaz.png",      "status" => "Vypredané", "price" => 6],
];

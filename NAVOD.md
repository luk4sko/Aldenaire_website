# Aldenaire Fitness Club — príručka k projektu

Tento dokument vysvetľuje, ako web funguje a **ako v ňom jednoducho meniť veci**.
Je napísaný tak, aby si podľa neho vedel/a odpovedať na otázky na skúške.

---

## 1. O čom je projekt

Webová stránka fitness klubu. Návštevník si môže:

- prezrieť **trénerov**, **obchod** a **recenzie**,
- **zaregistrovať sa** a **prihlásiť**,
- **rezervovať tréning** a spravovať **svoje rezervácie**,
- upraviť si **profil** (meno, email, heslo, profilová fotka),
- napísať **recenziu**.

**Použité technológie:**

| Časť | Technológia |
|------|-------------|
| Vzhľad stránky | HTML + CSS (`style.css`) |
| Logika na serveri | PHP |
| Menšia interaktivita v prehliadači | JavaScript (`script.js`) |
| Databáza | PostgreSQL na cloude **Supabase** |
| Lokálny server | XAMPP (Apache + PHP) |

---

## 2. Štruktúra projektu

```
rocnikovy_projekt/
├─ NAVOD.md                ← tento návod
├─ database/               ← záloha štruktúry databázy
└─ stranka/                ← celá webová stránka
   ├─ db_config.php        ← pripojenie k databáze (TAJNÉ, nie je na GitHube)
   ├─ db_config.example.php← vzor pripojenia (bez hesla, na GitHube je)
   ├─ home.php             ← úvodná stránka
   ├─ treneri.php          ← tréneri (údaje v poli $treneri navrchu súboru)
   ├─ produkty.php         ← zoznam produktov (pole $produkty)
   ├─ cennik.php           ← obchod (vypíše produkty z produkty.php)
   ├─ kosik.php            ← nákupný košík + pokladňa (objednávka)
   ├─ recenzie.php         ← recenzie / hodnotenia
   ├─ kontakt.php          ← kontakt + mapa
   ├─ rezervacia.php       ← vytvorenie rezervácie tréningu
   ├─ moje_rezervacie.php  ← prehľad vlastných rezervácií
   ├─ profil.php           ← profil používateľa (+ orezávač fotky)
   ├─ login_page.php       ← prihlásenie (+ "Zapamätať si ma")
   ├─ register_page.php    ← registrácia
   ├─ logout.php           ← odhlásenie
   ├─ style.css            ← VŠETKY štýly (farby, rozloženie)
   ├─ script.js            ← profilové menu (rozbalenie/zbalenie)
   ├─ includes/
   │  ├─ header.php        ← spoločná hlavička (menu) pre všetky stránky
   │  └─ footer.php        ← spoločná päta pre všetky stránky
   ├─ obrazky/             ← obrázky (logo, tréneri, produkty, pozadia)
   └─ uploads/profilovky/  ← sem sa ukladajú nahrané profilové fotky
```

**Dôležité:** hlavička a päta sú len raz (v `includes/`) a do každej stránky sa
**vkladajú** príkazom `include`. Keď zmeníš menu v `header.php`, zmení sa na celom webe.

---

## 3. Ako to funguje (tok stránky)

1. Návštevník otvorí napr. `home.php`.
2. PHP na serveri stránku „poskladá“: cez `include` doplní hlavičku a pätu,
   prípadne si cez `require 'db_config.php'` vypýta pripojenie k databáze.
3. Hotové HTML sa pošle do prehliadača, ktorý ho zobrazí a použije `style.css`.

**Prihlásenie a „pamäť“ (session):**

- Pri prihlásení sa meno uloží do `$_SESSION['username']`.
- `session` je pamäť servera, ktorá si pamätá, kto je prihlásený, aj keď prejde
  na inú stránku.
- Chránené stránky (rezervácia, profil, moje rezervácie) na začiatku kontrolujú:
  ```php
  if (!isset($_SESSION['username'])) { header("Location: login_page.php"); exit(); }
  ```
  → kto nie je prihlásený, je presmerovaný na prihlásenie.
- `logout.php` session zruší = odhlásenie.

---

## 4. Databáza

Tri tabuľky:

**`pouzivatelia`** — používateľské účty
| stĺpec | význam |
|--------|--------|
| id | číslo účtu (automatické) |
| username | prihlasovacie meno |
| email | email |
| password | **zašifrované** heslo (hash) |
| profilovka | názov súboru s profilovou fotkou |

**`treningy`** — rezervácie tréningov
| stĺpec | význam |
|--------|--------|
| id | číslo rezervácie |
| meno | meno používateľa, ktorý si rezervoval |
| typ | Beh / Fitko |
| trener | Peto / Marko / Marek |
| cena | cena v € |
| datum | dátum |
| cas | časové rozhranie (napr. 8:00-10:00) |

**`reviews`** — recenzie
| stĺpec | význam |
|--------|--------|
| id | číslo recenzie |
| meno | autor recenzie |
| recenzia | text recenzie |
| hviezdicky | hodnotenie 1–5 |
| datum | dátum a čas |

**`objednavky`** — objednávky z obchodu
| stĺpec | význam |
|--------|--------|
| id | číslo objednávky |
| meno | meno zákazníka |
| email | email zákazníka |
| telefon | telefón |
| sposob_dorucenia | "adresa" alebo "packeta" |
| adresa | doručovacia adresa / výdajné miesto |
| polozky | zoznam produktov (napr. "Tričko x2") |
| spolu | suma spolu (s dopravou) |
| datum | dátum objednávky |

---

## 5. Ako meniť bežné veci  ⭐ (toto sa najčastejšie pýtajú)

### 5.1 Zmena farby celého webu
Všetky hlavné farby sú **na jednom mieste** — úplne hore v `style.css` v bloku `:root`:

```css
:root {
    --zlata: #ffd700;          /* hlavná farba značky */
    --zlata-svetla: #ffdd57;   /* svetlejšia zlatá pri prejdení myšou */
    ...
}
```

Zmeníš `--zlata` a **zmení sa všetko** zlaté na webe (tlačidlá, ceny, štítky…),
lebo v štýloch sa farba nepíše priamo, ale ako `var(--zlata)`.

### 5.2 Zmena textu
Texty sú priamo v HTML v jednotlivých `.php` súboroch. Napr. hlavný nadpis na
úvode zmeníš v `home.php` v riadku `<h1>Dosiahni svoju najlepšiu formu!</h1>`.

### 5.3 Zmena / pridanie produktu v obchode
Všetky produkty sú v súbore `produkty.php` v poli `$produkty`. Pridáš/upravíš riadok
(vľavo je **id** – každé musí byť iné):

```php
7 => ["name" => "Kreatin", "img" => "obrazky/kreatin.webp", "status" => "Na predaj", "price" => 35],
```
Karta v obchode sa vytvorí **automaticky** (PHP cyklus `foreach`).
`status => "Vypredané"` prečiarkne cenu a skryje tlačidlo do košíka.

### 5.4 Zmena trénera  ← toto sa dá meniť veľmi ľahko
Všetci tréneri sú v súbore `treneri.php` v poli `$treneri` úplne navrchu.
Každý tréner je jeden blok `[ ... ]`, kde zmeníš:
`meno`, `foto` (názov súboru v `obrazky/`), `popis`, `specializacie` (štítky),
`roky`, `zameranie`, `cena` a `top` (true = odznak „Top tréner“).
Kartička sa potom vytvorí automaticky. Novú fotku daj do `obrazky/`.
Pozn.: `meno` musí sedieť s ponukou trénerov v `rezervacia.php`.

### 5.5 Ako funguje košík (obchod)
- Košík je uložený v **session**: `$_SESSION['kosik'] = [ id_produktu => počet ]`.
- „Pridať do košíka“ pošle **id** produktu do `kosik.php`, ktorý ho pridá.
- V košíku sa dá meniť počet (+/−) a odstrániť položka.
- Pri objednávke vyplníš údaje a **spôsob doručenia** (na adresu / Packeta).
  Objednávka sa uloží do tabuľky `objednavky` a košík sa vyprázdni.
- Platba zatiaľ nie je – objednávka sa len zaznamená.

### 5.6 Pridanie novej stránky
1. Vytvor nový súbor, napr. `novastranka.php`.
2. Na začiatok daj hlavičku a na koniec pätu:
   ```php
   <link rel="stylesheet" href="style.css?v=12">
   ...
   <div class="fixed-header"><?php include 'includes/header.php'; ?></div>
   ... obsah ...
   <?php include 'includes/footer.php'; ?>
   ```
3. Pridaj odkaz do menu v `includes/header.php`.

### 5.7 Zmena farby webu a cache verzia CSS `?v=12`
Farbu meníš v `style.css` hore v `:root` (premenná `--zlata`).
Prehliadač si CSS **ukladá do pamäte** (cache). Keď zmeníš štýly, zvýš číslo verzie
vo všetkých stránkach (napr. z `?v=12` na `?v=13`), aby prehliadač načítal nový CSS.

---

## 6. Bezpečnosť (dobré spomenúť na skúške)

- **Heslá sa neukladajú čitateľné.** Pri registrácii sa zašifrujú:
  `password_hash($password, PASSWORD_DEFAULT)` a pri prihlásení sa porovnajú
  cez `password_verify(...)`.
- **Ochrana pred SQL injection.** Do databázy sa nikdy nevkladá text priamo.
  Používajú sa „prepared statements“ so zástupným znakom `?`:
  ```php
  $stmt = $pdo->prepare("SELECT * FROM pouzivatelia WHERE username = ?");
  $stmt->execute([$username]);
  ```
- **Ochrana pred XSS.** Text od používateľov (napr. recenzie) sa pri výpise
  ošetruje cez `htmlspecialchars(...)`, aby sa nedal vložiť škodlivý kód.
- **Chránené stránky** kontrolujú prihlásenie cez `$_SESSION`.
- **Heslo k databáze nie je na GitHube.** Súbor `db_config.php` je v `.gitignore`.
  Na GitHube je len vzor `db_config.example.php` bez skutočného hesla.
- **„Zapamätať si ma“.** Ak je políčko zaškrtnuté, prihlásenie (session cookie)
  platí 30 dní: `session_set_cookie_params(30*24*60*60)` pred `session_start()`.

---

## 7. Pravdepodobné otázky a odpovede

**Ako sa spája web s databázou?**
Cez súbor `db_config.php`, ktorý vytvorí objekt `$pdo` (PDO pripojenie k Supabase).
Každá stránka si ho vyžiada cez `require 'db_config.php';`.

**Čo je session a načo je?**
Pamäť servera, ktorá si pamätá prihláseného používateľa medzi stránkami.
Uloží sa doň meno (`$_SESSION['username']`) pri prihlásení.

**Ako funguje hlavička na každej stránke?**
Je len raz v `includes/header.php` a do stránok sa vkladá cez `include`.
Podľa prihlásenia zobrazí iné menu.

**Ako sa vytvorí rezervácia?**
Formulár v `rezervacia.php` sa odošle metódou POST, PHP skontroluje dátum, čas a
či termín nie je obsadený, a `INSERT`-om ho uloží do tabuľky `treningy`.

**Prečo sa dá zrušiť rezervácia len 24 h vopred?**
V `moje_rezervacie.php` sa počíta začiatok tréningu a povolí sa zrušenie len ak
je viac ako 24 hodín v budúcnosti (kontrola je aj na serveri, nielen v tlačidle).

**Ako funguje nahranie profilovej fotky?**
Používateľ obrázok v prehliadači oreže do kruhu (JavaScript v `profil.php`),
výsledný štvorcový obrázok sa pošle na server a uloží do `uploads/profilovky/`.

**Kde zmením farbu webu?**
V `style.css` hore v `:root`, premenná `--zlata`.

**Ako funguje nákupný košík?**
Košík je uložený v session (`$_SESSION['kosik']`). Produkty sa pridávajú podľa **id**.
Pri objednávke sa vyplnia údaje a spôsob doručenia (adresa/Packeta) a objednávka sa
`INSERT`-om uloží do tabuľky `objednavky`. Platba zatiaľ nie je.

**Ako funguje „Zapamätať si ma“?**
Ak je políčko zaškrtnuté, pred `session_start()` sa nastaví platnosť session cookie
na 30 dní (`session_set_cookie_params`). Bez zaškrtnutia platí len do zatvorenia prehliadača.

---

## 8. Návrhy na zlepšenie (čo sa dá ešte doplniť)

1. **Zmeniť heslo k databáze.** Súbor `db_config.php` je síce skrytý (`.gitignore`),
   ale staré heslo je stále vidieť v **histórii commitov** na GitHube. Preto treba
   heslo v Supabase **zmeniť** (a nové dať len do lokálneho `db_config.php`).
2. **Reálna Packeta.** Teraz sa výdajné miesto píše ručne; dá sa doplniť oficiálny
   widget Packeta (mapa výberu miest) cez ich API kľúč.
3. **Platba.** Do košíka pridať platobnú bránu (napr. kartou).
4. **Recenzie k trénerom.** Recenzie by mohli byť priradené ku konkrétnemu trénerovi.
5. **Kontrola vstupov.** Pri registrácii overiť formát emailu a minimálnu dĺžku hesla.
6. **Obnova hesla.** Odkaz „Zabudol si heslo?“ zatiaľ nefunguje.
```

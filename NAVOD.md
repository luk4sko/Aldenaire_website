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
   ├─ db_config.php        ← pripojenie k databáze (premenná $pdo)
   ├─ home.php             ← úvodná stránka
   ├─ treneri.php          ← tréneri (mriežka kartičiek)
   ├─ cennik.php           ← obchod (produkty)
   ├─ recenzie.php         ← recenzie / hodnotenia
   ├─ kontakt.php          ← kontakt + mapa
   ├─ rezervacia.php       ← vytvorenie rezervácie tréningu
   ├─ moje_rezervacie.php  ← prehľad vlastných rezervácií
   ├─ profil.php           ← profil používateľa (+ orezávač fotky)
   ├─ login_page.php       ← prihlásenie
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
V `cennik.php` hore je pole `$products`. Pridáš alebo upravíš riadok:

```php
["name" => "Kreatin", "img" => "obrazky/kreatin.webp", "status" => "Na predaj", "price" => 35],
```
Karta v obchode sa vytvorí **automaticky** (PHP cyklus `foreach`).
`status => "Vypredané"` prečiarkne cenu a skryje tlačidlo.

### 5.4 Zmena trénera
V `treneri.php` je pre každého trénera jedna `<div class="trainer-card">`.
Zmeníš meno, foto (`obrazky/...`), štítky (`chip`), popis a cenu.
Tlačidlo „Rezervuj“ má odkaz `rezervacia.php?trener=Meno` — to meno musí sedieť
s možnosťou v rozbaľovacom zozname v `rezervacia.php`.

### 5.5 Pridanie novej stránky
1. Vytvor nový súbor, napr. `novastranka.php`.
2. Na začiatok daj hlavičku a na koniec pätu:
   ```php
   <link rel="stylesheet" href="style.css?v=11">
   ...
   <div class="fixed-header"><?php include 'includes/header.php'; ?></div>
   ... obsah ...
   <?php include 'includes/footer.php'; ?>
   ```
3. Pridaj odkaz do menu v `includes/header.php`.

### 5.6 Prečo je v odkaze na CSS `?v=10`?
Prehliadač si CSS **ukladá do pamäte** (cache). Keď zmeníš štýly, zvýšiš číslo
(`?v=11`), aby prehliadač načítal novú verziu a nezobrazoval starú.

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

---

## 8. Návrhy na zlepšenie (čo sa dá ešte doplniť)

1. **Skryť heslo k databáze.** `db_config.php` obsahuje heslo napísané priamo v
   kóde a je na GitHube. Lepšie je držať ho mimo verejného repozitára
   (napr. v samostatnom súbore, ktorý sa nenahráva na GitHub).
2. **Funkčný košík.** Tlačidlá „Pridať do košíka“ zatiaľ nič nerobia (`href="#"`).
3. **Recenzie k trénerom.** Recenzie by mohli byť priradené ku konkrétnemu trénerovi.
4. **Kontrola vstupov.** Pri registrácii overiť formát emailu a minimálnu dĺžku hesla.
5. **Overenie emailu / obnova hesla.** Odkaz „Forgot password?“ zatiaľ nefunguje.
6. **Jednotný jazyk kódu.** Menšie zvyšky angličtiny v triedach/komentároch zjednotiť.
```

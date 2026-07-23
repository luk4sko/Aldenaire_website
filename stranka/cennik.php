<?php
/*
 * cennik.php – stránka Obchod.
 * Produkty sa načítajú zo spoločného súboru produkty.php (pole $produkty).
 * Cez PHP cyklus foreach sa z každého produktu automaticky vytvorí kartička.
 * Vypredané produkty dostanú triedu "sold-out" (prečiarknutá cena, bez tlačidla).
 * Tlačidlo "Pridať do košíka" pošle id produktu do košíka (kosik.php).
 */
require 'produkty.php';   // načíta pole $produkty
?>
<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Obchod</title>
    <link rel="stylesheet" href="style.css?v=12">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="cennik-page">

    <div class="fixed-header">
    <?php include 'includes/header.php'; ?>
    </div>

    <main>
        <section class="pricing">
            <h1>Obchod</h1>
            <div class="pricing-grid">
                <?php foreach($produkty as $id => $product): ?>
                    <div class="pricing-card <?php echo $product['status'] == 'Vypredané' ? 'sold-out' : ''; ?>">
                        <img src="<?php echo $product['img']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="status"><?php echo $product['status']; ?></p>
                        <p class="price"><?php echo $product['price']; ?>€</p>

                        <?php if($product['status'] != 'Vypredané'): ?>
                            <!-- Formulár pošle id produktu do košíka a pridá ho tam -->
                            <form action="kosik.php" method="post">
                                <input type="hidden" name="pridat" value="<?php echo $id; ?>">
                                <button type="submit" class="btn add-to-cart">
                                    <i class='bx bx-cart-add'></i> Pridať do košíka
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>

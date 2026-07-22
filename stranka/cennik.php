<?php
$products = [
    ["name" => "Triؤچko", "img" => "obrazky/tricko-pred.png", "status" => "Na predaj", "price" => 20],
    ["name" => "Mikina", "img" => "obrazky/mikina.png", "status" => "Na predaj", "price" => 40],
    ["name" => "ؤŒiapka", "img" => "obrazky/ciapka.png", "status" => "Vypredanأ©", "price" => 15],
    ["name" => "Protein Chocolate", "img" => "obrazky/chocolate.png", "status" => "Vypredanأ©", "price" => 25],
    ["name" => "Protein Vanilla", "img" => "obrazky/vanilla.png", "status" => "Vypredanأ©", "price" => 28],
    ["name" => "Protein Strawberry", "img" => "obrazky/strawberry.png", "status" => "Vypredanأ©", "price" => 30],
    ["name" => "Kreatin", "img" => "obrazky/kreatin.webp", "status" => "Vypredanأ©", "price" => 35],
    ["name" => "إ portovأ© rukavice", "img" => "obrazky/rukavice.png", "status" => "Vypredanأ©", "price" => 10],
    ["name" => "إ iltovka", "img" => "obrazky/siltovka.png", "status" => "Vypredanأ©", "price" => 12],
    ["name" => "Fitness opasok", "img" => "obrazky/opasok.png", "status" => "Vypredanأ©", "price" => 18],
    ["name" => "إ ejker", "img" => "obrazky/sejker.png", "status" => "Vypredanأ©", "price" => 8],
    ["name" => "Bandأ،إ¾ na zأ،pأ¤stie", "img" => "obrazky/bandaz.png", "status" => "Vypredanأ©", "price" => 6],
];
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cennأ­k</title>
    <link rel="stylesheet" href="style.css?v=6">
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
                <?php foreach($products as $product): ?>
                    <div class="pricing-card <?php echo $product['status'] == 'Vypredanأ©' ? 'sold-out' : ''; ?>">
                        <img src="<?php echo $product['img']; ?>" alt="<?php echo $product['name']; ?>">
                        <h3><?php echo $product['name']; ?></h3>
                        <p class="status"><?php echo $product['status']; ?></p>
                        <p class="price"><?php echo $product['price']; ?>â‚¬</p>
                        <?php if($product['status'] != 'Vypredanأ©'): ?>
                            <a href="#" class="btn add-to-cart">Pridaإ¥ do koإ،أ­ka</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>

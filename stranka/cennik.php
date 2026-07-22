<?php
$products = [
    ["name" => "Tričko", "img" => "obrazky/tricko-pred.png", "status" => "Na predaj", "price" => 20],
    ["name" => "Mikina", "img" => "obrazky/mikina.png", "status" => "Na predaj", "price" => 40],
    ["name" => "Čiapka", "img" => "obrazky/ciapka.png", "status" => "Vypredané", "price" => 15],
    ["name" => "Protein Chocolate", "img" => "obrazky/chocolate.png", "status" => "Vypredané", "price" => 25],
    ["name" => "Protein Vanilla", "img" => "obrazky/vanilla.png", "status" => "Vypredané", "price" => 28],
    ["name" => "Protein Strawberry", "img" => "obrazky/strawberry.png", "status" => "Vypredané", "price" => 30],
    ["name" => "Kreatin", "img" => "obrazky/kreatin.webp", "status" => "Vypredané", "price" => 35],
    ["name" => "Športové rukavice", "img" => "obrazky/rukavice.png", "status" => "Vypredané", "price" => 10],
    ["name" => "Šiltovka", "img" => "obrazky/siltovka.png", "status" => "Vypredané", "price" => 12],
    ["name" => "Fitness opasok", "img" => "obrazky/opasok.png", "status" => "Vypredané", "price" => 18],
    ["name" => "Šejker", "img" => "obrazky/sejker.png", "status" => "Vypredané", "price" => 8],
    ["name" => "Bandáž na zápästie", "img" => "obrazky/bandaz.png", "status" => "Vypredané", "price" => 6],
];
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cenník</title>
    <link rel="stylesheet" href="style.css?v=5">
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
                    <div class="pricing-card <?php echo $product['status'] == 'Vypredané' ? 'sold-out' : ''; ?>">
                        <img src="<?php echo $product['img']; ?>" alt="<?php echo $product['name']; ?>">
                        <h3><?php echo $product['name']; ?></h3>
                        <p class="status"><?php echo $product['status']; ?></p>
                        <p class="price"><?php echo $product['price']; ?>€</p>
                        <?php if($product['status'] != 'Vypredané'): ?>
                            <a href="#" class="btn add-to-cart">Pridať do košíka</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>

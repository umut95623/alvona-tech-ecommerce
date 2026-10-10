<?php
session_start();
include "baglan.php";

$kullanici_id = isset($_SESSION["kullanici_id"]) ? $_SESSION["kullanici_id"] : "";
$mesajlar = [];

if (isset($_GET["eklendi"])) {
    $mesajlar[] = "Ürün başarıyla sepete eklendi.";
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlvonaTech - Mağaza</title>
    <link rel="stylesheet" href="css/style.css?v=2">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
    
    <?php include "header.php"; ?>

    <section class="urunler">
        <h1 class="baslik">Tüm Ürünler</h1>

        <div class="box-container">
            <?php
            $urunleri_sec = $conn->prepare("SELECT * FROM urunler");
            $urunleri_sec->execute();
            
            if ($urunleri_sec->rowCount() > 0) {
                while ($urun = $urunleri_sec->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <form action="sepeteekle.php" method="POST" class="box" style="display:flex; flex-direction:column; justify-content:space-between;">
                        <input type="hidden" name="urunid" value="<?= $urun["id"]; ?>">
                        
                        <?php 
                        $fotolar = explode(",", $urun["urunfotosu"]); 
                        $goster_buton = count($fotolar) > 1 ? '' : 'display:none;';
                        ?>
                        <div class="carousel" data-index="0" data-fotos='<?= htmlspecialchars(json_encode($fotolar), ENT_QUOTES, 'UTF-8'); ?>' style="flex:1; display:flex; align-items:center; justify-content:center; height:180px;">
                            <button type="button" class="carousel-btn left-btn" style="<?= $goster_buton; ?>">&#10094;</button>
                            <img src="urun_gorselleri/<?= $fotolar[0]; ?>" class="carousel-img" alt="" style="max-height:180px; max-width:100%; object-fit:contain;">
                            <button type="button" class="carousel-btn right-btn" style="<?= $goster_buton; ?>">&#10095;</button>
                        </div>
                        
                        <div style="margin-top:20px; text-align:left;">
                            <h3 style="font-size:18px; color:var(--primary-dark); font-weight:600; margin-bottom:10px; line-height:1.4;"><?= $urun["urun_adi"]; ?></h3>
                            <p style="font-size:13px; color:#718096; margin-bottom:15px; height:40px; overflow:hidden;"><?= htmlspecialchars($urun["urun_bilgisi"]); ?></p>
                            <div style="font-size:22px; font-weight:bold; color:var(--primary-dark); margin-bottom:15px;">
                                <?= $urun["urun_fiyati"]; ?>.00₺
                            </div>
                        </div>

                        <div style="display:flex; gap:10px;">
                            <input type="number" name="adet" value="1" min="1" max="99" style="width:60px; padding:10px; border:1px solid #cbd5e0; border-radius:5px; text-align:center;">
                            <button type="submit" name="sepete_ekle" class="buton" style="flex:1; border-radius:5px;">Sepete Ekle</button>
                        </div>
                    </form>
            <?php
                }
            } else {
                echo '<p class="bos" style="grid-column: 1 / -1; text-align:center;">Şu an mağazada hiç ürün bulunmuyor.</p>';
            }
            ?>
        </div>
    </section>

<script>
document.querySelectorAll('.carousel').forEach(carousel => {
    const btnLeft = carousel.querySelector('.left-btn');
    const btnRight = carousel.querySelector('.right-btn');
    const img = carousel.querySelector('.carousel-img');
    const fotos = JSON.parse(carousel.getAttribute('data-fotos'));
    
    if (fotos.length > 1) {
        btnLeft.addEventListener('click', (e) => {
            e.preventDefault();
            let idx = parseInt(carousel.getAttribute('data-index'));
            idx = (idx - 1 + fotos.length) % fotos.length;
            carousel.setAttribute('data-index', idx);
            img.src = 'urun_gorselleri/' + fotos[idx];
        });
        btnRight.addEventListener('click', (e) => {
            e.preventDefault();
            let idx = parseInt(carousel.getAttribute('data-index'));
            idx = (idx + 1) % fotos.length;
            carousel.setAttribute('data-index', idx);
            img.src = 'urun_gorselleri/' + fotos[idx];
        });
    }
});
</script>

    <?php include "footer.php"; ?>
</body>
</html>
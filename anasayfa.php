<?php
session_start();
include "baglan.php";

if (isset($_SESSION["kullanici_id"])) {
    $kullanici_id = $_SESSION["kullanici_id"];
} else {
    $kullanici_id = "";
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlvonaTech - Hoşgeldiniz</title>
    <link rel="stylesheet" href="css/style.css?v=2">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
    
    <!-- HEADER -->
    <?php include "header.php"; ?>

    <section class="hero-section">
        <h1 style="color: var(--primary-dark);">ALVONA TECH'E HOŞ GELDİNİZ.</h1>
        <p>Teknolojiye dair her şeyde samimi ve güvenilir yol arkadaşınız. Doğru teknolojiyi bulmayı kolay ve zahmetsiz hale getirmek için kaliteli bilgisayarları, donanım bileşenlerini ve günlük ekipmanları özenle seçiyoruz. Bağlantı kurma, inşa etme ve üretmeniz için yanınızdayız.</p>
        
        <div style="display:flex; justify-content:center; gap:20px;">
            <a href="magaza.php" class="buton">Mağazayı Keşfet</a>
        </div>

        <div class="hero-features">
            <div class="feature">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                <span>50 TL üzeri siparişlerde<br>ücretsiz kargo</span>
            </div>
            <div class="feature">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                <span>30 gün içinde<br>sorunsuz iade</span>
            </div>
            <div class="feature">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                <span>Samimi ve<br>uzman destek</span>
            </div>
        </div>
    </section>

    

    <?php include "footer.php"; ?>
</body>
</html>

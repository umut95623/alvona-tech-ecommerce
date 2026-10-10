<?php
session_start();
include "baglan.php";

if (empty($_SESSION["admin_id"])) {
    header("Location: yonetici_giris.php");
    exit;
}
$admin_id = $_SESSION["admin_id"];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlvonaTech - Yönetici Paneli</title>
    <link rel="stylesheet" href="css/style.css?v=2">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
<?php include "yonetici_header.php"; ?>
<section class="dashboard" style="max-width:1200px; margin:40px auto; padding:0 20px;">
    <h1 style="font-size:32px; color:var(--primary-dark); font-weight:700; margin-bottom: 30px;">Yönetici Paneli Ana Sayfa</h1>
    <div class="box-container" style="display:grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap:25px;">
        <!-- ürünler kartı -->
        <div class="box" style="padding:30px; text-align:center; background:#fff; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.05); border:1px solid var(--border-color);">
            <?php
            $urunleri_sec = $conn->prepare("SELECT * FROM urunler");
            $urunleri_sec->execute();
            $urun_sayisi = $urunleri_sec->rowCount();
            ?>
            <h3 style="font-size:36px; color:var(--button-blue); margin-bottom:10px;"><?= $urun_sayisi; ?></h3>
            <p style="color:#718096; font-size:16px; margin-bottom:20px;">Yayındaki Ürünler</p>
            <a href="urun_ekle.php" class="outline-buton" style="display:block; padding:10px;">Ürünleri Yönet</a>
        </div>
        <!-- siparişler kartı -->
        <div class="box" style="padding:30px; text-align:center; background:#fff; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.05); border:1px solid var(--border-color);">
            <?php
            $siparisleri_sec = $conn->prepare("SELECT * FROM siparisler");
            $siparisleri_sec->execute();
            $siparis_sayisi = $siparisleri_sec->rowCount();
            ?>
            <h3 style="font-size:36px; color:var(--button-blue); margin-bottom:10px;"><?= $siparis_sayisi; ?></h3>
            <p style="color:#718096; font-size:16px; margin-bottom:20px;">Verilen Siparişler</p>
            <a href="verilmis_siparisler.php" class="outline-buton" style="display:block; padding:10px;">Siparişleri Yönet</a>
        </div>
        <!-- kullanıcılar kartı -->
        <div class="box" style="padding:30px; text-align:center; background:#fff; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.05); border:1px solid var(--border-color);">
            <?php
            $kullanicilari_sec = $conn->prepare("SELECT * FROM kullanicilar");
            $kullanicilari_sec->execute();
            $kullanici_sayisi = $kullanicilari_sec->rowCount();
            ?>
            <h3 style="font-size:36px; color:var(--button-blue); margin-bottom:10px;"><?= $kullanici_sayisi; ?></h3>
            <p style="color:#718096; font-size:16px; margin-bottom:20px;">Kayıtlı Müşteriler</p>
            <a href="kullanici_hesaplari.php" class="outline-buton" style="display:block; padding:10px;">Müşterileri Yönet</a>
        </div>
        <!-- yöneticiler kartı -->
        <div class="box" style="padding:30px; text-align:center; background:#fff; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.05); border:1px solid var(--border-color);">
            <?php
            $yoneticileri_sec = $conn->prepare("SELECT * FROM yoneticiler");
            $yoneticileri_sec->execute();
            $yonetici_sayisi = $yoneticileri_sec->rowCount();
            ?>
            <h3 style="font-size:36px; color:var(--button-blue); margin-bottom:10px;"><?= $yonetici_sayisi; ?></h3>
            <p style="color:#718096; font-size:16px; margin-bottom:20px;">Admin Sayısı</p>
            <a href="#" class="outline-buton" style="display:block; padding:10px; background:#e2e8f0; color:#a0aec0; border:none; cursor:not-allowed;">(Sadece Veritabanından)</a>
        </div>
    </div>
</section>
    <?php include "footer.php"; ?>
</body>
</html>

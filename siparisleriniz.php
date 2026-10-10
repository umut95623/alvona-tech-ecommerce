<?php
session_start();
include "baglan.php";

if (empty($_SESSION["kullanici_id"])) {
    header("Location: giris.php");
    exit;
}
$kullanici_id = $_SESSION["kullanici_id"];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlvonaTech - Siparişleriniz</title>
    <link rel="stylesheet" href="css/style.css?v=2">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
    
    <?php include "header.php"; ?>
    <div style="max-width:1400px; width:100%; margin:40px auto; padding:0 20px;">
        <!-- ana içerik -->
        <div>
            <h1 class="baslik">Siparişleriniz</h1>
            <?php
            $siparisleri_sec = $conn->prepare("SELECT * FROM siparisler WHERE kullanici_id = ? ORDER BY id DESC");
            $siparisleri_sec->execute([$kullanici_id]);
            
            if ($siparisleri_sec->rowCount() > 0) {
                while ($siparis = $siparisleri_sec->fetch(PDO::FETCH_ASSOC)) {
            ?>
                    <div class="siparis-karti">
                        <!-- header kısmı -->
                        <div class="siparis-karti-header">
                            <div style="display:flex; gap:40px;">
                                <div>
                                    <div style="font-weight:600;">SİPARİŞ TARİHİ:</div>
                                    <div><?= date('d.m.Y', strtotime($siparis["tarih"] ?? 'today')); ?></div>
                                </div>
                                <div>
                                    <div style="font-weight:600;">TOPLAM:</div>
                                    <div><?= $siparis["toplam_fiyat"]; ?>.00₺</div>
                                </div>
                                <div>
                                    <div style="font-weight:600;">ALICI:</div>
                                    <div><?= htmlspecialchars($siparis["musteriadi"]); ?></div>
                                </div>
                            </div>
                            <div style="text-align:right;">
                                <div style="font-weight:600;">SİPARİŞ #<?= 10000 + $siparis["id"]; ?></div>
                                <a href="#" style="color:var(--button-blue);">Faturayı Görüntüle</a>
                            </div>
                        </div>
                        <!-- kart body -->
                        <div class="siparis-karti-body">
                            <div>
                                <h3 style="color:green; font-size:18px; margin-bottom:15px;">Hazırlanıyor / Kargoda</h3>
                                <div style="display:flex; gap:20px; align-items:center;">
                                    <div style="width:80px; height:80px; background:#f4f6f8; border-radius:5px; display:flex; align-items:center; justify-content:center; border:1px solid #e2e8f0;">
                                        📦
                                    </div>
                                    <div>
                                        <p style="font-weight:500; font-size:16px; margin-bottom:5px; max-width:400px;"><?= $siparis["alinan_urunler"]; ?></p>
                                        <p style="color:#718096; font-size:14px;">Adres: <?= htmlspecialchars($siparis["adres"]); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p class="bos">Henüz verilmiş bir siparişiniz bulunmamaktadır.</p>';
            }
            ?>
        </div>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>

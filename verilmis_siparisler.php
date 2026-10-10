<?php
session_start();
include "baglan.php";

if (empty($_SESSION["admin_id"])) {
    header("Location: yonetici_giris.php");
    exit;
}

if (isset($_GET["sil"])) {
    $silinecek_id = (int)$_GET["sil"];
    
    $siparisi_sil = $conn->prepare("DELETE FROM siparisler WHERE id = ?");
    $siparisi_sil->execute([$silinecek_id]);
    
    header("Location: verilmis_siparisler.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlvonaTech - Verilmiş Siparişler</title>
    <link rel="stylesheet" href="css/style.css?v=2">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
<?php include "yonetici_header.php"; ?>

<div style="max-width:1200px; margin:40px auto; padding:0 20px;">
    <h1 style="font-size:28px; color:var(--primary-dark); font-weight:700; margin-bottom: 30px;">Tüm Gelen Siparişler</h1>
    <div class="box-container" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap:20px;">
        <?php
        $siparisleri_sec = $conn->prepare("SELECT * FROM siparisler ORDER BY id DESC");
        $siparisleri_sec->execute();
        if ($siparisleri_sec->rowCount() > 0) {
            while ($siparis = $siparisleri_sec->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <div class="box" style="text-align:left; background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.05); border:1px solid var(--border-color);">
                    <div style="display:flex; justify-content:space-between; margin-bottom:15px; border-bottom:1px solid var(--border-color); padding-bottom:10px;">
                        <span style="font-weight:bold; color:var(--primary-dark);">Sipariş #<?= 10000 + $siparis["id"]; ?></span>
                        <span style="color:#718096; font-size:14px;"><?= date('d.m.Y H:i', strtotime($siparis["tarih"] ?? 'now')); ?></span>
                    </div>
                    
                    <p style="margin-bottom:8px; font-size:14px;"><span style="color:#718096;">Alıcı:</span> <br> <b><?= htmlspecialchars($siparis["musteriadi"]); ?></b></p>
                    <p style="margin-bottom:8px; font-size:14px;"><span style="color:#718096;">İletişim:</span> <br> <?= htmlspecialchars($siparis["eposta"]); ?> <br> <?= htmlspecialchars($siparis["telefon_no"]); ?></p>
                    <p style="margin-bottom:8px; font-size:14px;"><span style="color:#718096;">Adres:</span> <br> <?= htmlspecialchars($siparis["adres"]); ?></p>
                    <p style="margin-bottom:8px; font-size:14px;"><span style="color:#718096;">Ödeme:</span> <br> <?= htmlspecialchars($siparis["odemesekli"]); ?></p>
                    <p style="margin-bottom:15px; font-size:14px; background:#f8fafc; padding:10px; border-radius:5px;"><span style="color:#718096;">Ürünler:</span> <br> <?= htmlspecialchars($siparis["alinan_urunler"]); ?></p>
                    
                    <div style="font-size:20px; font-weight:bold; color:var(--primary-dark); margin-bottom:15px;">
                        Toplam: <?= $siparis["toplam_fiyat"]; ?>.00₺
                    </div>
                    <a href="verilmis_siparisler.php?sil=<?= $siparis["id"]; ?>" class="silmebutonu" style="display:block; text-align:center;" onclick="return confirm('Bu siparişi kalıcı olarak silmek istediğinize emin misiniz?');">Siparişi İptal Et / Sil</a>
                </div>
        <?php
            }
        } else {
            echo '<p style="color:#718096;">Sisteme henüz hiç sipariş düşmedi.</p>';
        }
        ?>
    </div>

</div>
    <?php include "footer.php"; ?>
</body>
</html>
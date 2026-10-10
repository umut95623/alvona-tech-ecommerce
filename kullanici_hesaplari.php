<?php
session_start();
include "baglan.php";

if (empty($_SESSION["admin_id"])) {
    header("Location: yonetici_giris.php");
    exit;
}

if (isset($_GET["sil"])) {
    $silinecek_id = (int)$_GET["sil"];
    
    // burada kullanıcı silinirken aynı zamanda sepeti ve siparişleri de siliniyyor
    $kullaniciyi_sil = $conn->prepare("DELETE FROM kullanicilar WHERE id = ?");
    $kullaniciyi_sil->execute([$silinecek_id]);

    $sepeti_sil = $conn->prepare("DELETE FROM sepet WHERE kullanici_id = ?");
    $sepeti_sil->execute([$silinecek_id]);

    $siparisleri_sil = $conn->prepare("DELETE FROM siparisler WHERE kullanici_id = ?");
    $siparisleri_sil->execute([$silinecek_id]);

    header("Location: kullanici_hesaplari.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlvonaTech - Kullanıcı Hesapları</title>
    <link rel="stylesheet" href="css/style.css?v=2">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>

<?php include "yonetici_header.php"; ?>

<div style="max-width:1200px; margin:40px auto; padding:0 20px;">

    <h1 style="font-size:28px; color:var(--primary-dark); font-weight:700; margin-bottom: 30px;">Kayıtlı Müşteriler</h1>

    <div class="box-container" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap:20px;">
        <?php
        $kullanici_hesaplari = $conn->prepare("SELECT * FROM kullanicilar");
        $kullanici_hesaplari->execute();
        
        if ($kullanici_hesaplari->rowCount() > 0) {
            while ($kullanici = $kullanici_hesaplari->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <div class="box" style="text-align:left; background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.05); border:1px solid var(--border-color);">
                    <div style="font-weight:bold; font-size:18px; margin-bottom:5px; color:var(--primary-dark);">
                        <?= htmlspecialchars($kullanici["kullaniciadi"]); ?>
                    </div>
                    <div style="color:#718096; font-size:14px; margin-bottom:20px;">
                        <?= htmlspecialchars($kullanici["eposta"]); ?>
                    </div>
                    <a href="kullanici_hesaplari.php?sil=<?= $kullanici["id"]; ?>" class="silmebutonu" style="display:block; text-align:center;" onclick="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz? (Sepeti ve siparişleri de silinir!)');">Kullanıcıyı Sil</a>
                </div>
        <?php
            }
        } else {
            echo '<p style="color:#718096;">Sisteme kayıtlı hiçbir müşteri bulunmamaktadır.</p>';
        }
        ?>
    </div>

</div>
    <?php include "footer.php"; ?>
</body>
</html>

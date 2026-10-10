<?php
session_start();
include "baglan.php";

if (empty($_SESSION["kullanici_id"])) {
    header("Location: giris.php");
    exit;
}
$kullanici_id = $_SESSION["kullanici_id"];
$mesajlar = [];

if (isset($_POST["sil"])) {
    $sepet_id = (int)$_POST["sepet_id"];
    $sepetteki_urunu_sil = $conn->prepare("DELETE FROM sepet WHERE id = ? AND kullanici_id = ?");
    $sepetteki_urunu_sil->execute([$sepet_id, $kullanici_id]);
    $mesajlar[] = "Ürün sepetinizden kaldırıldı.";
}

if (isset($_GET["hepsini_sil"])) {
    $sepetteki_urunu_sil = $conn->prepare("DELETE FROM sepet WHERE kullanici_id = ?");
    $sepetteki_urunu_sil->execute([$kullanici_id]);
    header("Location: sepet.php");
    exit;
}

if (isset($_POST["adedi_degistir"])) {
    $sepet_id = (int)$_POST["sepet_id"];
    $adet = (int)$_POST["adet"];
    if ($adet < 1) $adet = 1;
    if ($adet > 99) $adet = 99;
    
    $adedi_degistir = $conn->prepare("UPDATE sepet SET adet = ? WHERE id = ? AND kullanici_id = ?");
    $adedi_degistir->execute([$adet, $sepet_id, $kullanici_id]);
    $mesajlar[] = "Ürün adedi güncellendi.";
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlvonaTech - Sepetim</title>
    <link rel="stylesheet" href="css/style.css?v=<?= time(); ?>">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
    
    <?php include "header.php"; ?>

    <div style="max-width:1000px; width:100%; margin:40px auto; padding:0 20px;">
        <h1 style="font-size:36px; color:var(--primary-dark); font-weight:700; margin-bottom: 20px;">Sepetim</h1>

        <div style="display: flex; gap: 30px; align-items: flex-start;">
            
            <!-- sepetin icerigi -->
            <div style="flex:1; min-width:0;">
                <ul style="list-style:none; margin:0; padding:0; background:#fff; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.05); border:1px solid var(--border-color); overflow:hidden;">
                    <?php
                    $toplam_fiyat = 0;
                    $sepet_sec = $conn->prepare("SELECT * FROM sepet WHERE kullanici_id = ?");
                    $sepet_sec->execute([$kullanici_id]);
                    
                    if ($sepet_sec->rowCount() > 0) {
                        while ($sepeti_getir = $sepet_sec->fetch(PDO::FETCH_ASSOC)) {
                            $ara_toplam = ($sepeti_getir["sepeturunfiyati"] * $sepeti_getir["adet"]);
                            $toplam_fiyat += $ara_toplam;
                    ?>
                        <li style="padding:25px; border-bottom:1px solid #e2e8f0;">
                            <form action="" method="post" style="display:flex; gap:20px; width: 100%; margin:0;">
                                <input type="hidden" name="sepet_id" value="<?= $sepeti_getir["id"]; ?>">
                                
                                <div style="width:100px; height:100px; background:#f8fafc; border-radius:8px; display:flex; align-items:center; justify-content:center; padding:10px; flex-shrink: 0;">
                                    <?php $ilk_foto = explode(',', $sepeti_getir["sepeturunfotosu"])[0]; ?>
                                    <img src="urun_gorselleri/<?= $ilk_foto; ?>" style="max-width:100%; max-height:100%; object-fit:contain;">
                                </div>
                                
                                <div style="flex:1; min-width:0;">
                                    <h3 style="font-size:18px; color:var(--text-main); font-weight:600; margin:0 0 10px 0;"><?= $sepeti_getir["sepeturunadi"]; ?></h3>
                                    <div style="font-size:18px; font-weight:bold; color:var(--primary-dark); margin-bottom:15px;">
                                        <?= $sepeti_getir["sepeturunfiyati"]; ?>.00₺
                                    </div>
                                    
                                    <div style="display:flex; align-items:center; flex-wrap: wrap;">
                                        <div style="display:flex; align-items:center; gap:5px;">
                                            <span style="color:#4a5568; font-size:14px;">Adet:</span>
                                            <input type="number" name="adet" min="1" max="99" value="<?= $sepeti_getir["adet"]; ?>" style="width:60px; padding:5px; border:1px solid #cbd5e0; border-radius:4px; text-align:center;">
                                            <button type="submit" name="adedi_degistir" style="background:none; border:none; color:var(--button-blue); font-size:14px; cursor:pointer; text-decoration:underline;">Güncelle</button>
                                        </div>
                                        <span style="color:#cbd5e0; margin: 0 5px;">|</span>
                                        <button type="submit" name="sil" onclick="return confirm('Silmek istediğinize emin misiniz?');" style="background:none; border:none; color:#e53e3e; font-size:14px; cursor:pointer; text-decoration:underline;">Kaldır</button>
                                    </div>
                                </div>
                            </form>
                        </li>
                    <?php
                        }
                    } else {
                        echo '<li style="text-align:center; padding:40px; color:#4a5568; font-size:18px;">Sepetiniz şu an boş.</li>';
                    }
                    ?>
                </ul>
            </div>

            <!-- ekranın sagındaki ozet bolumu -->
            <div style="width:350px; flex-shrink:0; background:#fff; padding:25px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.05); border:1px solid var(--border-color);">
                <h3 style="font-size:20px; color:var(--primary-dark); border-bottom:1px solid var(--border-color); padding-bottom:15px; margin-top:0; margin-bottom:20px;">Sepet Özeti</h3>
                
                <div style="display:flex; justify-content:space-between; margin-bottom:15px; color:#4a5568;">
                    <span>Ara Toplam:</span>
                    <span><?= $toplam_fiyat; ?>.00₺</span>
                </div>
                
                <div style="display:flex; justify-content:space-between; margin-bottom:15px; color:#4a5568;">
                    <span>Vergiler ve Kargo:</span>
                    <span>Ödeme adımında hesaplanır</span>
                </div>

                <div style="display:flex; justify-content:space-between; margin-top:20px; padding-top:20px; border-top:1px solid var(--border-color); font-size:24px; font-weight:bold; color:black;">
                    <span>Toplam:</span>
                    <span><?= $toplam_fiyat; ?>.00₺</span>
                </div>

                <div style="margin-top: 30px; display:flex; flex-direction:column; gap:15px;">
                    <?php if ($toplam_fiyat > 0): ?>
                        <a href="odeme.php" class="buton" style="text-align:center; padding:15px; border-radius:8px; display:block;">Ödemeye Geç</a>
                        <a href="sepet.php?hepsini_sil" class="outline-buton-red" style="text-align:center; border-radius:8px; display:block; padding:10px;" onclick="return confirm('Tüm sepeti boşaltmak istediğinize emin misiniz?');">Sepeti Boşalt</a>
                    <?php endif; ?>
                    <a href="magaza.php" class="buton-dark" style="text-align:center; border-radius:8px; display:block; padding:10px;">Alışverişe Devam Et</a>
                </div>
            </div>

        </div>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>

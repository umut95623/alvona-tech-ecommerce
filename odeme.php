<?php
session_start();
include "baglan.php";

if (isset($_SESSION["kullanici_id"])) {
    $kullanici_id = $_SESSION["kullanici_id"];
} else {
    $kullanici_id = "";
    header("Location: giris.php");
    exit;
}

$mesajlar = [];

if (isset($_POST["odemeyitamamla"])) {
    $musteriadi = $_POST["musteriadi"];
    $telefon_no = $_POST["telefon_no"];
    $eposta = $_POST["eposta"];
    $odemesekli = $_POST["odemesekli"];
    $adres = $_POST["adres"];
    
    /*  gerçek sipariş doğrulama ve veritabanı kayıt olayları   */
    $sepet_kontrol = $conn->prepare("SELECT * FROM sepet WHERE kullanici_id = ?");
    $sepet_kontrol->execute([$kullanici_id]);
    
    if ($sepet_kontrol->rowCount() > 0) {
        $alinan_urunler_listesi = "";
        $gercek_toplam_fiyat = 0;
        
        while ($urun = $sepet_kontrol->fetch(PDO::FETCH_ASSOC)) {
            $gercek_toplam_fiyat += ($urun["sepeturunfiyati"] * $urun["adet"]);
            $alinan_urunler_listesi .= $urun["sepeturunadi"] . " (" . $urun["adet"] . " adet) | ";
        }

        $siparis_gir = $conn->prepare("INSERT INTO siparisler (kullanici_id, musteriadi, telefon_no, eposta, odemesekli, adres, alinan_urunler, toplam_fiyat) VALUES(?,?,?,?,?,?,?,?)");
        $basarili = $siparis_gir->execute([$kullanici_id, $musteriadi, $telefon_no, $eposta, $odemesekli, $adres, $alinan_urunler_listesi, $gercek_toplam_fiyat]);
        
        if ($basarili) {
            $sepeti_sil = $conn->prepare("DELETE FROM sepet WHERE kullanici_id = ?");
            $sepeti_sil->execute([$kullanici_id]);
            $mesajlar[] = "<span style='color:green; font-weight:bold;'>Sipariş başarıyla tamamlandı!</span>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlvonaTech - Ödeme</title>
    <link rel="stylesheet" href="css/style.css?v=2">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
    
    <?php include "header.php"; ?>

    <div style="max-width:1000px; margin:40px auto; padding:0 20px;">
        <h1 style="font-size:36px; color:var(--primary-dark); font-weight:700;">Ödeme</h1>

        <section class="odeme-bilgileri">
            <!-- checkout bölümü -->
            <form action="" method="POST" class="checkout-form" style="display: flex; gap:30px; width:100%;">
                
                <div style="flex:2; background:#f8fafc; padding:25px; border-radius:12px;">
                    <h3>1. Teslimat ve İletişim Bilgileri</h3>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-bottom:25px;">
                        <input type="email" name="eposta" placeholder="E-posta Adresi" required style="padding:12px; border-radius:6px; border:1px solid #cbd5e0; width:100%;">
                        <input type="number" name="telefon_no" placeholder="Telefon Numarası" required style="padding:12px; border-radius:6px; border:1px solid #cbd5e0; width:100%;">
                    </div>
                    <div style="margin-bottom:15px;">
                        <input type="text" name="musteriadi" placeholder="Ad Soyad" required style="padding:12px; border-radius:6px; border:1px solid #cbd5e0; width:100%;">
                    </div>
                    <div style="margin-bottom:15px;">
                        <input type="text" name="adres" placeholder="Adres" required style="padding:12px; border-radius:6px; border:1px solid #cbd5e0; width:100%;">
                    </div>
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:15px; margin-bottom:30px;">
                        <input type="text" name="il" placeholder="İl / İlçe" required style="padding:12px; border-radius:6px; border:1px solid #cbd5e0; width:100%;">
                        <input type="number" name="bolgekodu" placeholder="Posta Kodu" required style="padding:12px; border-radius:6px; border:1px solid #cbd5e0; width:100%;">
                        <input type="hidden" name="ilce" value="-"> 
                    </div>

                    <h3>2. Ödeme Yöntemi</h3>
                    <div style="margin-bottom:15px; display:flex; gap:20px; align-items:center;">
                        <label><input type="radio" name="odemesekli" value="Credit Card" checked> Kredi / Banka Kartı</label>
                        <label><input type="radio" name="odemesekli" value="PayPal"> PayPal</label>
                        <label><input type="radio" name="odemesekli" value="Bank Transfer"> Havale / EFT</label>
                    </div>
                    <div style="display:grid; grid-template-columns:2fr 2fr 1fr 1fr; gap:10px; margin-bottom:15px;">
                        <input type="text" placeholder="Kart Sahibinin Adı" required style="padding:12px; border-radius:6px; border:1px solid #cbd5e0; width:100%;">
                        <input type="number" placeholder="Kart Numarası" required style="padding:12px; border-radius:6px; border:1px solid #cbd5e0; width:100%;">
                        <input type="text" placeholder="(AA/YY)" required style="padding:12px; border-radius:6px; border:1px solid #cbd5e0; width:100%;">
                        <input type="number" placeholder="CVV / CVC" required style="padding:12px; border-radius:6px; border:1px solid #cbd5e0; width:100%;">
                    </div>

                </div>

                <!-- siparis ozeti kismi -->
                <div class="order-summary" style="flex:1;">
                    <h3 style="margin-bottom:20px; font-size:20px; color:var(--primary-dark);">Sipariş Özeti</h3>
                    
                    <?php
                        $ekran_toplam_fiyat = 0;
                        $sepet_sec = $conn->prepare("SELECT * FROM sepet WHERE kullanici_id = ?");
                        $sepet_sec->execute([$kullanici_id]);
                        
                        if ($sepet_sec->rowCount() > 0) {
                            while ($sepeti_getir = $sepet_sec->fetch(PDO::FETCH_ASSOC)) {
                                $ekran_toplam_fiyat += ($sepeti_getir["sepeturunfiyati"] * $sepeti_getir["adet"]);
                    ?>
                                <div style="display:flex; gap:15px; margin-bottom:15px; border-bottom:1px solid #e2e8f0; padding-bottom:10px;">
                                    <img src="urun_gorselleri/<?= $sepeti_getir["sepeturunfotosu"]; ?>" style="width:60px; height:60px; object-fit:contain; background:#f4f6f8; padding:5px; border-radius:5px;">
                                    <div>
                                        <p style="font-size:14px; font-weight:600; line-height:1.2; margin-bottom:5px;"><?= $sepeti_getir["sepeturunadi"]; ?></p>
                                        <p style="font-size:13px; color:#4a5568;">Adet: <?= $sepeti_getir["adet"]; ?> - <?= $sepeti_getir["sepeturunfiyati"]; ?>.00₺</p>
                                    </div>
                                </div>
                    <?php          
                            }
                        } else {
                            echo '<p class="bos" style="margin-bottom:20px;">Sepetiniz boş.</p>';
                        }
                    ?>

                    <div style="display:flex; justify-content:space-between; margin-bottom:10px; color:#4a5568;">
                        <span>Ara Toplam:</span>
                        <span><?= $ekran_toplam_fiyat; ?>.00₺</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:20px; color:#4a5568;">
                        <span>Kargo:</span>
                        <span>Ücretsiz</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; margin-bottom:25px; font-size:20px; font-weight:bold; color:black;">
                        <span>Toplam:</span>
                        <span><?= $ekran_toplam_fiyat; ?>.00₺</span>
                    </div>

                    <?php if ($ekran_toplam_fiyat > 0): ?>
                        <input type="submit" name="odemeyitamamla" class="buton" style="width:100%; font-size:16px; border-radius:8px;" value="Siparişi Tamamla"> 
                    <?php endif; ?>
                </div>

            </form>
        </section>
        
        <div style="text-align:center; margin-top:20px; color:green; font-weight:500; display:flex; align-items:center; justify-content:center; gap:5px;">
            
            Güvenli Alışveriş
        </div>
    </div>
    <?php include "footer.php"; ?>
</body>
</html>
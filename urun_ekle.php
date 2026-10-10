<?php
session_start();
include "baglan.php";

if (empty($_SESSION["admin_id"])) {
    header("Location: yonetici_giris.php");
    exit;
}

$mesajlar = [];

if (isset($_POST["urunekle"])) {
    $urun_adi = trim($_POST["urun_adi"]);
    $urun_fiyati = trim($_POST["urun_fiyati"]);
    $urun_bilgisi = trim($_POST["urun_bilgisi"]);

    $basarili_yuklemeler = [];

    if (isset($_FILES["urun_resmi"]) && !empty($_FILES["urun_resmi"]["name"][0])) {
        $dosya_sayisi = count($_FILES["urun_resmi"]["name"]);
        $izin_verilen_uzantilar = ['jpg', 'jpeg', 'png', 'webp'];
        $max_boyut = 2 * 1024 * 1024; 

        for ($i = 0; $i < $dosya_sayisi; $i++) {
            $dosya_gecici_yolu = $_FILES["urun_resmi"]["tmp_name"][$i];
            $dosya_adi = $_FILES["urun_resmi"]["name"][$i];
            $dosya_boyutu = $_FILES["urun_resmi"]["size"][$i];
            $dosya_uzantisi = strtolower(pathinfo($dosya_adi, PATHINFO_EXTENSION));

            if (!in_array($dosya_uzantisi, $izin_verilen_uzantilar)) {
                $mesajlar[] = "$dosya_adi: Sadece JPG, JPEG, PNG veya WEBP yükleyebilirsiniz.";
            } elseif ($dosya_boyutu > $max_boyut) {
                $mesajlar[] = "$dosya_adi: Dosya boyutu 2 MB'dan büyük olamaz.";
            } else {
                $yeni_dosya_adi = time() . "_" . $i . "_" . preg_replace("/[^a-zA-Z0-9.]/", "", basename($dosya_adi));
                $hedef_klasor = "urun_gorselleri/" . $yeni_dosya_adi;

                if (move_uploaded_file($dosya_gecici_yolu, $hedef_klasor)) {
                    $basarili_yuklemeler[] = $yeni_dosya_adi;
                } else {
                    $mesajlar[] = "$dosya_adi: Dosya yüklenirken bir sorun oluştu.";
                }
            }
        }

        if (count($basarili_yuklemeler) > 0) {
            $birlesik_fotolar = implode(",", $basarili_yuklemeler);
            $urun_ekle_sorgu = $conn->prepare("INSERT INTO urunler (urun_adi, urun_bilgisi, urun_fiyati, urunfotosu) VALUES (?,?,?,?)");
            $urun_ekle_sorgu->execute([$urun_adi, $urun_bilgisi, $urun_fiyati, $birlesik_fotolar]);
            
            $mesajlar[] = "Yeni ürün (" . count($basarili_yuklemeler) . " görsel ile) mağazaya başarıyla eklendi!";
        } else {
            $mesajlar[] = "Hiçbir görsel yüklenemedi, ürün eklenmedi.";
        }
    } else {
        $mesajlar[] = "Lütfen en az bir ürün resmi seçin.";
    }
}

if (isset($_GET["sil"])) {
    $silinecek_id = (int)$_GET["sil"];
    
    $foto_sorgu = $conn->prepare("SELECT urunfotosu FROM urunler WHERE id = ?");
    $foto_sorgu->execute([$silinecek_id]);
    $foto = $foto_sorgu->fetch(PDO::FETCH_ASSOC);
    
    if ($foto && !empty($foto["urunfotosu"])) {
        $fotolar = explode(",", $foto["urunfotosu"]);
        foreach($fotolar as $f) {
            if (file_exists("urun_gorselleri/" . $f)) {
                unlink("urun_gorselleri/" . $f);
            }
        }
    }
    
    $urunu_sil = $conn->prepare("DELETE FROM urunler WHERE id = ?");
    $urunu_sil->execute([$silinecek_id]);
    
    $sepetten_sil = $conn->prepare("DELETE FROM sepet WHERE urunid = ?");
    $sepetten_sil->execute([$silinecek_id]);

    header("Location: urun_ekle.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlvonaTech - Ürün Yönetimi</title>
    <link rel="stylesheet" href="css/style.css?v=2">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>

<?php include "yonetici_header.php"; ?>

<div style="max-width:1200px; margin:40px auto; padding:0 20px;">

    <h1 style="font-size:28px; color:var(--primary-dark); font-weight:700; margin-bottom: 20px;">Yeni Ürün Ekle</h1>

    <?php
    if (!empty($mesajlar)) {
        foreach ($mesajlar as $mesaj) {
            echo '<div style="background:#c6f6d5; color:#22543d; padding:15px; border-radius:8px; margin-bottom:20px;">'.$mesaj.'</div>';
        }
    }
    ?>
    <!--ürün ekleme kısmı-->
    <section style="background:#fff; padding:30px; border-radius:12px; box-shadow:0 4px 10px rgba(0,0,0,0.05); border:1px solid var(--border-color); margin-bottom:40px;">
        <form action="" method="post" enctype="multipart/form-data" style="max-width:600px;">
            <div class="inputBox">
                <span>Ürün Adı:</span>
                <input type="text" name="urun_adi" required>
            </div>
            <div class="inputBox">
                <span>Ürün Fiyatı (₺):</span>
                <input type="number" name="urun_fiyati" required min="1">
            </div>
            <div class="inputBox">
                <span>Ürün Açıklaması:</span>
                <textarea name="urun_bilgisi" required style="height:100px;"></textarea>
            </div>
            <div class="inputBox">
                <span>Ürün Görselleri (Birden fazla seçebilirsiniz):</span>
                <input type="file" name="urun_resmi[]" accept="image/jpg, image/jpeg, image/png, image/webp" multiple required style="background:white;">
            </div>
            <input type="submit" value="Ürünü Ekle" name="urunekle" class="buton" style="margin-top:10px;">
        </form>
    </section>
    <!-- yayındaki ürünlerin listesi -->
    <h1 style="font-size:28px; color:var(--primary-dark); font-weight:700; margin-bottom: 20px;">Yayındaki Ürünler</h1>
    <section class="box-container" style="display:grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap:20px;">
        <?php
        $urunleri_goster = $conn->prepare("SELECT * FROM urunler");
        $urunleri_goster->execute();
        if ($urunleri_goster->rowCount() > 0) {
            while ($urun = $urunleri_goster->fetch(PDO::FETCH_ASSOC)) {
        ?>
                <div class="box" style="text-align:left; display:flex; flex-direction:column; justify-content:space-between;">
                    <?php 
                    $fotolar = explode(",", $urun["urunfotosu"]); 
                    $goster_buton = count($fotolar) > 1 ? '' : 'display:none;';
                    ?>
                    <div class="carousel" data-index="0" data-fotos='<?= htmlspecialchars(json_encode($fotolar), ENT_QUOTES, 'UTF-8'); ?>' style="text-align:center; margin-bottom:15px; height:150px; display:flex; align-items:center; justify-content:center;">
                        <button type="button" class="carousel-btn left-btn" style="<?= $goster_buton; ?>">&#10094;</button>
                        <img src="urun_gorselleri/<?= $fotolar[0]; ?>" class="carousel-img" style="max-height:100%; max-width:100%; object-fit:contain;">
                        <button type="button" class="carousel-btn right-btn" style="<?= $goster_buton; ?>">&#10095;</button>
                    </div>
                    <div>
                        <div style="font-size:18px; font-weight:bold; color:var(--primary-dark);"><?= $urun["urun_fiyati"]; ?>.00₺</div>
                        <div style="font-size:18px; color:var(--primary-dark); font-weight:600; margin-bottom:5px;"><?= $urun["urun_adi"]; ?></div>
                        <div style="font-size:13px; color:#718096; height:40px; overflow:hidden; margin-bottom:15px;"><?= htmlspecialchars($urun["urun_bilgisi"]); ?></div>
                    </div>
                    <a href="urun_ekle.php?sil=<?= $urun["id"]; ?>" class="silmebutonu" style="text-align:center; display:block;" onclick="return confirm('Bu ürünü silmek istediğinize emin misiniz? Sepetlerdeki kopyaları da silinecektir!');">Ürünü Sil</a>
                </div>
        <?php
            }
        } else {
            echo '<p style="color:#718096;">Yayında hiç ürün bulunmuyor.</p>';
        }
        ?>
    </section>
</div>

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

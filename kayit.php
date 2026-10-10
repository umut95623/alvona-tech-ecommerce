<?php
session_start();
include "baglan.php";

if (isset($_SESSION["kullanici_id"])) {
    header("Location: anasayfa.php");
    exit;
}

$mesajlar = [];

if (isset($_POST["kayitol"])) {
    $kullaniciadi = trim($_POST["kullaniciadi"]);
    $eposta = trim($_POST["eposta"]);
    $kullanicisifre = trim($_POST["kullanicisifre"]);

    // bu e-posta daha önceden kullanılmış mı diye kontrol
    $hesabi_kontrol_et = $conn->prepare("SELECT id FROM kullanicilar WHERE eposta = ?");
    $hesabi_kontrol_et->execute([$eposta]);

    if ($hesabi_kontrol_et->rowCount() > 0) {
        $mesajlar[] = "Bu e-posta adresi zaten kullanılıyor.";
    } else {
        $hashli_sifre = password_hash($kullanicisifre, PASSWORD_DEFAULT);        // sifreyi modern bcrypt ile sifreliyoruz
        $kullanici_gir = $conn->prepare("INSERT INTO kullanicilar (kullaniciadi, eposta, kullanicisifre) VALUES(?,?,?)");
        $kullanici_gir->execute([$kullaniciadi, $eposta, $hashli_sifre]);
        $mesajlar[] = "Kayıt işlemi başarılı! Lütfen giriş yapınız.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlvonaTech - Üye Ol</title>
    <link rel="stylesheet" href="css/style.css?v=2">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
    <?php include "header.php"; ?>

    <section>
        <div class="giris-karti">
            <h3>
                <img src="img/logo.png" alt="Alvona Tech Logo" style="height: 36px; object-fit: contain; border-radius: 4px; vertical-align: middle; margin-right: 5px;">
                ALVONA TECH
            </h3>
            
            <div style="display:flex; justify-content:center; border-bottom: 2px solid #e2e8f0; margin-bottom: 25px;">
                <a href="giris.php" style="flex:1; padding:10px; color:#a0aec0;">Giriş yap</a>
                <a href="kayit.php" style="flex:1; padding:10px; font-weight:bold; color:var(--primary-dark); border-bottom: 3px solid var(--primary-dark);">Üye ol</a>
            </div>

            <?php
            if (!empty($mesajlar)) {
                foreach ($mesajlar as $mesaj) {
                    echo '<div style="color:#e53e3e; font-size:14px; margin-bottom:15px;">'.$mesaj.'</div>';
                }
            }
            ?>

            <form action="" method="post">
                <div class="inputBox">
                    <input type="text" name="kullaniciadi" placeholder="Adınız Soyadınız" required>
                </div>
                <div class="inputBox">
                    <input type="email" name="eposta" placeholder="E-posta adresi" required>
                </div>
                <div class="inputBox">
                    <input type="password" name="kullanicisifre" placeholder="Şifre belirleyin" required minlength="6">
                </div>
                
                <input type="submit" value="Kayıt Ol" name="kayitol" class="buton" style="width:100%; margin-top:10px;">
            </form>
            
            <div style="margin-top: 25px; font-size:13px; color:green; display:flex; align-items:center; justify-content:center; gap:5px;">  
                Güvenli alışveriş
            </div>
        </div>
    </section>
    <?php include "footer.php"; ?>
</body>
</html>

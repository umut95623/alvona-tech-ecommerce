<?php
session_start();
include "baglan.php";

if (isset($_SESSION["kullanici_id"])) {
    header("Location: anasayfa.php");
    exit;
}
$mesajlar = [];

if (isset($_POST["girisyap"])) {
    $eposta = trim($_POST["eposta"]);
    $kullanicisifre = trim($_POST["kullanicisifre"]);

    $hesabi_sec = $conn->prepare("SELECT id, kullanicisifre FROM kullanicilar WHERE eposta = ?");
    $hesabi_sec->execute([$eposta]);
    $row = $hesabi_sec->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($kullanicisifre, $row["kullanicisifre"])) {
        $_SESSION["kullanici_id"] = $row["id"];
        header("Location: anasayfa.php");
        exit;
    } else {
        $mesajlar[] = "E-posta veya şifre hatalı!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlvonaTech - Giriş Yap</title>
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
                <a href="giris.php" style="flex:1; padding:10px; font-weight:bold; color:var(--primary-dark); border-bottom: 3px solid var(--primary-dark);">Giriş yap</a>
                <a href="kayit.php" style="flex:1; padding:10px; color:#a0aec0;">Üye ol</a>
            </div>

            <form action="" method="post">
                <div class="inputBox">
                    <input type="email" name="eposta" placeholder="E-posta adresi" required>
                </div>
                <div class="inputBox" style="position:relative;">
                    <input type="password" name="kullanicisifre" placeholder="Şifre" required>
                    
                </div>
                
                <input type="submit" value="Giriş yap" name="girisyap" class="buton" style="width:100%; margin-top:10px;">
                <a href="yonetici_giris.php" class="outline-buton" style="display:block; width:100%; margin-top:20px; font-size:14px; text-align:center;">Admin Girişi'ne git</a>
            </form>
            
            <div style="margin-top: 25px; font-size:13px; color:green; display:flex; align-items:center; justify-content:center; gap:5px;">
                
                Güvenli alışveriş
            </div>
        </div>
    </section>
    <?php include "footer.php"; ?>
</body>
</html>

<?php
session_start();
include "baglan.php";

// yöntici zaten giriş yapmışsa => direkt panele yönlendir
if (isset($_SESSION["admin_id"])) {
    header("Location: yonetici_paneli.php");
    exit;
}
$mesajlar = [];
if (isset($_POST["gonder"])) {
    $yoneticiadi = trim($_POST["yoneticiadi"]);
    $yoneticisifre = trim($_POST["yoneticisifre"]);

    $yonetici_sec = $conn->prepare("SELECT id, yoneticisifre FROM yoneticiler WHERE yoneticiadi = ?");
    $yonetici_sec->execute([$yoneticiadi]);
    $row = $yonetici_sec->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($yoneticisifre, $row["yoneticisifre"])) {
        $_SESSION["admin_id"] = $row["id"];
        header("Location: yonetici_paneli.php");
        exit;
    } else {
        $mesajlar[] = "Kullanıcı adı veya şifre hatalı!";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlvonaTech - Admin Girişi</title>
    <link rel="stylesheet" href="css/style.css?v=2">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
        <?php include "header.php"; ?>
    <section>
        <div class="giris-karti">
            <h3 style="margin-bottom: 5px;">
                <img src="img/logo.png" alt="Alvona Tech Logo" style="height: 36px; object-fit: contain; border-radius: 4px; vertical-align: middle; margin-right: 5px;">
                ALVONA TECH
            </h3>
            <div style="font-weight:bold; color:#4a5568; margin-bottom: 5px; font-size:14px;">
                Admin Girişi
            </div>            
            <div style="border-bottom: 3px solid var(--primary-dark); margin-bottom: 5px; padding-bottom:8px; font-weight:bold; color:var(--primary-dark);">
                Giriş yap
            </div>
            <?php
            if (!empty($mesajlar)) {
                foreach ($mesajlar as $mesaj) {
                    echo '<div style="color:#e53e3e; font-size:14px; margin-bottom:5px; font-weight:bold;">'.$mesaj.'</div>';
                }
            }
            ?>
            <div style="color:green; font-size:12px; margin-bottom:5px;">
                Kullanıcı adı: admin | Şifre: admin123
            </div>
            <form action="" method="post">
                <div class="inputBox">
                    <input type="text" name="yoneticiadi" placeholder="Kullanıcı adı" required>
                </div>
                <div class="inputBox" style="position:relative;">
                    <input type="password" name="yoneticisifre" placeholder="Şifre" required>
                </div>
                <input type="submit" value="Giriş yap" class="buton" name="gonder" style="width: 100%; margin-top:10px;">
            </form>
        </div>
    </section>

    <?php include "footer.php"; ?>
</body>
</html>

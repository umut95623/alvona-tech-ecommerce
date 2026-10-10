<?php
session_start();
include "baglan.php";

$kullanici_id = isset($_SESSION["kullanici_id"]) ? $_SESSION["kullanici_id"] : null;
$mesajlar = [];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlvonaTech - Hakkımızda</title>
    <link rel="stylesheet" href="css/style.css?v=<?= time(); ?>">
    <style>
        .story-container {
            max-width: 900px;
            margin: 60px auto;
            padding: 0 20px;
            text-align: center;
            color: var(--text-main);
        }
        .story-title {
            font-size: 42px;
            font-weight: 300;
            margin-bottom: 20px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .story-subtitle {
            font-size: 22px;
            font-weight: 500;
            margin-bottom: 40px;
            color: var(--primary-dark);
        }
        .story-text {
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 20px;
            color: #2d3748;
        }
        .story-images {
            display: flex;
            gap: 20px;
            margin: 40px 0 15px 0;
        }
        .story-image-wrapper {
            flex: 1;
            border-radius: 16px;
            overflow: hidden;
            aspect-ratio: 4/3;
        }
        .story-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .story-caption {
            font-size: 13px;
            color: #718096;
            margin-bottom: 60px;
        }
        
        @media (max-width: 768px) {
            .story-images {
                flex-direction: column;
            }
        }
    </style>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>

    <?php include "header.php"; ?>

    <div class="story-container">
        <h1 class="baslik">Hakkımızda</h1>
        <h3 class="story-subtitle">İzmir merkezli, adımları küçük tutkusu büyük bir marka.</h3>
        
        <p class="story-text">
            Teknoloji alışverişinde size en iyi deneyimi sunmaya odaklanmış, küçük ve bağımsız bir markayız. Alışıldık karmaşa ve stresten uzak, tam olarak ihtiyacınız olan ürüne ulaşabilmeniz için bilgisayar donanımlarını, çevre birimlerini ve günlük teknolojik aygıtları özenle seçiyoruz.
        </p>
        
        <p class="story-text">
            İster ilk bilgisayarınızı topluyor, ister ofisinizi yeniliyor olun; bağlantı kurmanız, inşa etmeniz ve üretmeniz için yanınızdayız. Her siparişi bizzat kontrol edip özenle kargoluyor, her aşamada güvenilir ve güler yüzlü bir destek sunuyoruz.
        </p>
        
        <div class="story-images">
            <div class="story-image-wrapper">
                <img src="https://images.unsplash.com/photo-1587614382346-4ec70e388b28?auto=format&fit=crop&q=80&w=800" alt="Warehouse">
            </div>
            <div class="story-image-wrapper">
                <img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&q=80&w=800" alt="Team Working">
            </div>
        </div>


        <div style="margin-bottom: 20px;">
            <h3 style="font-size: 26px; font-weight: 700; color: var(--primary-dark); margin-bottom: 25px;">Setup'ını yenilemeye hazır mısın?</h3>
            <a href="magaza.php" class="buton" style="display: inline-block; padding: 12px 30px; font-size: 16px; border-radius: 8px;">Mağazayı Keşfet</a>
        </div>
        
    </div>

    <?php include "footer.php"; ?>
</body>
</html>

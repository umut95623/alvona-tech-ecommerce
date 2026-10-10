<?php
session_start();
include "baglan.php";

$kullanici_id = isset($_SESSION["kullanici_id"]) ? $_SESSION["kullanici_id"] : null;
$mesajlar = [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AlvonaTech - Yardım ve Destek</title>
    <link rel="stylesheet" href="css/style.css?v=<?= time(); ?>">
    <style>
        .support-container {
            max-width: 900px;
            margin: 60px auto;
            padding: 0 20px;
            text-align: center;
            color: var(--text-main);
        }
        .support-title {
            font-size: 42px;
            font-weight: 300;
            margin-bottom: 20px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .support-subtitle {
            font-size: 22px;
            font-weight: 500;
            margin-bottom: 40px;
            color: var(--primary-dark);
        }
        .support-text {
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 20px;
            color: #2d3748;
        }
        
        .contact-box {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            border: 1px solid var(--border-color);
            margin-top: 50px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }
        
        .contact-item {
            text-align: center;
        }
        .contact-item h4 {
            color: var(--primary-dark);
            font-size: 18px;
            margin-bottom: 15px;
        }
        .contact-item p {
            font-size: 15px;
            color: #4a5568;
            margin-bottom: 10px;
        }
        
        @media (max-width: 768px) {
            .contact-box {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>

    <?php include "header.php"; ?>

    <div class="support-container">
        <h1 class="baslik">Yardım ve Destek</h1>
        <h3 class="support-subtitle">Projem Hakkında</h3>
        
        <p class="support-text">
            Merhaba! Bu e-ticaret sitesi; ödev olarak hazırlamış olduğum, temel <strong>CRUD</strong> işlemlerini gerçekleştiren, ürün ekle-çıkar fonksiyonlarına sahip ve admin-müşteri sisteminin bulunduğu bir PHP çalışmasıdır. Projede; dinamik alışveriş sepeti sistemi, çoklu fotoğraf yükleme destekli mağaza yapısı ve kullanıcı kayıt sistemi gibi e-ticaret özellikleri yer almaktadır. Teknik altyapı olarak sistemde MySQL veritabanı kullanılmış olup, güvenlik (SQL Injection) önlemleri için sorgular uygun altyapı ile yazılmıştır. Ek olarak, bu projede yönetici panelinden admin olarak giriş yapabilmek için kullanıcı adını <strong>admin</strong>, şifresini ise <strong>admin123</strong> olarak belirledim.
            <br><br>
            Müşteri tarafında, 'Üye Ol' sayfasından ad-soyad, e-posta ve şifre girilerek sisteme kayıt olunur. Kayıt sonrasında giriş yapan bir kullanıcı; satıştaki ürünleri inceleyip istediği adette sepetine ekleyebilir, sepet sayfasında ürün adetleri güncellenebilir veya ürünler sepetten çıkarılabilir. Ödeme sayfası üzerinden alışveriş tamamlandıktan sonra da, kullanıcının vermiş olduğu tüm siparişler kendi paneline kaydedilir ve 'Siparişleriniz' sayfası üzerinden takip edilebilir. Yönetici tarafında ise; sisteme giriş yapıldıktan sonra yönetici paneli üzerinden; satışa sunulacak yeni ürünleri ve fotoğraflarını ekleyebilir, yayındaki ürünleri silebilir, müşteriler tarafından verilmiş olan siparişleri detaylıca görüntüleyip iptal edebilir ve siteye kayıt olmuş tüm kullanıcıların listesine ulaşılabilir.
        </p>
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 30px; margin-top: 40px; text-align: left;">
            <div>
                <h4 style="color: var(--primary-dark); font-size: 18px; margin-bottom: 15px;">GitHub Profilim</h4>
                <p style="font-size: 15px; color: #4a5568; margin-bottom: 10px;">Projenin kaynak kodlarına ulaşmak veya diğer projelerime göz atmak isterseniz: <a href="https://github.com/umut95623" target="_blank" style="color:var(--primary-dark); text-decoration:none; font-weight:bold;">github.com/umut95623</a></p>
            </div>
            
            <div>
                <h4 style="color: var(--primary-dark); font-size: 18px; margin-bottom: 15px;">İletişim ve Geri Bildirim</h4>
                <p style="font-size: 15px; color: #4a5568; margin-bottom: 10px;">Bana ulaşmak veya fikir vermek için e-posta gönderebilirsiniz: <a href="mailto:aumutmecek@gmail.com" style="color:var(--primary-dark); text-decoration:none; font-weight:bold;">aumutmecek@gmail.com</a></p>
            </div>
        </div>
        
        <div style="margin-top: 40px;">
            <a href="anasayfa.php" class="buton-dark" style="display: inline-block; padding: 12px 30px; font-size: 16px; border-radius: 8px;">Projeyi İncelemeye Devam Et</a>
        </div>
    </div>

    <?php include "footer.php"; ?>
</body>
</html>

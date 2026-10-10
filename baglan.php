<?php
$host = "localhost";
$dbname = "alvonatech_vt"; 
$kullaniciAdi = "root";
$sifre = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $kullaniciAdi, $sifre);
    // Pdo hata modunu Exception olarak ayarladım
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>

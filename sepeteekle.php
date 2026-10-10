<?php
session_start();
include "baglan.php";

if (empty($_SESSION["kullanici_id"])) {
    header("Location: giris.php");
    exit;
}

$kullanici_id = $_SESSION["kullanici_id"];

if (isset($_POST["sepete_ekle"])) {
    $urunid = (int)$_POST["urunid"];
    $adet = (int)$_POST["adet"];

    if ($adet < 1) $adet = 1;  /* bir adet limiti koydum*/
    if ($adet > 99) $adet = 99;
    // bu ürünün ID'si ile veritabanına gidip fiyatı ve ismi bulunup geliniyor
    $urun_sorgu = $conn->prepare("SELECT urun_adi, urun_fiyati, urunfotosu FROM urunler WHERE id = ?");
    $urun_sorgu->execute([$urunid]);
    $gercek_urun = $urun_sorgu->fetch(PDO::FETCH_ASSOC);

    if ($gercek_urun) {
        $urun_adi = $gercek_urun["urun_adi"];
        $urun_fiyati = $gercek_urun["urun_fiyati"];
        $urunfotosu = $gercek_urun["urunfotosu"];

        // bu ürün kullanıcının sepetinde zaten var mı yok mu diye kontrol ediliyor
        $sepette_var_mi = $conn->prepare("SELECT id, adet FROM sepet WHERE urunid = ? AND kullanici_id = ?");
        $sepette_var_mi->execute([$urunid, $kullanici_id]);

        if ($sepette_var_mi->rowCount() > 0) {
            // sayet zaten var ise - adetini güncelliyouz
            $mevcut_urun = $sepette_var_mi->fetch(PDO::FETCH_ASSOC);
            $yeni_adet = $mevcut_urun["adet"] + $adet;
            
            $adet_guncelle = $conn->prepare("UPDATE sepet SET adet = ? WHERE id = ?");
            $adet_guncelle->execute([$yeni_adet, $mevcut_urun["id"]]);
            
        } else {
            // sayet sepette yoksa ekliyoruz
            $sepete_ekle = $conn->prepare("INSERT INTO sepet (kullanici_id, urunid, sepeturunadi, sepeturunfiyati, adet, sepeturunfotosu) VALUES (?, ?, ?, ?, ?, ?)");
            $sepete_ekle->execute([$kullanici_id, $urunid, $urun_adi, $urun_fiyati, $adet, $urunfotosu]);
        }

        header("Location: magaza.php?eklendi=1");
        exit;
    } else {
        header("Location: magaza.php");
        exit;
    }
} else {
    header("Location: magaza.php");
    exit;
}
?>

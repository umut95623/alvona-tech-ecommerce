<?php
if(isset($mesajlar) && !empty($mesajlar)) {
    foreach($mesajlar as $mesaj) {
        echo '<div class="mesaj"><span>'.$mesaj.'</span> <button onclick="this.parentElement.remove();" style="background:none; border:none; cursor:pointer; color:inherit; font-weight:bold; font-size:16px; padding:0;">X</button></div>';
    }
}

$toplam_sepet_sayisi = 0;
if(!empty($kullanici_id)) {
    $sepet_say_sorgu = $conn->prepare("SELECT id FROM sepet WHERE kullanici_id = ?");
    $sepet_say_sorgu->execute([$kullanici_id]);
    $toplam_sepet_sayisi = $sepet_say_sorgu->rowCount();
}
?>

<header class="header">
    <!-- lacivert renkli üst kısım -->
    <div class="top-bar">
        <a href="anasayfa.php" class="logo">
            <img src="img/logo.png" alt="Alvona Tech Logo" style="height: 32px; object-fit: contain; border-radius: 4px;">
            ALVONA TECH
        </a>
        
        <div class="icons">
            <a href="sepet.php">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Sepet (<?= $toplam_sepet_sayisi; ?>)
            </a>
            <a href="<?= empty($kullanici_id) ? 'giris.php' : 'cikis.php'; ?>">
                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2M12 11a4 4 0 100-8 4 4 0 000 8z"></path></svg>
                <?= empty($kullanici_id) ? 'Giriş Yap' : 'Çıkış Yap'; ?>
            </a>
        </div>
    </div>

    <!-- açık mavi renkli alt menü -->
    <div class="sub-nav">
        <div class="flex-nav">
            <a href="magaza.php">Tüm Ürünler</a>
            <a href="siparisleriniz.php">Siparişleriniz</a>
            <a href="hakkimizda.php">Hakkımızda</a>
            <a href="yardimdestek.php">Yardım & Destek</a>
        </div>
    </div>
</header>

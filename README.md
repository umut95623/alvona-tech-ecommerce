# AlvonaTech - E-Ticaret ve Yönetim Paneli

AlvonaTech, PHP ve MySQL ile geliştirilmiş bir e-ticaret projesidir. Müşterilerin alışveriş yapabildiği bir mağaza arayüzü ile yöneticilerin ürünleri, siparişleri ve kullanıcıları yönetebildiği bir yönetici panelinden oluşur. Geçmiş yıllarda okul ödevi olarak hazırladığım, sonrasında ise kodlarını, dosya yapısını ve tasarımını güncellediğim bir çalışmadır.

**Not:** Ödeme adımı ve sayfası temsilidir. Gerçek bir ödeme alınmaz, yazılan kart bilgileri sunucuya gönderilmez ve hiçbir yere kaydedilmez.

## Proje Özellikleri

### Müşteri Tarafı
* **Kullanıcı İşlemleri:** Kayıt olma, giriş yapma ve çıkış işlemleri.
* **Ürün Kataloğu:** Veritabanından dinamik olarak çekilen ürünlerin listelenmesi ve çoklu fotoğraf desteği.
* **Alışveriş Sepeti:** Ürünleri sepete ekleme, adet güncelleme, sepetten ürün çıkarma ve sepeti tamamen boşaltma.
* **Ödeme Sayfası:** Sepetteki ürünlerin özetini görüntüleme, teslimat bilgilerini girme, ödeme yöntemi seçme ve siparişi tamamlama.
* **Sipariş Geçmişi:** Kullanıcıların daha önce verdiği siparişleri tarih, tutar, ürün ve adres bilgileriyle görüntüleyebilmesi.

### Yönetici Paneli
* **Admin Girişi:** Sisteme sadece yetkili yöneticilerin girebildiği bağımsız kontrol paneli ve ürün, sipariş, müşteri sayılarını gösteren özet ekranı.
* **Ürün Yönetimi:** Yeni ürün ekleme, fiyat/açıklama belirleme, çoklu fotoğraf yükleme ve mevcut ürünleri sistemden tamamen silme.
* **Müşteri Yönetimi:** Kayıtlı tüm kullanıcıları görebilme ve gerektiğinde kullanıcıyı (ve ona bağlı sepet/sipariş verilerini) sistemden kaldırma.
* **Sipariş Takibi:** Tüm müşterilerden gelen siparişlerin, alıcının adres ve iletişim bilgileriyle birlikte listelenmesi ve gerektiğinde iptal edilmesi.

## Kullanılan Teknolojiler

* **Back-End:** PHP 8+
* **Veritabanı:** MySQL
* **Front-End:** HTML, CSS, JavaScript

### Güvenlik
* Veritabanı sorguları SQL Injection'a karşı **PDO prepared statement** ile yazılmıştır.
* Şifreler password_hash() ile **bcrypt** kullanılarak saklanır, düz metin olarak tutulmaz.
* Müşteri ve yönetici sayfaları **session** kontrolüyle korunur.

## Kurulum Talimatları

Projeyi kendi bilgisayarınızda (localhost) çalıştırmak için aşağıdaki adımları izleyin:

1. Yerel sunucu yazılımı olarak **XAMPP**'ı kurun.
2. Proje dosyalarını XAMPP'ın htdocs klasörünün içine AlvonaTech adıyla kopyalayın.
3. XAMPP Control Panel'den **Apache** ve **MySQL**'i başlatın.
4. Tarayıcınızdan http://localhost/phpmyadmin/ adresine gidin.
5. **alvonatech_vt** adında yeni bir veritabanı (collation olarak utf8mb4_general_ci seçerek) oluşturun.
6. Oluşturduğunuz veritabanının içine girin ve üst menüden **İçe Aktar (Import)** sekmesine tıklayın.
7. Proje klasöründeki alvonatech_veritabani.sql dosyasını seçip içeri aktarın.
8. Tarayıcınızda http://localhost/AlvonaTech/ adresine giderek projeyi çalıştırın.

### Varsayılan Giriş Bilgileri

* **Yönetici Girişi:**
  * **Kullanıcı Adı:** admin
  * **Şifre:** admin123
* **Müşteri Girişi:** "Üye ol" sayfasından yeni bir hesap oluşturabilirsiniz.
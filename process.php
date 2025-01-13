<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $frequency = $_POST['frequency'];

    // RSS Kaynakları
    $rssFeeds = [
        "https://www.ahaber.com.tr/rss/program/banu-el-ile-ajans.xml",
        "https://www.ahaber.com.tr/rss/program/haktan-uysal-ile-ahaber-bugun.xml",
        "https://www.milliyet.com.tr/rss/anasayfa.xml",
        "https://www.haberturk.com/rss/manset.xml",
        "https://www.haberturk.com/rss/ekonomi.xml",
        "https://www.haberturk.com/rss/spor.xml",
        "https://www.haberturk.com/rss/magazin.xml",
        "https://www.haberturk.com/rss/kategori/siyaset.xml",
        "https://www.haberturk.com/rss/kategori/teknoloji.xml",
        "http://feeds.bbci.co.uk/turkce/rss.xml"
    ];

    // RSS Verilerini Çek
    $rssData = [];
    foreach ($rssFeeds as $feed) {
        $rssContent = simplexml_load_file($feed);
        if ($rssContent && isset($rssContent->channel->item)) {
            foreach ($rssContent->channel->item as $item) {
                $rssData[] = [
                    'title' => (string)$item->title,
                    'link' => (string)$item->link
                ];
            }
        }
    }

    // Haberleri E-posta İçeriğine Dönüştür
    $message = "Merhaba,\n\nAşağıda seçtiğiniz frekansa göre haberler bulunmaktadır:\n\n";
    foreach ($rssData as $news) {
        $message .= "- {$news['title']} ({$news['link']})\n";
    }

    // E-posta Gönderimi (mail fonksiyonu)
    if (mail($email, "RSS Bülteni", $message)) {
        echo "Bülten başarıyla gönderildi!";
    } else {
        echo "Bülten gönderiminde bir sorun oluştu.";
    }
} else {
    echo "Geçersiz istek.";
}
?>

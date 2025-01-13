<?php
header("Content-Type: application/json; charset=UTF-8");

// RSS kaynakları
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

$rssData = ['daily' => [], 'weekly' => [], 'monthly' => []];
foreach ($rssFeeds as $feed) {
    $rssContent = simplexml_load_file($feed);
    if ($rssContent && isset($rssContent->channel->item)) {
        foreach ($rssContent->channel->item as $item) {
            $news = [
                'title' => (string)$item->title,
                'link' => (string)$item->link
            ];
            $rssData['daily'][] = $news;
            $rssData['weekly'][] = $news;
            $rssData['monthly'][] = $news;
        }
    }
}

// Sadece ilk 5 haber gösteriliyor
$rssData['daily'] = array_slice($rssData['daily'], 0, 5);
$rssData['weekly'] = array_slice($rssData['weekly'], 0, 5);
$rssData['monthly'] = array_slice($rssData['monthly'], 0, 5);

echo json_encode($rssData);
?>

<?php
/**
 * sitemap-blog.php
 * XML Sitemap داینامیک برای پست‌های وبلاگ و دسته‌بندی‌ها
 * خروجی برای موتورهای جستجو (Google, Bing) به همراه lastmod از published_at
 */

header('Content-Type: application/xml; charset=UTF-8');

require_once __DIR__ . '/api/config.php';

$SITE_URL = 'https://famoacademy.ir';

$BLOG_CATEGORIES = [
    'کنکور',
    'تیزهوشان',
    'مشاوره تحصیلی',
    'روش مطالعه',
    'اخبار فامو',
];

$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

try {
    $pdo = getDB();
    $stmt = $pdo->query(
        "SELECT slug, category, DATE(published_at) AS lastmod
         FROM blog_posts
         WHERE is_published = 1 AND published_at <= NOW()
         ORDER BY published_at DESC"
    );
    $posts = $stmt->fetchAll();

    foreach ($posts as $post) {
        $lastmod = htmlspecialchars($post['lastmod'] ?? '');
        $loc = $SITE_URL . '/blog/post.html?slug=' . urlencode($post['slug']);
        $xml .= "    <url>\n";
        $xml .= "        <loc>" . $loc . "</loc>\n";
        if ($lastmod) {
            $xml .= "        <lastmod>" . $lastmod . "</lastmod>\n";
        }
        $xml .= "        <changefreq>monthly</changefreq>\n";
        $xml .= "        <priority>0.8</priority>\n";
        $xml .= "    </url>\n";
    }
} catch (Exception $e) {
    error_log(date('Y-m-d H:i:s') . " sitemap-blog Error: " . $e->getMessage() . "\n", 3, __DIR__ . '/error.log');
    // جدول هنوز ساخته نشده باشد — فقط دسته‌بندی‌های ثابت را خروجی بده
}

foreach ($BLOG_CATEGORIES as $category) {
    $loc = $SITE_URL . '/blog/category.html?category=' . urlencode($category);
    $xml .= "    <url>\n";
    $xml .= "        <loc>" . $loc . "</loc>\n";
    $xml .= "        <changefreq>weekly</changefreq>\n";
    $xml .= "        <priority>0.6</priority>\n";
    $xml .= "    </url>\n";
}

$xml .= '</urlset>';

echo $xml;
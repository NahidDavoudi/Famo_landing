<!-- Shared head: included by every page inside its own <head>. Requires $base. -->
<?php require_once __DIR__ . '/../config.php'; ?>
<?php
$famoAssetBase = famo_asset_base() ?? ($base . '../shared');
$famoApiUrl = famo_api_url();
if ($famoApiUrl === null) {
    $famoApiUrl = famo_is_dev() ? 'http://localhost:8080/api/v1' : '';
}
?>
<script>
    // Inject the server-configured asset/API URLs before any module.
    window.APP_CONFIG = Object.assign(window.APP_CONFIG || {}, {
        assetUrl: <?php echo json_encode($famoAssetBase, JSON_UNESCAPED_SLASHES); ?>,
        apiUrl: <?php echo json_encode($famoApiUrl, JSON_UNESCAPED_SLASHES); ?>
 });
 </script>
 <script src="../config.js"></script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-4NHPK2145Z"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', 'G-4NHPK2145Z');
</script>

<!-- Structured Data -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "EducationalOrganization",
    "name": "آموزشگاه فامو",
    "alternateName": "Famo Academy",
    "description": "آموزشگاه فامو نهاد آموزشی پیشرو در بابل با هفت سال سابقه در مشاوره تخصصی، آموزش مفهومی و آمادگی کنکور و تیزهوشان برای مقاطع راهنمایی و دبیرستان.",
    "url": "https://famoacademy.ir",
    "logo": "<?php echo famo_asset('images/logo.png', $base . '../shared/images/logo.png'); ?>",
    "image": "<?php echo famo_asset('images/logo.png', $base . '../shared/images/logo.png'); ?>",
    "email": "info@famoacademy.ir",
    "telephone": "+98-11-32221234",
    "address": {
        "@type": "PostalAddress",
        "addressLocality": "بابل",
        "addressRegion": "مازندران",
        "addressCountry": "IR",
        "streetAddress": "میدان باغ فردوس، جنب بیمارستان بابل کلینیک، مدرسه بهارستان"
    },
    "founder": {
        "@type": "Person",
        "name": "دکتر محمد موسی زاده موسوی"
    },
    "areaServed": {
        "@type": "City",
        "name": "بابل"
    }
}
</script>

<script src="<?php echo famo_asset('js/libs/gsap.min.js', $base . '../shared/js/libs/gsap.min.js'); ?>"></script>
<script src="<?php echo famo_asset('js/libs/ScrollTrigger.min.js', $base . '../shared/js/libs/ScrollTrigger.min.js'); ?>"></script>
<script src="<?php echo famo_asset('js/libs/ScrollToPlugin.min.js', $base . '../shared/js/libs/ScrollToPlugin.min.js'); ?>"></script>
<script src="<?php echo famo_asset('js/libs/swiper-bundle.min.js', $base . '../shared/js/libs/swiper-bundle.min.js'); ?>"></script>
<script src="<?php echo famo_asset('js/libs/lucide.min.js', $base . '../shared/js/libs/lucide.min.js'); ?>"></script>
<script src="<?php echo famo_asset('js/lucide-adapter.js', $base . '../shared/js/lucide-adapter.js'); ?>"></script>
<script src="<?php echo $base; ?>assets/js/animation.js"></script>

<!-- Font Vazir -->
<link rel="stylesheet" href="<?php echo famo_asset('css/output.css', $base . '../shared/css/output.css'); ?>">
<link rel="stylesheet" href="<?php echo $base; ?>assets/css/icons.css">
<link rel="stylesheet" href="<?php echo famo_asset('css/libs/swiper-bundle.min.css', $base . '../shared/css/libs/swiper-bundle.min.css'); ?>">
<link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
<link rel="stylesheet" href="<?php echo famo_asset('css/fonts.css', $base . '../shared/css/fonts.css'); ?>">

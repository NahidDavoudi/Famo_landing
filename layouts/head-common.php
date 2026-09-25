<!-- Shared head: included by every page inside its own <head>. Requires $base. -->
<?php require_once __DIR__ . '/../config.php'; ?>
<?= famo_config_script() ?>
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
    "url": <?= json_encode(famo_public_url(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>,
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

<!-- Google Fonts: Vazirmatn (CDN in dev, local in prod) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="<?php echo famo_google_fonts(); ?>">

<!-- Tailwind CSS (CDN in dev, built in prod) -->
<?php if (famo_is_dev()): ?>
    <script src="<?php echo famo_cdn_tailwind(); ?>"></script>
<?php else: ?>
    <link rel="stylesheet" href="<?php echo famo_cdn_tailwind(); ?>">
<?php endif; ?>

<!-- Libraries (CDN in dev, local in prod) -->
<script src="<?php echo famo_cdn_lib('gsap'); ?>" defer></script>
<script src="<?php echo famo_cdn_lib('scrolltrigger'); ?>" defer></script>
<script src="<?php echo famo_cdn_lib('scrolltoplugin'); ?>" defer></script>
<script src="<?php echo famo_cdn_lib('swiper'); ?>" defer></script>
<!-- Lucide from unpkg in dev -->
<?php if (famo_is_dev()): ?>
    <script src="https://unpkg.com/lucide@0.468.0/dist/umd/lucide.min.js" defer></script>
<?php else: ?>
    <script src="<?php echo famo_cdn_lib('lucide'); ?>" defer></script>
<?php endif; ?>
<script src="<?php echo famo_asset('js/lucide-adapter.js', $base . '../shared/js/lucide-adapter.js'); ?>" defer></script>
<script src="<?php echo $base; ?>assets/js/animation.js" defer></script>

<!-- Swiper CSS (CDN in dev, local in prod) -->
<link rel="stylesheet" href="<?php echo famo_cdn_css('swiper'); ?>">

<!-- Local styles -->
<link rel="stylesheet" href="<?php echo $base; ?>assets/css/icons.css">
<link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">

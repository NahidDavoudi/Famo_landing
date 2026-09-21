<?php $base = '../'; ?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>دوره‌های تخصصی کنکور و تیزهوشان بابل | آموزشگاه فامو</title>
    <meta name="description"
        content="دوره‌های جامع آمادهگی کنکور تجربی، ریاضی، انسانی و آزمون‌های تیزهوشان در بابل. کلاس‌های مفهومی و تست‌زنی با اساتید مدال‌آور المپیاد و رتبه‌های برتر.">
    <meta name="keywords"
        content="کلاس کنکور بابل, دوره تیزهوشان بابل, کنکور تجربی بابل, مشاوره کنکور ریاضی, آموزشگاه کنکور فامو">

    <!-- Open Graph for Social Sharing -->
    <meta property="og:title" content="دوره‌های تخصصی کنکور و تیزهوشان | آموزشگاه فامو بابل">
    <meta property="og:description" content="برنامه‌ریزی، آموزش مفهومی و آزمون‌های تخصصی کنکور و تیزهوشان در بابل.">
    <meta property="og:image" content="<?php echo $base; ?>assets/images/logo.png">

    <!-- Course Schema Markup -->
    <script type="application/ld+json" id="courseSchema">
    {
      "@context": "https://schema.org",
      "@type": "ItemList",
      "name": "دوره‌های آموزشی فامو بابل",
      "itemListElement": []
    }
    </script>

    <?php include '../partials/head-common.php'; ?>
</head>

<body class="font-family text-gray-800 bg-[#f9f7f3]">

<!-- Header -->
    <?php include '../partials/header.php' ?>

<!-- Page Title Banner -->
<section class="pt-28 sm:pt-32 pb-12 gradient-bg text-white text-center">
    <h1 class="text-3xl sm:text-4xl font-bold mb-4 text-white">دوره‌های تخصصی کنکور و تیزهوشان بابل</h1>
    <img src="<?php echo $base; ?>assets/images/courses_banner.png" alt="دوره‌های تخصصی کنکور و تیزهوشان بابل"
        class="w-full h-full object-cover">
    <div class="pt-10 lg:pt-20 container mx-auto px-4">
        <p class="text-white/80 max-w-2xl mx-auto text-base sm:text-lg">برنامه‌ریزی، کادر مجرب، آزمون‌های استاندارد
            و تحلیل پیشرفت فردی برای تضمین موفقیت تحصیلی</p>
    </div>
</section>

<!-- Detailed Courses List -->
<section class="py-16 px-4">
    <div class="container mx-auto max-w-6xl space-y-12" id="coursesContainer">
        <!-- Skeleton loaders shown until the API responds -->
        <div
            class="course-skeleton bg-white rounded-2xl shadow-xl border border-[#E2D9C6] p-6 sm:p-8 flex flex-col md:flex-row gap-8 items-center animate-pulse">
            <div class="md:w-2/3 space-y-4 w-full">
                <div class="h-5 w-32 bg-gray-200 rounded-full"></div>
                <div class="h-7 w-2/3 bg-gray-200 rounded"></div>
                <div class="h-4 w-full bg-gray-200 rounded"></div>
                <div class="h-4 w-5/6 bg-gray-200 rounded"></div>
            </div>
            <div class="md:w-1/3 w-full h-40 bg-gray-100 rounded-xl"></div>
        </div>
        <div
            class="course-skeleton bg-white rounded-2xl shadow-xl border border-[#E2D9C6] p-6 sm:p-8 flex flex-col md:flex-row gap-8 items-center animate-pulse">
            <div class="md:w-2/3 space-y-4 w-full">
                <div class="h-5 w-32 bg-gray-200 rounded-full"></div>
                <div class="h-7 w-2/3 bg-gray-200 rounded"></div>
                <div class="h-4 w-full bg-gray-200 rounded"></div>
                <div class="h-4 w-5/6 bg-gray-200 rounded"></div>
            </div>
            <div class="md:w-1/3 w-full h-40 bg-gray-100 rounded-xl"></div>
        </div>
    </div>
</section>

<!-- Footer -->
    <?php include '../partials/footer.php'?>


<script src="<?php echo $base; ?>assets/js/courses.js"></script>
</body>
</html>
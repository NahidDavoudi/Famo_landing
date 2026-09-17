<?php $base = '../'; ?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اساتید | آموزشگاه فامو بابل</title>
    <meta name="description"
        content="معرفی اساتید برجسته کنکور، رتبه‌های برتر المپیاد و تخصص مشاوران و پشتیبانان آموزشی موسسه فامو در بابل.">
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/output.css">
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/icons.css">
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/font.css">
</head>

<body class="font-family text-gray-800 bg-[#f9f7f3]">

<!-- Header -->
    <?php include '../partials/header.php' ?>

<section class="pt-36 pb-12 gradient-bg text-white text-center">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl sm:text-4xl font-bold mb-4">کادر آموزشی و مشاوران فامو بابل</h1>
        <p class="text-white/80 max-w-2xl mx-auto">همراهی اساتید مجرب و پشتیبانان رتبه برتر کنکور در تمامی مراحل
            تحصیلی</p>
    </div>
</section>

<!-- Instructors Section -->
<section class="py-16 px-4">
    <div class="container mx-auto max-w-6xl">
        <h2 class="text-2xl font-bold text-[#445D84] mb-8 border-r-4 border-[#445D84] pr-3">اساتید تخصصی کنکور و
            تیزهوشان</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="instructorsContainer">
            <!-- Instructor 1: Amir Reza Mousavadeh -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-[#E2D9C6] hover-lift transition-all duration-300">
                <div class="w-24 h-24 bg-gradient-to-br from-[#E2D9C6] to-[#d4c9b2] rounded-full flex items-center justify-center mx-auto mb-4">
                    <img src="/assets/images/staff/amirreza-mousazadeh.webp" alt="امیررضا موسازاده موسوی" class="w-16 h-16 rounded-full object-cover">
                </div>
                <h3 class="text-xl font-bold text-[#445D84] mb-2">امیررضا موسازاده موسوی</h3>
                <p class="text-gray-600 text-sm mb-1">دانشجوی پزشکی - Conquer Specialist</p>
                <p class="text-gray-600 text-xs mb-3">مدیریت داخلی، پشتیبانی، تحلیل آزمون</p>
                <ul class="text-gray-500 text-xs space-y-1">
                    <li><i class="icon icon--sm mr-1"></i> المپیاد نانو کشوری</li>
                    <li><i class="icon icon--sm mr-1"></i> تیزهوشان شهیدبهشتی سمپادی</li>
                    <li><i class="icon icon--sm mr-1"></i> ۱۲۰۰ منطقه دو</li>
                </ul>
                <a href="https://linkedin.com/in/amirreza-mousazadeh" target="_blank" class="text-[#445D84] text-sm font-medium hover:underline">لینکدین</a>
            </div>

            <!-- Instructor 2 -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-[#E2D9C6] hover-lift transition-all duration-300">
                <div class="w-24 h-24 bg-gradient-to-br from-[#E2D9C6] to-[#d4c9b2] rounded-full flex items-center justify-center mx-auto mb-4">
                    <img src="/assets/images/staff/prof-01.webp" alt="استاد birinci" class="w-16 h-16 rounded-full object-cover">
                </div>
                <h3 class="text-xl font-bold text-[#445D84] mb-2">دکتر محمد جعفری</h3>
                <p class="text-gray-600 text-sm mb-1">استاد شیمی کنکور</p>
                <p class="text-gray-600 text-xs mb-3">دکترای علومchemic، ۸ سال تدریس</p>
                <ul class="text-gray-500 text-xs space-y-1">
                    <li><i class="icon icon--sm mr-1"></i> مدرک دکتری</li>
                    <li><i class="icon icon--sm mr-1"></i> ۸۰+ مقبول کنکور</li>
                </ul>
                <a href="#" target="_blank" class="text-[#445D84] text-sm font-medium">لینکدین</a>
            </div>

            <!-- Instructor 3 -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-[#E2D9C6] hover-lift transition-all duration-300">
                <div class="w-24 h-24 bg-gradient-to-br from-[#E2D9C6] to-[#d4c9b2] rounded-full flex items-center justify-center mx-auto mb-4">
                    <img src="/assets/images/staff/prof-02.webp" alt="استاد دومی" class="w-16 h-16 rounded-full object-cover">
                </div>
                <h3 class="text-xl font-bold text-[#445D84] mb-2">دکتر الیه احمدی</h3>
                <p class="text-gray-600 text-sm mb-1">استاد فیزیک تیزهوشان</p>
                <p class="text-gray-600 text-xs mb-3">مربی گلف، ۵ سال تدریس</p>
                <ul class="text-gray-500 text-xs space-y-1">
                    <li><i class="icon icon--sm mr-1"></i> مربی گرف</li>
                    <li><i class="icon icon--sm mr-1"></i> ۵۰+ مقبول</li>
                </ul>
                <a href="#" target="_blank" class="text-[#445D84] text-sm font-medium">لینکدین</a>
            </div>

            <!-- Instructor 4 -->
            <div class="bg-white rounded-2xl p-6 shadow-lg border border-[#E2D9C6] hover-lift transition-all duration-300">
                <div class="w-24 h-24 bg-gradient-to-br from-[#E2D9C6] to-[#d4c9b2] rounded-full flex items-center justify-center mx-auto mb-4">
                    <img src="/assets/images/staff/prof-03.webp" alt="استاد سومی" class="w-16 h-16 rounded-full object-cover">
                </div>
                <h3 class="text-xl font-bold text-[#445D84] mb-2">دکتر هادی کروبی</h3>
                <p class="text-gray-600 text-sm mb-1">استاد ریاضی دبیرستان</p>
                <p class="text-gray-600 text-xs mb-3">گالری المپیاد، ۷ سال تدریس</p>
                <ul class="text-gray-500 text-xs space-y-1">
                    <li><i class="icon icon--sm mr-1"></i> المپیادplate</li>
                    <li><i class="icon icon--sm mr-1"></i> ۷۰+ مقبول</li>
                </ul>
                <a href="#" target="_blank" class="text-[#445D84] text-sm font-medium">لینکدین</a>
            </div>
        </div>
    </div>
</section>

<!-- Support Team Section -->
<section id="support" class="py-16 px-4 bg-white">
    <div class="container mx-auto max-w-6xl">
        <h2 class="text-2xl font-bold text-[#445D84] mb-8 border-r-4 border-[#445D84] pr-3">تیم پشتیبانی و رفع اشکال
            ۲۴/۷</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="supportersContainer">
            <!-- Skeleton loaders shown until the API responds -->
            <div class="bg-[#f9f7f3] rounded-2xl p-6 border border-[#E2D9C6] flex items-center gap-4 animate-pulse">
                <div class="w-16 h-16 bg-gray-200 rounded-full shrink-0"></div>
                <div class="space-y-2 w-full">
                    <div class="h-4 w-2/3 bg-gray-200 rounded"></div>
                    <div class="h-3 w-1/2 bg-gray-200 rounded"></div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- footer -->
    <?php include '../partials/footer.php'?>

<script src="<?php echo $base; ?>assets/js/team.js"></script>
</body>
</html>
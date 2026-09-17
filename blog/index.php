<?php $base = '../'; ?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>بلاگ آموزشی فامو</title>
    <meta name="description" content="پست‌های آموزشی و مقالات مرتبط با کنکور، تیزهوشان و مشاوره تحصیلی">

    <!-- Open Graph for Social Sharing -->
    <meta property="og:title" content="بلاگ آموزشی فامو">
    <meta property="og:description" content="پست‌های آموزشی و مقالات مرتبط با کنکور، تیزهوشان و مشاوره تحصیلی">
    <meta property="og:image" content="<?php echo $base; ?>assets/images/logo.png">

    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/output.css">
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/icons.css">
</head>

<body class="font-family text-gray-800">

<!-- Header -->
<header class="fixed top-0 left-0 right-0 z-50 px-2 sm:px-4 py-2 sm:py-4">
    <div
        class="bg-[#445D84] bg-opacity-95 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-xl border border-white/20 px-3 sm:px-6 py-3 sm:py-4 max-w-7xl mx-auto">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center gap-4">
                <div class="bg-[#445D84] w-12 h-12 rounded-full flex items-center justify-center shrink-0">
                    <img src="<?php echo $base; ?>assets/images/logo.png" alt="logo" class="w-10 h-10 object-contain">
                </div>
                <div>
                    <h1 class="text-white text-xl font-bold">گروه آموزشی <span class="text-[#E2D9C6]">فامو</span></h1>
                    <p class="text-white/80 text-sm">مشاوره تخصصی کنکور و تیزهوشان</p>
                </div>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:block">
                <ul class="flex items-center space-x-4 xl:space-x-6 space-x-reverse">
                    <li>
                        <a href="#home"
                            class="relative text-white hover:text-[#E2D9C6] transition-all duration-300 font-medium text-sm xl:text-base py-2 px-3 rounded-lg hover:bg-white/10 group flex items-center">
                            <svg class="icon icon--sm ml-1 opacity-70 group-hover:opacity-100" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-home" />
                            </svg>
                            خانه
                        </a>
                    </li>
                    <li>
                        <a href="#about"
                            class="relative text-white hover:text-[#E2D9C6] transition-all duration-300 font-medium text-sm xl:text-base py-2 px-3 rounded-lg hover:bg-white/10 group flex items-center">
                            <svg class="icon icon--sm ml-1 opacity-70 group-hover:opacity-100" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-help-circle" />
                            </svg>
                            درباره ما
                        </a>
                    </li>
                    <li>
                        <a href="pages/courses.php"
                            class="relative text-white hover:text-[#E2D9C6] transition-all duration-300 font-medium text-sm xl:text-base py-2 px-3 rounded-lg hover:bg-white/10 group flex items-center">
                            <svg class="icon icon--sm ml-1 opacity-70 group-hover:opacity-100" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-book" />
                            </svg>
                            دوره‌ها
                        </a>
                    </li>
                    <li>
                        <a href="pages/team.php"
                            class="relative text-white hover:text-[#E2D9C6] transition-all duration-300 font-medium text-sm xl:text-base py-2 px-3 rounded-lg hover:bg-white/10 group flex items-center">
                            <svg class="icon icon--sm ml-1 opacity-70 group-hover:opacity-100" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-school" />
                            </svg>
                            اساتید
                        </a>
                    </li>
                    <li>
                        <a href="blog/index.php"
                            class="relative text-white hover:text-[#E2D9C6] transition-all duration-300 font-medium text-sm xl:text-base py-2 px-3 rounded-lg hover:bg-white/10 group flex items-center">
                            <svg class="icon icon--sm ml-1 opacity-70 group-hover:opacity-100" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-clipboard" />
                            </svg>
                            وبلاگ
                        </a>
                    </li>
                    <li>
                        <a href="#services"
                            class="relative text-white hover:text-[#E2D9C6] transition-all duration-300 font-medium text-sm xl:text-base py-2 px-3 rounded-lg hover:bg-white/10 group flex items-center">
                            <svg class="icon icon--sm ml-1 opacity-70 group-hover:opacity-100" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-star" />
                            </svg>
                            خدمات ویژه
                        </a>
                    </li>
                    <li>
                        <a href="#faq-contact"
                            class="relative text-white hover:text-[#E2D9C6] transition-all duration-300 font-medium text-sm xl:text-base py-2 px-3 rounded-lg hover:bg-white/10 group flex items-center">
                            <svg class="icon icon--sm ml-1 opacity-70 group-hover:opacity-100" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-help-circle" />
                            </svg>
                            سوالات و تماس
                        </a>
                    </li>
                    <li>
                        <a href="http://dashboard.famoacademy.ir/"
                            class="bg-gradient-to-r from-[#E2D9C6] to-[#d4c9b2] text-[#445D84] px-5 xl:px-6 py-2.5 rounded-full font-bold hover:shadow-lg hover:shadow-[#E2D9C6]/30 transition-all duration-300 text-sm xl:text-base hover:scale-105 flex items-center gap-2">
                            <svg class="icon icon--sm" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-user-plus" />
                            </svg>
                            ثبت نام
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Mobile Menu Button -->
            <button id="mobileMenuBtn"
                class="lg:hidden text-white text-2xl hover:text-[#E2D9C6] transition duration-300"
                aria-label="باز کردن منوی موبایل" aria-expanded="false">
                <svg class="icon icon--lg" aria-hidden="true">
                    <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-menu" />
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobileMenu" class="hidden lg:hidden mt-4 pt-4 border-t border-white/20 animate-fade-in-up">
            <ul class="flex flex-col space-y-4">
                <li><a href="#home"
                        class="block text-white hover:text-[#E2D9C6] transition duration-300 font-medium py-2 hover:bg-white/10 px-3 rounded-lg">خانه</a></li>
                <li><a href="#about"
                        class="block text-white hover:text-[#E2D9C6] transition duration-300 font-medium py-2 hover:bg-white/10 px-3 rounded-lg">درباره
                    ما</a></li>
                <li><a href="pages/courses.php"
                        class="block text-white hover:text-[#E2D9C6] transition duration-300 font-medium py-2 hover:bg-white/10 px-3 rounded-lg">دوره‌ها</a></li>
                <li><a href="pages/team.php"
                        class="block text-white hover:text-[#E2D9C6] transition duration-300 font-medium py-2 hover:bg-white/10 px-3rounded-lg">اساتید</a></li>
                <li><a href="blog/index.php"
                        class="block text-white hover:text-[#E2D9C6] transition duration-300 font-medium py-2 hover:bg-white/10 px-3rounded-lg">وبلاگ</a></li>
                <li><a href="pages/team.php#support"
                        class="block text-white hover:text-[#E2D9C6] transition duration-300 font-medium py-2 hover:bg-white/10 px-3rounded-lg">پشتیبانان</a></li>
                <li><a href="#services"
                        class="block text-white hover:text-[#E2D9C6] transition duration-300 font-medium py-2 hover:bg-white/10 px-3rounded-lg">خدمات
                    ویژه</a></li>
                <li><a href="#faq-contact"
                        class="block text-white hover:text-[#E2D9C6] transition duration-300 font-medium py-2 hover:bg-white/10 px-3rounded-lg">سوالات
                    و تماس</a></li>
                <li><a href="pages/register.php"
                        class="block bg-gradient-to-r from-[#E2D9C6] to-[#d4c9b2] text-[#445D84] text-center py-3 rounded-full font-bold hover:shadow-lg transition duration-300">ثبت
                    نام</a></li>
            </ul>
        </div>
    </div>
</header>

<!-- Blog Index -->
<section class="py-24 px-4">
    <div class="container mx-auto max-w-6xl">
        <div class="mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-[#445D84] mb-4">مقالات آموزشی</h2>
            <p class="text-gray-600">بrowse the latest articles and educational posts</p>
        </div>

        <div id="categoryFilters" class="mb-8 flex flex-col sm:flex-row gap-2">
            <!-- Categories will be rendered by JavaScript -->
        </div>

        <div id="postsContainer" class="posts-loaded"></div>

        <div id="pagination" class="my-8 flex items-center justify-center"></div>
    </div>
</section>

<!-- Footer -->
<footer class="gradient-bg text-white pt-12 pb-6 px-4">
    <div class="container mx-auto max-w-6xl">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 pb-10">
            <!-- Logo & Description -->
            <div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="bg-[#445D84] w-12 h-12 rounded-full flex items-center justify-center shrink-0">
                        <img src="<?php echo $base; ?>assets/images/logo.png" alt="logo" class="w-10 h-10 object-contain">
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold">آموزشگاه <span class="text-[#E2D9C6]">فامو</span></h3>
                        <p class="text-white/80 text-sm mt-1">مشاوره تخصصی کنکور و تیزهوشان</p>
                    </div>
                </div>
                <p class="text-white/85 leading-relaxed mb-6">
                    آموزشگاه فامو با بیش از 7 سال سابقه درخشان در زمینه مشاوره و آموز컨کار و تیزهوشان، همراه
                    دانش‌آموزان در مسیر موفقیت تحصیلی است.
                </p>
                <div class="flex gap-4">
                    <a href="https://t.me/famoacademy"
                        class="bg-white/10 w-10 h-10 rounded-full flex items-center justify-center hover:bg-white/20 transition duration-300 hover:scale-110 shrink-0"
                        aria-label="تلگرام">
                        <svg class="icon" aria-hidden="true">
                            <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-telegram" />
                        </svg>
                    </a>
                    <a href="#"
                        class="bg-white/10 w-10 h-10 rounded-full flex items-center justify-center hover:bg-white/20 transition duration-300 hover:scale-110 shrink-0"
                        aria-label="اینستاگرام">
                        <svg class="icon" aria-hidden="true">
                            <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-brand-instagram" />
                        </svg>
                    </a>
                    <a href="#"
                        class="bg-white/10 w-10 h-10 rounded-full flex items-center justify-center hover:bg-white/20 transition duration-300 hover:scale-110 shrink-0"
                        aria-label="واتساپ">
                        <svg class="icon" aria-hidden="true">
                            <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-brand-whatsapp" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-xl font-bold mb-6 text-[#E2D9C6]">دسترسی سریع</h4>
                <ul class="space-y-3">
                    <li><a href="#home"
                            class="text-white/80 hover:text-white transition duration-300 hover:pr-2 flex items-center">
                        <svg class="icon icon--sm ml-2" aria-hidden="true">
                            <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-chevron-left" />
                        </svg>
                        خانه
                    </a></li>
                    <li><a href="pages/courses.php"
                            class="text-white/80 hover:text-white transition duration-300 hover:pr-2 flex items-center">
                        <svg class="icon icon--sm ml-2" aria-hidden="true">
                            <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-chevron-left" />
                        </svg>
                        دوره‌ها
                    </a></li>
                    <li><a href="pages/team.php"
                            class="text-white/80 hover:text-white transition duration-300 hover:pr-2 flex items-center">
                        <svg class="icon icon--sm ml-2" aria-hidden="true">
                            <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-chevron-left" />
                        </svg>
                        اساتید
                    </a></li>
                    <li><a href="#services"
                            class="text-white/80 hover:text-white transition duration-300 hover:pr-2 flex items-center">
                        <svg class="icon icon--sm ml-2" aria-hidden="true">
                            <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-chevron-left" />
                        </svg>
                        خدمات ویژه
                    </a></li>
                    <li><a href="#faq-contact"
                            class="text-white/80 hover:text-white transition duration-300 hover:pr-2 flex items-center">
                        <svg class="icon icon--sm ml-2" aria-hidden="true">
                            <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-chevron-left" />
                        </svg>
                        سوالات و تماس
                    </a></li>
                </ul>
            </div>

            <!-- Map Section -->
            <div>
                <h4 class="text-xl font-bold mb-6 text-[#E2D9C6]">موقعیت آموزشگاه</h4>
                <div class="bg-white/10 rounded-xl overflow-hidden border border-white/20 p-4">
                    <div class="h-48 bg-gradient-to-r from-[#E2D9C6] to-[#d4c9b2] rounded-lg flex flex-col items-center justify-center text-[#445D84]">
                        <svg class="icon icon--3xl mb-3" aria-hidden="true">
                            <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-map-pin" />
                        </svg>
                        <p class="font-bold text-center">بابل، میدان باغ فردوس</p>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="https://maps.google.com/?q=بابل، میدان باغ فردوس" target="_blank"
                            class="inline-flex items-center bg-white/20 text-white px-4 py-2 rounded-lg hover:bg-white/30 transition duration-300">
                            <svg class="icon icon--sm ml-2" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-external-link" />
                            </svg>
                            مشاهده در نقشه
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-t border-white/20 pt-6 text-center text-white/80">
            <div class="flex flex-col md:flex-row justify-between items-center gap-2">
                <p>© <span id="copyright-year">۱۴۰۳</span> تمامی حقوق برای آموزشگاه فامو محفوظ است.</p>
                <p class="text-[#E2D9C6]">مدیریت: دکتر محمد موسی زاده موسوی</p>
            </div>
            <p class="mt-4 text-sm">
                طراحی و توسعه توسط
                <a href="https://t.me/NHDVDI" target="_blank" rel="noopener"
                    class="inline-flex items-center gap-1.5 text-[#E2D9C6] hover:text-white transition duration-300 font-medium">
                    محمد حسین داودی
                    <svg class="icon icon--sm" aria-hidden="true">
                        <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-telegram" />
                    </svg>
                </a>
            </p>
        </div>
    </div>
</footer>

<script src="<?php echo $base; ?>assets/js/blog.js"></script>
</body>
</html>
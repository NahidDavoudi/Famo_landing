<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مقالات وبلاگ | آموزشگاه فامو</title>
    <meta name="description" content="مطالب آموزشی وبلاگ آموزشگاه فامو بابل">
    <meta name="robots" content="index, follow">

    <!-- Open Graph -->
    <meta property="og:title" content="مقالات وبلاگ | آموزشگاه فامو">
    <meta property="og:description" content="مطالب آموزشی وبلاگ آموزشگاه فامو بابل">
    <meta property="og:image" content="../assets/images/logo.png">

    <!-- Structured Data - updated dynamically per post by blog.js -->
    <script type="application/ld+json" id="blogPostingSchema"></script>

    <link rel="stylesheet" href="../assets/css/output.css">
    <link rel="stylesheet" href="../assets/css/icons.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/font.css">
</head>

<body class="font-family text-gray-800 bg-[#f9f7f3] min-h-screen flex flex-col" data-page="blog-post">

    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 z-50 px-2 sm:px-4 py-2 sm:py-4">
        <div
            class="bg-[#445D84] bg-opacity-95 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-xl border border-white/20 px-3 sm:px-6 py-3 sm:py-4 max-w-7xl mx-auto flex justify-between items-center">
            <a href="../index.html" class="flex items-center gap-3">
                <img src="../assets/images/logo.png" alt="لوگو آموزشگاه فامو" class="w-10 h-10 object-contain">
                <span class="text-white text-xl font-bold">وبلاگ گروه آموزشی <span class="text-[#E2D9C6]">فامو</span></span>
            </a>
            <nav class="hidden lg:block">
                <ul class="flex items-center space-x-4 xl:space-x-6 space-x-reverse text-white text-sm xl:text-base font-medium">
                    <li><a href="../index.html" class="hover:text-[#E2D9C6] transition py-2 px-3">خانه</a></li>
                    <li><a href="../pages/courses.html" class="hover:text-[#E2D9C6] transition py-2 px-3">دوره‌ها</a></li>
                    <li><a href="../pages/team.html" class="hover:text-[#E2D9C6] transition py-2 px-3">اساتید</a></li>
                    <li><a href="index.html" class="text-[#E2D9C6] font-bold py-2 px-3">وبلاگ</a></li>
                    <li><a href="../index.html#faq-contact" class="hover:text-[#E2D9C6] transition py-2 px-3">تماس با ما</a></li>
                </ul>
            </nav>
            <div class="flex items-center gap-3">
                <a href="http://dashboard.famoacademy.ir/"
                    class="hidden sm:inline-flex bg-gradient-to-r from-[#E2D9C6] to-[#d4c9b2] text-[#445D84] px-5 py-2.5 rounded-full font-bold text-sm hover:scale-105 transition">ثبت‌نام
                    آنلاین</a>
                <button id="mobileMenuBtn"
                    class="lg:hidden text-white text-2xl hover:text-[#E2D9C6] transition duration-300"
                    aria-label="باز کردن منوی موبایل" aria-expanded="false">
                    <svg class="icon icon--lg" aria-hidden="true">
                        <use href="../assets/icons/sprite.svg#icon-menu" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobileMenu" class="hidden lg:hidden mt-4 pt-4 border-t border-white/20 rounded-xl bg-[#445D84]/95 backdrop-blur-sm shadow-xl px-3 sm:px-6">
            <ul class="flex flex-col space-y-3 py-3">
                <li><a href="../index.html" class="block text-white hover:text-[#E2D9C6] transition py-2 px-3 rounded-lg font-medium">خانه</a></li>
                <li><a href="../pages/courses.html" class="block text-white hover:text-[#E2D9C6] transition py-2 px-3 rounded-lg font-medium">دوره‌ها</a></li>
                <li><a href="../pages/team.html" class="block text-white hover:text-[#E2D9C6] transition py-2 px-3 rounded-lg font-medium">اساتید</a></li>
                <li><a href="index.html" class="block text-[#E2D9C6] py-2 px-3 rounded-lg font-bold">وبلاگ</a></li>
                <li><a href="../index.html#faq-contact" class="block text-white hover:text-[#E2D9C6] transition py-2 px-3 rounded-lg font-medium">تماس با ما</a></li>
                <li><a href="http://dashboard.famoacademy.ir/" class="block bg-gradient-to-r from-[#E2D9C6] to-[#d4c9b2] text-[#445D84] text-center py-3 rounded-full font-bold transition">ثبت‌نام آنلاین</a></li>
            </ul>
        </div>
    </header>

    <!-- Article Container -->
    <section class="pt-28 sm:pt-32 pb-16 px-4">
        <div class="container mx-auto max-w-4xl">
            <!-- Skeleton -->
            <div id="postContainer">
                <div class="blog-skeleton animate-pulse">
                    <div class="bg-white rounded-3xl shadow-xl border border-[#E2D9C6] overflow-hidden">
                        <div class="h-56 sm:h-80 bg-gray-200"></div>
                        <div class="p-6 sm:p-10 space-y-4">
                            <div class="h-4 w-48 bg-gray-200 rounded"></div>
                            <div class="h-8 w-3/4 bg-gray-200 rounded"></div>
                            <div class="h-4 w-full bg-gray-200 rounded"></div>
                            <div class="h-4 w-full bg-gray-200 rounded"></div>
                            <div class="h-4 w-5/6 bg-gray-200 rounded"></div>
                            <div class="h-4 w-2/3 bg-gray-200 rounded"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="pb-16 px-4">
        <div class="container mx-auto max-w-4xl">
            <div class="bg-gradient-to-r from-[#445D84] to-[#5a779e] rounded-2xl p-8 text-center text-white shadow-xl">
                <h2 class="text-2xl font-bold mb-3">با مشاوران فامو همراه شوید</h2>
                <p class="mb-6 text-white/85 max-w-2xl mx-auto">برای مشاوره رایگان و برنامه‌ریزی تحصیلی شخصی‌سازی‌شده همین
                    الان اقدام کنید.</p>
                <a href="http://dashboard.famoacademy.ir/"
                    class="bg-white text-[#445D84] px-8 py-3 rounded-full font-bold hover:shadow-lg transition-all duration-300 hover:scale-105 inline-flex items-center">
                    رزرو مشاوره رایگان
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="gradient-bg text-white py-8 px-4 mt-auto">
        <div class="container mx-auto max-w-6xl flex flex-col md:flex-row items-center justify-between gap-4">
            <p>© <span id="copyright-year">۱۴۰۵</span> تمامی حقوق برای آموزشگاه فامو بابل محفوظ است.</p>
            <div class="flex items-center gap-6 text-sm">
                <a href="../index.html" class="hover:text-[#E2D9C6] transition">صفحه اصلی</a>
                <a href="../pages/courses.html" class="hover:text-[#E2D9C6] transition">دوره‌ها</a>
                <a href="index.html" class="hover:text-[#E2D9C6] transition">وبلاگ</a>
            </div>
        </div>
    </footer>

    <script>
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                const isHidden = mobileMenu.classList.contains('hidden');
                mobileMenu.classList.toggle('hidden');
                mobileMenuBtn.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
            });
        }
        const copyrightYear = document.getElementById('copyright-year');
        if (copyrightYear) {
            try {
                copyrightYear.textContent = new Date().toLocaleDateString('fa-IR', { year: 'numeric' });
            } catch (e) { }
        }
    </script>

    <script type="module" src="../assets/js/blog.js"></script>
</body>

</html>
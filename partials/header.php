<!-- Header fragment: parent page owns <!DOCTYPE><html><head><body> and includes partials/head-common.php. Requires $base. -->
<header class="fixed top-0 left-0 right-0 z-50 px-2 sm:px-4 py-2 sm:py-4">
    <div
        class="bg-[#445D84] bg-opacity-95 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-xl border border-white/20 px-3 sm:px-6 py-3 sm:py-4 max-w-7xl mx-auto">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo -->
            <div class="flex items-center gap-4">
                <div class="bg-[#445D84] w-12 h-12 rounded-full flex items-center justify-center shrink-0">
                    <a href="<?php echo $base?>index.php">
                        <img src="<?php echo $base; ?>assets/images/logo.png" alt="logo" class="w-12 h-12 object-contain">
                    </a>
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
                        <a href="<?php echo $base?>#home"
                            class="relative text-white hover:text-[#E2D9C6] transition-all duration-300 font-medium text-sm xl:text-base py-2 px-3 rounded-lg hover:bg-white/10 group flex items-center">
                            <svg class="icon icon--sm ml-1 opacity-70 group-hover:opacity-100" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-home" />
                            </svg>
                            خانه
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $base; ?>#about"
                            class="relative text-white hover:text-[#E2D9C6] transition-all duration-300 font-medium text-sm xl:text-base py-2 px-3 rounded-lg hover:bg-white/10 group flex items-center">
                            <svg class="icon icon--sm ml-1 opacity-70 group-hover:opacity-100" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-help-circle" />
                            </svg>
                            درباره ما
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $base; ?>courses/index.php"
                            class="relative text-white hover:text-[#E2D9C6] transition-all duration-300 font-medium text-sm xl:text-base py-2 px-3 rounded-lg hover:bg-white/10 group flex items-center">
                            <svg class="icon icon--sm ml-1 opacity-70 group-hover:opacity-100" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-book" />
                            </svg>
                            دوره‌ها
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $base; ?>team/index.php"
                            class="relative text-white hover:text-[#E2D9C6] transition-all duration-300 font-medium text-sm xl:text-base py-2 px-3 rounded-lg hover:bg-white/10 group flex items-center">
                            <svg class="icon icon--sm ml-1 opacity-70 group-hover:opacity-100" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-school" />
                            </svg>
                            اساتید
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $base; ?>blog/index.php"
                            class="relative text-white hover:text-[#E2D9C6] transition-all duration-300 font-medium text-sm xl:text-base py-2 px-3 rounded-lg hover:bg-white/10 group flex items-center">
                            <svg class="icon icon--sm ml-1 opacity-70 group-hover:opacity-100" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-clipboard" />
                            </svg>
                            وبلاگ
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $base; ?>#services"
                            class="relative text-white hover:text-[#E2D9C6] transition-all duration-300 font-medium text-sm xl:text-base py-2 px-3 rounded-lg hover:bg-white/10 group flex items-center">
                            <svg class="icon icon--sm ml-1 opacity-70 group-hover:opacity-100" aria-hidden="true">
                                <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-star" />
                            </svg>
                            خدمات ویژه
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo $base; ?>#faq-contact"
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
                class="lg:hidden text-white text-2xl hover:text-[#E2D9C6] hover:cursor-pointer transition duration-300"
                aria-label="باز کردن منوی موبایل" aria-expanded="false">
                <svg class="icon icon--lg" aria-hidden="true">
                    <use href="<?php echo $base; ?>assets/icons/sprite.svg#icon-menu" />
                </svg>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div id="mobileMenu" class="hidden lg:hidden mt-4 pt-4 border-t border-white/20 animate-fade-in-up">
            <ul class="flex flex-col space-y-4">
                <li><a href="<?php echo $base; ?>#home"
                        class="block text-white hover:text-[#E2D9C6] transition duration-300 font-medium py-2 hover:bg-white/10 px-3 rounded-lg">خانه</a></li>
                <li><a href="<?php echo $base; ?>#about"
                        class="block text-white hover:text-[#E2D9C6] transition duration-300 font-medium py-2 hover:bg-white/10 px-3 rounded-lg">درباره
                    ما</a></li>
                <li><a href="<?php echo $base; ?>courses/index.php"
                        class="block text-white hover:text-[#E2D9C6] transition duration-300 font-medium py-2 hover:bg-white/10 px-3 rounded-lg">دوره‌ها</a></li>
                <li><a href="<?php echo $base; ?>team/index.php"
                        class="block text-white hover:text-[#E2D9C6] transition duration-300 font-medium py-2 hover:bg-white/10 px-3 rounded-lg">اساتید</a></li>
                <li><a href="<?php echo $base; ?>blog/index.php"
                        class="block text-white hover:text-[#E2D9C6] transition duration-300 font-medium py-2 hover:bg-white/10 px-3 rounded-lg">وبلاگ</a></li>
                <li><a href="<?php echo $base; ?>#services"
                        class="block text-white hover:text-[#E2D9C6] transition duration-300 font-medium py-2 hover:bg-white/10 px-3 rounded-lg">خدمات
                        ویژه</a></li>
                <li><a href="<?php echo $base; ?>#faq-contact"
                        class="block text-white hover:text-[#E2D9C6] transition duration-300 font-medium py-2 hover:bg-white/10 px-3 rounded-lg">سوالات
                        و تماس</a></li>
                <li><a href="<?php echo $base; ?>pages/register.php"
                        class="block bg-gradient-to-r from-[#E2D9C6] to-[#d4c9b2] text-[#445D84] text-center py-3 rounded-full font-bold hover:shadow-lg transition duration-300">ثبت
                    نام</a></li>
            </ul>
        </div>
    </div>
</header>
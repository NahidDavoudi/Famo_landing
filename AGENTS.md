# AGENT.md - راهنمای پروژه آموزشگاه فامو (Famo Academy)

---

## معرفی کلی پروژه

**آموزشگاه فامو** یک وب‌سایت استاتیک + بک‌اند PHP برای **آموزشگاه آموزشی فامو در بابل (مازندران)** است که خدمات **مشاوره تخصصی کنکور و تیزهوشان** ارائه می‌دهد.

- **نوع سایت:** استاتیک (HTML/CSS/JS) + بک‌اند API ساده PHP/MySQL
- **زبان سایت:** فارسی (فقط فارسی - کاملاً RTL)
- **فونت:** Vazirmatn (وزیرمتن)
- **فریم‌ورک CSS:** Tailwind CSS v4 (فایل خروجی تولید شده `output.css` + فایل ورودی `input.css` با @theme سفارشی)
- **انیمیشن:** GSAP + ScrollTrigger + ScrollToPlugin + Swiper
- **آیکون‌ها:** SVG Sprite (لوکال) - `assets/icons/sprite.svg`

**آدرس سایت:** `https://famoacademy.ir`
**دامنه تست:** `famo.nadcoteam.ir`
**مدیر:** دکتر محمد موسی زاده موسوی
**طراح/توسعه‌دهنده:** محمد حسین داودی

---

## ساختار کامل پوشه‌ها

```
famo/  (ریشه پروژه = v3.10.1\famo)
│
├── .git/                       # مخزن گیت (لینال – غیرمتمرکز)
├── .gitignore                  # ignore کردن: api/.env و node_modules
├── .htaccess                   # ریدایرکت‌های لوکال (admin, dashboard)
├── AGENT.md                    # این فایل (راهنمای پروژه)
├── composer.json               # مدیریت PHP dependencies (psr-4: App\ => api/)
├── composer.lock               # قفل نسخه‌های Composer
├── package.json                # مدیریت npm scripts (Tailwind build/watch)
├── package-lock.json
├── error.log                   # لاگ خطاهای PHP (در ریشه)
├── index.html                  # صفحه اصلی سایت
├── robots.txt                  # SEO robots
├── sitemap.xml                 # Sitemap برای SEO
├── migration_courses_team.sql  # مهاجرت جداول دیتابیس (courses, team)
│
├── api/                        # بک‌اند PHP (API)
│   ├── .env                    # متغیرهای محیطی (DB credentials) — در گیت ignore شده
│   ├── auth.php                # ثبت‌نام، ورود کاربران (students/users)
│   ├── config.php              # کانفیگ DB، مسیرها، PDO Singleton
│   ├── Env.php                 # کلاس Env (لودر .env ساده، namespace App)
│   └── public.php              # API عمومی (courses, instructors, supporters)
│
├── assets/                     # فایل‌های استاتیک
│   ├── css/
│   │   ├── font.css            # @font-face برای فونت Vazirmatn
│   │   ├── icons.css           # استایل آیکون‌های SVG Sprite (.icon)
│   │   ├── input.css           # ورودی Tailwind v4 (با @theme سفارشی)
│   │   ├── output.css          # خروجی بیلد Tailwind (تولید شده — دست نزنید)
│   │   ├── register.css        # استایل صفحه ثبت‌نام
│   │   ├── style.css           # استایل سفارشی صفحات اصلی
│   │   ├── swiper.min.css      # Swiper CSS
│   │   └── swiper-bundle.min.css
│   │
│   ├── fonts/                  # فایل‌های WOFF2 فونت Vazirmatn (فارسی + لاتین)
│   │   ├── vazirmatn-arabic-{100..900}-normal.woff2
│   │   ├── vazirmatn-latin-{100..900}-normal.woff2
│   │   └── vazirmatn-latin-ext-{100..900}-normal.woff2
│   │
│   ├── icons/                  # آیکون‌های SVG (منفرد) + Sprite
│   │   ├── sprite.svg          # 🎯 اسپرایت اصلی آیکون‌ها
│   │   └── (book, calendar, chart-bar, check, chevron-left/right, clipboard,
│   │        dots, download, edit, eye, file, filter, headset, home, loader,
│   │        logout, menu, plus, report, school, search, settings, trash,
│   │        upload, user, user-plus, users, x).svg
│   │
│   ├── images/                 # تصاویر
│   │   ├── logo.png            # لوگوی اصلی
│   │   ├── courses_banner.png  # بنر صفحه دوره‌ها
│   │   ├── bakhosh.png
│   │   ├── mani.png
│   │   └── instructors/        # تصاویر اساتید
│   │
│   ├── js/                     # جاوااسکریپت‌ها
│   │   ├── animation.js        # سیستم انیمیشن GSAP (کلاس‌های FamoAnimations)
│   │   ├── main.js             # اسکریپت اصلی صفحه اصلی (Swiper, FAQ, Stats, اسکرول)
│   │   ├── courses.js          # اسکریپت صفحه دوره‌ها (API read)
│   │   ├── team.js             # اسکریپت صفحه اساتید/پشتیبانان (API read)
│   │   ├── api-client.js       # کلاینت API ادمین (JS Module)
│   │   ├── auth.js             # منطق فرم ورود/ثبت‌نام
│   │   ├── ui-helpers.js       # توابع کمکی UI (Modal, Alert, escapeHtml, formatDate)
│   │   ├── jalali.js           # تبدیل تاریخ میلادی→جلالی (ES Modules)
│   │   ├── chart.min.js        # Chart.js (minified)
│   │   ├── apexcharts.min.js   # ApexCharts (minified)
│   │   ├── chart-theme.js      # تم نمودارها
│   │   ├── gsap.min.js         # GSAP
│   │   ├── ScrollTrigger.min.js
│   │   ├── ScrollToPlugin.js
│   │   ├── swiper.min.js       # Swiper
│   │   └── swiper-bundle.min.js
│   │
│   └── svg/                    # SVGهای پرکاربرد
│       ├── eye-closed.svg
│       └── eye-open.svg
│
├── pages/                      # صفحات داخلی
│   ├── courses.html            # صفحه لیست دوره‌ها (API get_courses)
│   ├── register.html           # صفحه ثبت‌نام/ورود دانش‌آموز (auth.php)
│   └── team.html               # صفحه اساتید و پشتیبانان (API get_instructors/supporters)
│
├── uploads/                    # فایل‌های آپلودی
│   └── exams/                  # فایل‌های آزمون (PDF/تصاویر — آپلود ادمین)
│
├── node_modules/               # وابستگی‌های npm — در گیت ignore است
└── vendor/                     # وابستگی‌های Composer (phpdotenv و...) — autoload
    ├── autoload.php
    ├── composer/               # autoload classmap, psr-4, installed.json...
    └── (graham-campbell, phpoption, symfony polyfills, vlucas/phpdotenv)
```

---

## رنگ‌بندی و دیزاین تیم (Design Tokens)

رنگ‌های اصلی در `assets/css/input.css` (@theme) تعریف شده‌اند:

| متغیر | مقدار | کاربرد |
|---|---|---|
| `--color-primary` | `#445D84` (آبی سرمه‌ای) | رنگ اصلی، هدرها، دکمه‌ها، عنوان‌ها |
| `--color-primary-light` | `#E2D9C6` (کرم) | رنگ مکمل، هایلایت، متن‌های برجسته |
| `--color-accent` | `#8B786D` (قهوه‌ای خاکستری) | رنگ کمکی |
| `--color-cream` | `#f5f5f0` (کرم روشن) | پس‌زمینه‌های خاص |
| `--font-family` | `'Vazirmatn', sans-serif` | فونت اصلی |

دیگر رنگ‌های پرکاربرد در HTML (به‌صورت inline):
- پس‌زمینه صفحات: `bg-[#f9f7f3]`
- گرادیان اصلی: `bg-gradient-to-r from-[#445D84] to-[#5a779e]` (یا `gradient-bg`)
- گرادیان کرم: `from-[#E2D9C6] to-[#d4c9b2]` (یا `gradient-bg-light`)
- گرادیان ثبت‌نام: `from-[#11223C] to-[#05387e]`

**کلاس‌های کمکی سفارشی (در style.css):**
- `.gradient-bg` → گرادیان آبی `#445D84 → #3a5170`
- `.gradient-bg-light` → گرادیان کرم `#E2D9C6 → #f0e8d8`
- `.hover-lift` → هاورِ elevated کارت‌ها
- `.glass-effect` → افکت شیشه‌ای (backdrop-blur)
- `.text-gradient` → متن با گرادیان آبی

---

## دستورات Build (npm scripts)

در `package.json`:

```bash
# بیلد CSS از Tailwind v4 (خروجی: assets/css/output.css)
npm run build:css

# Watch Mode (توسعه — به‌روزرسانی خودکار CSS)
npm run watch
```

> ⚠️ **مهم:** فایل `assets/css/output.css` **تولید شده** است؛ هرگز مستقیماً آن را ویرایش نکنید. تغییرات را در `assets/css/input.css` بدهید و سپس `npm run build:css` را اجرا کنید.

**دستورات PHP/Composer:**
```bash
composer dump-autoload   # بازتولید autoload بعد از تغییر composer.json
```

---

## پیکربندی محیط (Environment)

مقادیر `.env` (در `api/.env` — نه در گیت):
```env
DB_HOST=localhost
DB_NAME=famo
DB_USER=root
DB_PASS=
```

- فایل `.env` توسط `api/Env.php` (کلاس `App\Env`) خوانده می‌شود.
- `api/config.php` از این مقادیر برای اتصال PDO (MySQL) استفاده می‌کند.

---

## پایگاه داده (MySQL)

### جداول موجود (از `migration_courses_team.sql` و کد):
1. **`courses`** — دوره‌ها: `id, name, category, badge_label, icon, gradient_color_from, gradient_color_to, background_image_url, description, full_description, target_grades, format, price, display_order`
2. **`course_features`** — ویژگی‌های دوره: `course_id, feature_text, display_order, id`
3. **`instructors`** — اساتید: `id, name, title, description, full_bio, image_url, initial_letter, display_order`
4. **`instructor_social_links`** — لینک‌های اجتماعی اساتید: `instructor_id, platform, url, display_order, id`
5. **`supporters`** — پشتیبانان: `id, name, grade, field, chat_id`
6. **`students`** — دانش‌آموزان: `id, name, grade, field, phone, created_at`
7. **`users`** — کاربران (ورود): `id, username (phone), password_hash, role, linked_id, last_login, created_at`

> جداول `admin.php` (پنل ادمین) و سایر جداول داشبورد در این کدباز نیستند؛ دامنه dashboard.a0amoacademi (dashboard.famoacademy.ir) یک سرویس جدا و خارجی است.

---

## API ها

### 1. `api/public.php` (عمومی — بدون احراز هویت)
Route شده با `?action=` :

| Action | خروجی |
|---|---|
| `get_courses` | لیست دوره‌ها + features (گروه‌بندی شده با `course_features`) |
| `get_instructors` | لیست اساتید + social_links (از `instructor_social_links`) |
| `get_supporters` | لیست پشتیبانان |

فرمت پاسخ استاندارد:
```json
{ "success": true/false, "data": [...] , "error": "..." }
```

### 2. `api/auth.php` (احراز هویت)
Route شده با `$_POST['action']` :

| Action | توضیح |
|---|---|
| `register` | ثبت‌نام دانش‌آموز (نام≥3، شماره `09...`، رمز≥4، پایه 7-12) |
| `login` | ورود (پیدا کردن کاربر با phone + password_verify) |

**قوانین:**
- ثبت‌نام: شماره موبایل یکتا؛ برای پایه≥10 رشته معتبر؛ برای پایه≤9 فیلد «راهنمایی»
- جلسه (session): `$_SESSION['user_logged_in']`, `user_id`, `user_role`, `user_phone`, `user_name`
- قالب پاسخ: `{ status: "success"/"error", message, redirect, title }`
- رمز عبور با `password_hash` / `password_verify` (PASSWORD_DEFAULT)

---

## فناوری‌ها و نسخه‌ها (package.json)

| کتابخانه | نسخه | استفاده |
|---|---|---|
| `tailwindcss` | ^4.1.18 | CSS Framework (CLI) |
| `@tailwindcss/cli` | ^4.1.18 | بیلد CSS |
| `swiper` | ^12.1.0 | اسلایدر/کاروسل |
| `gsap` | ^3.14.2 | انیمیشن |
| `chart.js` | ^4.5.1 | نمودارها |
| `@tabler/icons` | ^3.36.1 | آیکون‌ها (سپس به sprite تبدیل شده) |
| `chart` | ^0.1.2 | (کمک‌نما) |

PHP (Composer): `vlucas/phpdotenv` ^5.7

---

## صفحات (HTML)

### `index.html` — صفحه اصلی
ساختار:
- **Header** — فیکس (استیکی)، منوی دسکتاپ + موبایل (دکمه `mobileMenuBtn`)
- **Hero** (`#home`) — تیتر، دکمه‌ها، کارت آمار (`glass-effect` با شمارنده GSAP)
- **Courses** (`#courses`) — اسلایدر Swiper با دوره‌ها (از API، با اسکلتون‌لودر)
- **About** (`#about`) — توضیح درباره فامو
- **Services** (`#services`) — ۴ کارت خدمات (پشتیبانی ۲۴h، آزمون هفتگی، کلاس خصوصی، مشاوره)
- **FAQ & Contact** (`#faq-contact`) — آکاردئون سوالات + کارت اطلاعات تماس
- **Footer** — لینک‌ها، نقشه، شبکه‌های اجتماعی

اسکریپت‌ها: `animation.js`, `main.js` + کتابخانه‌های GSAP/Swiper

### `pages/courses.html` — صفحه دوره‌ها
- هدر ساده (خانه، دوره‌ها، اساتید، تماس، ثبت‌نام آنلاین)
- بنر توضیحات + لیست دوره‌ها با کارت‌های خاص (اسکلتون→API)
- فایل JS: `../assets/js/courses.js`

### `pages/team.html` — صفحه اساتید
- بنر
- بخش اساتید: `#instructorsContainer` — کارت‌های اساتید (from API)
- بخش پشتیبانان: `#supportersContainer` — کارت‌های پشتیبانان
- فایل JS: `../assets/js/team.js`

### `pages/register.html` — صفحه ثبت‌نام/ورود
- فرم دو تب (ورود / ثبت‌نام) + فرم اتصال ربات تلگرام
- استایل: `../assets/css/register.css`
- اسکریپت‌ها: inline + `assets/js/auth.js` (نکته: مسیر در HTML به `../assets/pages/register/js/auth.js` اشاره می‌کند ولی در ریشه `assets/js/auth.js` است — در صورت مشکل مسیر، بررسی کنید)

---

## الگوهای کد مهم (Conventions)

### 1. استفاده از آیکون‌ها (SVG Sprite)
```html
<svg class="icon icon--sm" aria-hidden="true">
    <use href="assets/icons/sprite.svg#icon-home" />
</svg>
```
در JS توابع کمکی وجود دارد:
```js
function svgIcon(name, cls = '') {
    const c = cls ? ` ${cls}` : '';
    return `<svg class="icon${c}" aria-hidden="true"><use href="${SPRITE_PATH}#${name}"/></svg>`;
}
```

### 2. آیکون‌های موجود در Sprite
`icon-home, icon-help-circle, icon-book, icon-school, icon-star, icon-user-plus, icon-menu, icon-x, icon-chart-bar, icon-chevron-left, icon-chevron-down, icon-chevron-right, icon-id-card, icon-map-pin, icon-phone, icon-mail, icon-telegram, icon-brand-instagram, icon-brand-whatsapp, icon-external-link, icon-check, icon-check-circle, icon-alert-circle, icon-lock, icon-login, icon-user, icon-send, icon-key` و دیگران.

### 3. API fetching در JS
```js
const PUBLIC_API_URL = 'api/public.php'; // یا '../api/public.php' در صفحات
const response = await fetch(`${PUBLIC_API_URL}?action=get_courses`);
const result = await response.json();
// استفاده: result.success ? result.data : result.error
```

### 4. رندر اسکلتون‌لودر
- قالب‌های اسکلتون داخل HTML نوشته شده و با فانکشن `showSkeletons/hideSkeletons` در main.js مدیریت می‌شوند.
- کلاس‌های ساخت skeleton داخل style.css تعریف شده (`skeleton-course-wrapper` و...).

### 5. ماپ FontAwesome → SVG (در main.js)
در دوره‌ها از آیکونهای FA مانند `fa-book` استفاده می‌شود؛ `faToSvg(faClass)` آن‌ها را به آیکون‌های اسپرایت نگاشت می‌کند (مثلاً `fa-book → icon-book`).

### 6. صفحات RTL
همه صفحات با `lang="fa"` و `dir="rtl"` هستند. برای فاصله‌گذاری در flex از `space-x-reverse` در RTL استفاده می‌شود.

### 7. انیمیشن‌های GSAP
```js
gsap.from('#element', {
    opacity: 0,
    y: 50,
    duration: 0.8,
    ease: "power2.out",
    scrollTrigger: { trigger: element, start: "top 80%" }
});
```
سیستم کامل: `assets/js/animation.js` (کلاس‌های `FamoAnimations`)

---

## SEO و Schema

- `index.html` شامل **JSON-LD** از نوع `EducationalOrganization` با اطلاعات فامو.
- `pages/courses.html` شامل **JSON-LD** از نوع `ItemList` که به‌صورت داینامیک با داده‌های API به‌روزرسانی می‌شود (`updateCourseSchema` در courses.js).
- `robots.txt` و `sitemap.xml` برای سئو تعریف شده‌اند.
- Google Analytics در index.html: `G-4NHPK2145Z`

---

## نکات توسعهدهنده (Important Notes)

1. **هرگز** `assets/css/output.css` را دستی ویرایش نکنید — از `npm run build:css` استفاده کنید.
2. `node_modules` و `api/.env` در git نیستند.
3. فایل‌های دولوپ `api/admin.php` و صفحات داشبورد (`pages/admin.html`, `dashboard.html` و...) در این کدباز **نیستند**.
4. `error.log` در ریشه ریشه برای لاگ خطاهای PHP استفاده می‌شود.
5. `uploads/exams/` برای فایل‌های آزمون، مسیر ذخیره از طریق `EXAMS_PATH` در config.php ساخته می‌شود (اگر وجود نداشته باشد).
6. `main.js` شامل ماپ آیکون و تمام متدهای مربوط به صفحه اصلی است.
7. فایل `jalali.js` از ES Modules استفاده می‌کند (`export`).

---

## ساخت صفحه جدید (برای توسعه)

برای ساخت صفحه جدید (مثلاً بلاگ) از الگوی `pages/courses.html` یا `pages/team.html` پیروی کنید:

1. `<html lang="fa" dir="rtl">`
2. لینک استایل‌ها: `output.css`, `icons.css`, `style.css`, `font.css`
3. بدنه: `class="font-family text-gray-800 bg-[#f9f7f3]"`
4. هدر فیکس (مطابق الگو)
5. داده‌ها را از `api/public.php` (یا ایستگاه static) دریافت کنید
6. از الگوی کارت‌های سفارشی با `#445D84` و `#E2D9C6` استفاده کنید
7. در انتها اسکریپت صفحه را اضافه کنید
8. اگر CSS سفارشی لازم دارید، به `assets/css/input.css` (و بعد build) یا `style.css` اضافه کنید
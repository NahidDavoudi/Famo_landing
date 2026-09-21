# Famo UI/UX Fixes Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Fix critical invalid HTML, viewport, accessibility, touch-target, and spacing issues so all pages render correctly on desktop and mobile.

**Architecture:** Fix layout shell first (header/footer duplication, viewport, scripts), then interactive components (GSAP stats, course cards, FAQ), then forms and polish (tokens, skeletons, alt text). No new features, no redesign.

**Tech Stack:** PHP partials, Tailwind CSS v4.1.18 (`assets/css/input.css` → `assets/css/output.css`), vanilla JS + GSAP + Swiper, RTL `lang="fa" dir="rtl"`.

**Spec:** `AGENTS.md` (build CSS, page conventions, tokens `--color-primary #445D84` / `--color-primary-light #E2D9C6` / `--color-accent #8B786D`) + UI/UX review findings from 2026-09-22 session.

## Global Constraints

- Never edit `assets/css/output.css` directly — edit `assets/css/input.css` or `assets/css/style.css` / `register.css`, then run `npm run build:css`.
- All pages keep `<html lang="fa" dir="rtl">`.
- Keep SVG sprite usage: `<svg class="icon icon--sm"><use href="...sprite.svg#icon-..."/></svg>`.
- Minimum touch target 44x44px on all clickable elements.
- Body text contrast minimum 4.5:1.
- Respect `prefers-reduced-motion`.

---



## File Map

> **NOTE on line numbers:** all `file:line` refs below are approximate (they shift after Task 1 edits). Before every edit, re-read the target file and locate by content/selector, never by blind line number.

- `partials/head-common.php` — **NEW**: owns shared `<head>` content (gtag, JSON-LD EducationalOrganization, CSS `<link>`s). Included by every page so analytics/SEO are preserved.
- `partials/header.php` — currently contains full `<!DOCTYPE><html><head><body><header>`; becomes header-only fragment (no doctype/head/body, no gtag/JSON-LD — those move to `head-common.php`).
- `partials/footer.php` — footer fragment only; remove duplicate GSAP/Swiper `<script>` tags (lines 127-131).
- `index.php` — owns doctype/head/body; hero stats IDs; FAQ ARIA; skeleton heights.
- `courses/index.php` — owns doctype/head; add viewport meta; banner spacing fix.
- `blog/index.php`, `blog/post.php` — add viewport meta; category swiper spacing.
- `register.php` — add viewport meta; form `aria-live`, `<label>`s, error summary.
- `assets/css/input.css` — append plain `:root` spacing vars (manual CSS only; Tailwind v4 utilities keep using `--spacing` base).
- `assets/css/style.css` — touch targets, swiper nav offsets, FAQ focus, reduced-motion, skeleton aspect ratios.
- `assets/css/register.css` — remove `style="display:none"` dependency, error `aria-live` styling.
- `assets/js/main.js` — course-card keyboard, FAQ ARIA toggle, reduced-motion guard, stats-ID guard.
- `assets/js/courses.js`, `assets/js/blog.js` — duplicate mobile-menu init dedup (call shared init, keep one copy).

---



### Task 1: Fix Invalid HTML Shell + Viewport + Duplicate Scripts

**Files:**
- Create: `partials/head-common.php`
- Modify: `partials/header.php` (head block through `<body>` — locate by content)
- Modify: `partials/footer.php` (trailing GSAP/Swiper scripts — locate by content)
- Modify: `index.php` (top shell), `courses/index.php`, `blog/index.php`, `blog/post.php`, `register.php` (head sections — locate by content)

**Interfaces:**

- Consumes: nothing.
- Produces: single `<html>/<head>/<body>` per page; `header.php`/`footer.php` are body fragments; all pages have viewport meta.

- [ ] **Step 1: Verify current duplication (failing check)**

Run: `python -c "import pathlib; h=pathlib.Path('partials/header.php').read_text(encoding='utf-8'); i=pathlib.Path('index.php').read_text(encoding='utf-8'); print('header has doctype:', '<!DOCTYPE' in h); print('index has doctype:', '<!DOCTYPE' in i); print('DUPLICATED' if '<!DOCTYPE' in h and '<!DOCTYPE' in i else 'OK')"`
Expected: `DUPLICATED`

- [ ] **Step 2: Create shared head partial (preserves gtag + SEO), strip header.php**

Create `partials/head-common.php` (move gtag + JSON-LD + CSS links here — do NOT delete):

```php
<!-- Shared head: included by every page inside its own <head>. Requires $base. -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-4NHPK2145Z"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', 'G-4NHPK2145Z');
</script>
<script type="application/ld+json">
{"@context":"https://schema.org","@type":"EducationalOrganization","name":"آموزشگاه فامو","alternateName":"Famo Academy","url":"https://famoacademy.ir","email":"info@famoacademy.ir"}
</script>
<script src="<?php echo $base; ?>assets/js/animation.js"></script>
<link rel="stylesheet" href="<?php echo $base; ?>assets/css/output.css">
<link rel="stylesheet" href="<?php echo $base; ?>assets/css/icons.css">
<link rel="stylesheet" href="<?php echo $base; ?>assets/css/swiper.min.css">
<link rel="stylesheet" href="<?php echo $base; ?>assets/css/swiper-bundle.min.css">
<link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
<link rel="stylesheet" href="<?php echo $base; ?>assets/css/font.css">
```

Then in `partials/header.php` delete everything from `<!DOCTYPE html>` through `<body ...>` + `<!-- Header -->`, leaving the file starting at `<header ...>`. Verify: `header.php` contains `<header` but NOT `<!DOCTYPE`, NOT `gtag`, NOT `application/ld+json`.

- [ ] **Step 3: Give index.php a single canonical head**

Replace `index.php:1-7` with:

```php
<?php $base=''; $page_title='آموزشگاه فامو | مشاوره کنکور و تیزهوشان بابل'; $meta_description='آموزشگاه فامو بابل - مشاوره تخصصی کنکور و تیزهوشان'; ?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo $meta_description; ?>">
    <?php include 'partials/head-common.php'; ?>
</head>
<body class="font-family text-gray-800">
```

Keep `<?php include 'partials/header.php' ?>` as-is below it. Other pages (`courses/`, `blog/`, `register.php`) use the same pattern with their own `$base` + title, then `<?php include '../partials/head-common.php'; ?>`.

- [ ] **Step 4: Add viewport + head to sub-pages**

In `courses/index.php:4-6`, `blog/post.php:6-7`, `register.php:5-6`, `blog/index.php` (add full `<head>` after `<html>` line) ensure each has:

```html
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
```

For `blog/index.php` insert missing `<head>` block mirroring `courses/index.php:4-31` (title + 4 CSS links + viewport).

- [ ] **Step 5: Remove duplicate scripts from footer.php**

Delete `partials/footer.php:127-131` (the 5 GSAP/Swiper `<script>` tags). Footer ends at `</footer>`. Page files (`index.php:522-527`) remain the single script owner.

- [ ] **Step 6: Verify fix passes**

Run: `python -c "import pathlib; h=pathlib.Path('partials/header.php').read_text(encoding='utf-8'); f=pathlib.Path('partials/footer.php').read_text(encoding='utf-8'); hc=pathlib.Path('partials/head-common.php').read_text(encoding='utf-8'); print('header doctype gone:', '<!DOCTYPE' not in h); print('gtag preserved in head-common:', 'gtag' in hc and 'ld+json' in hc); print('footer scripts gone:', 'gsap.min.js' not in f.lower()); print('viewport courses:', 'viewport' in pathlib.Path('courses/index.php').read_text(encoding='utf-8')); print('viewport blog:', 'viewport' in pathlib.Path('blog/index.php').read_text(encoding='utf-8')); print('viewport post:', 'viewport' in pathlib.Path('blog/post.php').read_text(encoding='utf-8')); print('viewport register:', 'viewport' in pathlib.Path('register.php').read_text(encoding='utf-8'))"`
Expected: all `True`

- [ ] **Step 7: Commit**

```bash
git add partials/head-common.php partials/header.php partials/footer.php index.php courses/index.php blog/index.php blog/post.php register.php
git commit -m "fix: single html shell, viewport on all pages, dedup scripts"
```

---



### Task 2: Hero Stats IDs + Reduced-Motion Guard

**Files:**

- Modify: `index.php:52-64`
- Modify: `assets/js/main.js:515-557`
- Modify: `assets/css/style.css` (append reduced-motion block)

**Interfaces:**

- Consumes: Task 1 (valid body).
- Produces: `#years-counter`, `#students-counter`, `#teachers-counter` exist; GSAP no-ops under reduced motion.

- [ ] **Step 1: Verify missing IDs (failing check)**

Run: `python -c "import pathlib; t=pathlib.Path('index.php').read_text(encoding='utf-8'); print('years-counter' in t, 'students-counter' in t, 'teachers-counter' in t)"`
Expected: `False False False`

- [ ] **Step 2: Add IDs to hero stats in index.php**

Replace the three stat number divs:

```php
<div class="text-2xl font-bold mb-1 text-white" id="years-counter">7</div>
<div class="text-white/70 text-xs">سال تجربه</div>
...
<div class="text-2xl font-bold mb-1 text-white" id="students-counter">500+</div>
<div class="text-white/70 text-xs">قبولی کنکور</div>
...
<div class="text-2xl font-bold mb-1 text-white" id="teachers-counter">15</div>
<div class="text-white/70 text-xs">استاد برتر</div>
```

- [ ] **Step 3: Guard GSAP counter + scroll animations for reduced motion**

In `assets/js/main.js`, at top of `animateCounter` add:

```js
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
function animateCounter(elementId, finalValue) {
    const element = document.getElementById(elementId);
    if (!element) return;
    if (prefersReducedMotion || typeof gsap === 'undefined') {
        element.textContent = finalValue;
        return;
    }
```

In `initScrollAnimations()` add as first line:

```js
if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
```

- [ ] **Step 4: Add CSS reduced-motion kill-switch**

Append to `assets/css/style.css`:

```css
@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
  .animate-float, .animate-shimmer { animation: none !important; }
}
```

- [ ] **Step 5: Verify**

Run: `python -c "import pathlib; t=pathlib.Path('index.php').read_text(encoding='utf-8'); j=pathlib.Path('assets/js/main.js').read_text(encoding='utf-8'); print(all(s in t for s in ['years-counter','students-counter','teachers-counter'])); print('prefers-reduced-motion' in j)"`
Expected: `True True`

- [ ] **Step 6: Commit**

```bash
git add index.php assets/js/main.js assets/css/style.css
git commit -m "fix: hero stat ids and reduced-motion guard"
```

---



### Task 3: Keyboard + ARIA for Course Cards and FAQ

**Files:**

- Modify: `assets/js/main.js:162-204` (course card template), `assets/js/main.js:458-503` (listeners), `assets/js/main.js:560-660` (FAQ)
- Modify: `index.php:360-435` (FAQ markup)
- Modify: `assets/css/style.css:249-264` (FAQ focus style)

**Interfaces:**

- Consumes: Task 1.
- Produces: cards operable via Enter/Space; FAQ exposes `aria-expanded`/`aria-controls`.

- [ ] **Step 1: Verify missing keyboard support (failing check)**

Run: `python -c "import pathlib; j=pathlib.Path('assets/js/main.js').read_text(encoding='utf-8'); print('keydown' in j and 'course-card' in j)"`
Expected: `False`

- [ ] **Step 2: Make course cards focusable buttons in template**

In `loadCoursesFromAPI` template replace `<div class="course-card` with:

```js
`<div class="swiper-slide">
    <div class="course-card md:w-full h-48 sm:h-40 md:h-auto rounded-2xl flex items-center justify-center relative overflow-hidden min-h-[200px] cursor-pointer"
         tabindex="0" role="button" aria-expanded="false" aria-controls="course-desc-${course.id}"
         data-expanded="false"
         data-course-id="${course.id}" aria-label="${course.name} - برای دیدن جزئیات Enter بزنید">`
```

And in the expanded-content div add the matching id:

```js
`<div class="course-content-expanded absolute inset-0 z-30 flex flex-col items-center justify-center p-6 opacity-0 transform translate-y-4 transition-all duration-500" id="course-desc-${course.id}">`
```

- [ ] **Step 3: Add keyboard handler + aria-expanded sync**

In `attachCourseCardListeners()`, after the `newCard.addEventListener('click', ...)` block add:

```js
newCard.addEventListener('keydown', function (e) {
    if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); this.click(); }
});
```

Inside both expand/collapse branches add `this.setAttribute('aria-expanded', 'true'/'false')` matching `data-expanded`.

- [ ] **Step 4: FAQ ARIA markup + focus style**

In `index.php` each `.faq-question` div add `tabindex="0" role="button" aria-expanded="false"`:

```php
<div class="faq-question cursor-pointer p-5 flex justify-between items-center" tabindex="0" role="button" aria-expanded="false">
```

In `FAQ.open`/`FAQ.close` add `item.querySelector('.faq-question').setAttribute('aria-expanded','true'/'false')`. In `FAQ.init` question listener add keydown for Enter/Space:

```js
question.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); this.toggle(newItem, answer); }
});
```

Append to `style.css`:

```css
.faq-question:focus-visible { outline: 2px solid #445D84; outline-offset: 2px; border-radius: 0.75rem; }
.course-card:focus-visible { outline: 2px solid #E2D9C6; outline-offset: 3px; }
```

- [ ] **Step 5: Verify**

Run: `python -c "import pathlib; j=pathlib.Path('assets/js/main.js').read_text(encoding='utf-8'); print('aria-expanded' in j and 'keydown' in j)"`
Expected: `True`

- [ ] **Step 6: Commit**

```bash
git add assets/js/main.js index.php assets/css/style.css
git commit -m "fix: keyboard and aria for course cards and faq"
```

---



### Task 4: Touch Targets + Spacing Tokens + Swiper Nav Offset

**Files:**

- Modify: `assets/css/input.css`
- Modify: `partials/header.php:169-192`
- Modify: `assets/css/style.css:153-190`
- Modify: `index.php:21-36,273`

**Interfaces:**

- Consumes: Task 1.
- Produces: 44px-min targets; `--space-*` tokens; swiper buttons 20px+ from edges.

- [ ] **Step 1: Verify missing tokens (failing check)**

Run: `python -c "import pathlib; print('--space-' in pathlib.Path('assets/css/input.css').read_text(encoding='utf-8'))"`
Expected: `False`

- [ ] **Step 2: Add spacing vars for manual CSS (Tailwind v4 note)**

> Tailwind v4 derives `p-4`/`gap-8` from the single `--spacing: 0.25rem` base — custom `--space-*` in `@theme` does NOT retarget those utilities. So: keep standard Tailwind classes as the system, and define plain `:root` vars only for hand-written CSS in `style.css`/`register.css` (used via `var(--space-4)`).

In `assets/css/input.css`, keep `@theme` colors/fonts untouched and append AFTER the `@theme` block:

```css
:root {
  --space-1: 0.25rem;
  --space-2: 0.5rem;
  --space-4: 1rem;
  --space-6: 1.5rem;
  --space-8: 2rem;
  --space-12: 3rem;
  --space-16: 4rem;
}
```

- [ ] **Step 3: Fix mobile menu + hero CTA touch targets**

In `partials/header.php` mobile links change `py-2` → `py-3` (all 7 links). In `index.php:21` hero CTA row change `gap-5` → `gap-3 sm:gap-5`, and both CTA `<a>` add `min-h-[44px]` class.

- [ ] **Step 4: Move swiper nav off screen edges**

In `assets/css/style.css` change `.swiper-button-prev { right: 15px }` / `.swiper-button-next { left: 15px }` (lines 182-190) and the instructors/support overrides (lines 192-234) from `15px` → `22px`, and add:

```css
.swiper-button-next, .swiper-button-prev { min-width: 44px; min-height: 44px; }
@media (max-width: 640px) {
  .swiper-button-next, .swiper-button-prev { width: 44px !important; height: 44px !important; }
}
```

- [ ] **Step 5: Rebuild CSS and verify**

Run: `npm run build:css`
Expected: completes without error; `output.css` contains `--space-8`.

- [ ] **Step 6: Commit**

```bash
git add assets/css/input.css assets/css/output.css assets/css/style.css partials/header.php index.php
git commit -m "fix: touch targets, spacing tokens, swiper nav offset"
```

---



### Task 5: Register Form Accessibility + Remove Inline Display Hacks

**Files:**

- Modify: `register.php:38-171`
- Modify: `assets/css/register.css`

**Interfaces:**

- Consumes: Task 1.
- Produces: labeled inputs, `aria-live` errors, focusable error summary, no inline `display:none` logic.

- [ ] **Step 1: Verify missing labels/live regions (failing check)**

Run: `python -c "import pathlib; t=pathlib.Path('register.php').read_text(encoding='utf-8'); print('<label' in t, 'aria-live' in t)"`
Expected: `False False`

- [ ] **Step 2: Add labels + aria attributes to login form**

Before `#loginPhone` input insert `<label for="loginPhone" class="sr-only">شماره موبایل</label>`, add `aria-describedby="loginPhoneErr"`. Change `<span class="error-message">` → `<span class="error-message" id="loginPhoneErr" aria-live="polite">`. Repeat for `#loginPassword` (`loginPassErr`), `#registerFullName` (`regNameErr`), `#registerPhone` (`regPhoneErr`), `#registerPassword` (`regPassErr`), `#registerGrade` (`regGradeErr`), `#registerField` (`regFieldErr`).

- [ ] **Step 3: Add error summary + replace inline hide**

After `<div class="form-container relative overflow-hidden">` insert:

```php
<div id="formErrorSummary" class="hidden mb-4 rounded-xl border-2 border-red-400 bg-red-50 p-4 text-red-700" role="alert" tabindex="-1"></div>
```

Replace `<div id="registerFormContainer" style="display: none;">` with `<div id="registerFormContainer" class="hidden">` and `<div class="mt-6 text-center" style="display: none;">` with `<div class="mt-6 text-center hidden">`. In `validateForm()` on failure populate `#formErrorSummary` with count + first-error link and call `.focus()`.

Add fallback guard at top of `assets/css/register.css` (in case Tailwind `content`/purge ever drops `.hidden`):

```css
.hidden { display: none !important; }
```

Verify `hidden` resolves: after `npm run build:css`, `output.css` must contain `.hidden` OR the fallback above covers it.

- [ ] **Step 4: Verify**

Run: `python -c "import pathlib; t=pathlib.Path('register.php').read_text(encoding='utf-8'); print(t.count('<label'), 'aria-live' in t, 'formErrorSummary' in t, 'style=\"display: none' not in t)"`
Expected: `7+ True True True`

- [ ] **Step 5: Commit**

```bash
git add register.php assets/css/register.css
git commit -m "fix: register form labels, live errors, error summary"
```

---



### Task 6: Skeletons, Images, Footer Links, Container Consistency

**Files:**

- Modify: `index.php:84-145,170-230`
- Modify: `assets/css/style.css:397-446`
- Modify: `assets/js/blog.js:88-118,328-336`
- Modify: `partials/footer.php:48-84`
- Modify: `courses/index.php:40-48`, `blog/index.php:10-16`

**Interfaces:**

- Consumes: Tasks 1-4.
- Produces: no layout shift on load; descriptive alts; working footer links; consistent banner padding.

- [ ] **Step 1: Verify layout-shift risk (failing check)**

Run: `python -c "import pathlib; print('aspect-' in pathlib.Path('assets/css/style.css').read_text(encoding='utf-8'))"`
Expected: `False`

- [ ] **Step 2: Lock skeleton aspect ratios**

Append to `assets/css/style.css`:

```css
.skeleton-course-card, .course-card { aspect-ratio: 16/9; min-height: 200px; }
@media (min-width: 768px) { .skeleton-course-card, .course-card { aspect-ratio: 21/9; } }
.skeleton-instructor-card, .instructor-card { min-height: 380px; }
```

- [ ] **Step 3: Blog cover alt + footer link fixes**

In `assets/js/blog.js` `renderPostCard` cover img change `alt="${post.title} | آموزشگاه فامو"` → `alt="تصویر شاخص: ${post.title}"`. In `renderPost` cover img add `loading="lazy"`. In `partials/footer.php` fix dead links: `../pages/courses.php` → `<?php echo $base; ?>courses/index.php`, `../teams/index.php` → `<?php echo $base; ?>team/index.php`, `href="#"` socials → real URLs with `aria-label="فامو در اینستاگرام"` / `"فامو در واتساپ"`.

- [ ] **Step 4: Unify banner top padding for fixed header**

`courses/index.php:40` change `pt-24 pb-12` → `pt-28 sm:pt-32 pb-12`; `blog/index.php:10` change `pt-36 pb-12` → `pt-28 sm:pt-32 pb-12`. Both keep `px-4`.

- [ ] **Step 5: Verify**

Run: `python -c "import pathlib; s=pathlib.Path('assets/css/style.css').read_text(encoding='utf-8'); f=pathlib.Path('partials/footer.php').read_text(encoding='utf-8'); print('aspect-ratio' in s and '../pages/courses.php' not in f and '../teams/index.php' not in f)"`
Expected: `True`

- [ ] **Step 6: Commit**

```bash
git add index.php assets/css/style.css assets/js/blog.js partials/footer.php courses/index.php blog/index.php
git commit -m "fix: skeletons, image alts, footer links, banner spacing"
```

---



## Manual QA (run after all tasks)

- [ ] Open `index.php` at 375px, 768px, 1024px, 1440px — no horizontal scroll, hero CTAs tappable, stats visible.
- [ ] Keyboard-only: Tab through header → hero → course card (Enter expands) → FAQ (Enter toggles) → footer.
- [ ] Register page: submit empty login → error summary receives focus, screen reader announces errors.
- [ ] DevTools Network throttled: skeletons hold size, no layout jump when API resolves.
- [ ] `npm run build:css` clean; `git status` shows only intended files.
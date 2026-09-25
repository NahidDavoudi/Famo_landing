# AGENTS.md - Famo Academy (public site)

## Directory structure
```text
public/
├── index.php          # home page
├── assets/
│   ├── css/           # page-specific CSS (style.css, icons.css)
│   ├── js/            # page loaders + shared API client import
│   └── images/        # page-specific images
├── layouts/
│   ├── head-common.php
│   ├── header.php
│   └── footer.php
└── pages/
    ├── course.php
    ├── blog.php
    ├── team.php
    └── post.php
```
- Every page sets `$base` (`''` at root, `'../'` inside `pages/`) and includes `layouts/*`.
- Only page-specific code/assets live under `public/`; shared runtime assets come from `shared/`.

## Shared assets
- Backend (separate project): `api/` served at the `API_URL` configured in `.env`.
- API client: `shared/js/api.js` (loaded from the `ASSET_URL` configured in `.env`).
- Libraries: `shared/js/libs/` (GSAP, ScrollTrigger, ScrollToPlugin, Swiper, Lucide).
- Styles: `shared/css/output.css`, `shared/css/fonts.css`, `shared/css/libs/swiper-bundle.min.css`.
- Icons: Lucide. Static markup uses `data-lucide="..."`; dynamic markup uses `data-lucide` via `svgIcon()`.
- `shared/js/lucide-adapter.js` initializes icons and exposes `window.refreshLucideIcons()`.

## CSS build
- Tailwind source: `shared/css/input.css` (scans `public/**/*.php` and `public/**/*.js`).
- Build from `shared/`: `npm run build:css`.
- Never edit `shared/css/output.css` directly.

## API usage
- All page data comes from the unified API via `shared/js/api.js`.
- Public endpoints: `/public/courses`, `/public/instructors`, `/public/supporters`, `/public/blog/*`.
- Response envelope: `{ success, data, pagination, error }`.
- Authentication is out of scope for this public site.

## Conventions
- All pages: `<html lang="fa" dir="rtl">`; flex `space-x-reverse` handles RTL.
- Page loaders: `main.js` (home), `courses.js` (course), `team.js` (team), `blog.js` (blog/post).
- `pages/blog.php` and `pages/post.php` declare `data-page="blog-index"` / `data-page="blog-post"`.

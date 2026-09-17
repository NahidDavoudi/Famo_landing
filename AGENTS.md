# AGENTS.md - Famo Academy

## Build & CSS
- `npm run build:css` — builds Tailwind from `assets/css/input.css` → `assets/css/output.css`
- `npm run watch` — watch mode for development
- **Critical:** Never edit `output.css` directly. Edit `input.css` then re-run `build:css`.
- `composer dump-autoload` — after changing `composer.json`

## Environment
- `api/.env` is **gitignored**. Create it with:
  ```
  DB_HOST=localhost
  DB_NAME=famo
  DB_USER=root
  DB_PASS=
  ```
- Loaded by `api/Env.php` → used in `api/config.php` for PDO connection.
- `EXAMS_PATH` in config.php defines `uploads/exams/` directory.

## API Endpoints (api/public.php)
Route with `?action=`:
- `get_courses` — returns courses + `features` (grouped via `course_features`)
- `get_instructors` — returns instructors + `social_links` (from `instructor_social_links`)
- `get_supporters` — returns supporters

**Response format:** `{ success: true/false, data: [...], error: "..." }`

**Auth (api/auth.php):** route with `$_POST['action']`:
- `register` — validate phone `09...`, grade 7-12, unique phone; hash with `password_hash`
- `login` — verify phone+password with `password_verify`; sets session vars

## SVG Sprite Icons
- Use: `<svg class="icon icon--sm" aria-hidden="true"><use href="assets/icons/sprite.svg#icon-home"/></svg>`
- JS helper in `assets/js/main.js:8`: `svgIcon(name, cls)` 
- FontAwesome → sprite mapping in `main.js:14-34`: `faToSvg(faClass)` — e.g. `fa-book → icon-book`

## Page conventions
- All pages: `<html lang="fa" dir="rtl">`
- Flex `space-x-reverse` auto-handles RTL
- Color tokens defined in `assets/css/input.css` `@theme`:
  - `--color-primary: #445D84`, `--color-primary-light: #E2D9C6`, `--color-accent: #8B786D`, `--color-cream: #f5f5f0`, `--font-family: 'Vazirmatn', sans-serif`

## Data loading (main.js)
- API URL: `const PUBLIC_API_URL = 'api/public.php'`
- Skeletons: `showSkeletons()` / `hideSkeletons()` — managed in `main.js:115-134`
- Swiper initialized after API data loads
- Course cards expand/collapse with GSAP toggle animation

## Key tables (MySQL)
- `courses`, `course_features`, `instructors`, `instructor_social_links`, `supporters`, `students`, `users`

## Gotchas
- `api/.env` not in repo — copy from provided template
- `assets/css/output.css` is generated — always edit `input.css` first
- `api/admin.php` and dashboard pages not in this repo (separate service)
- `error.log` in project root for PHP errors
// blog.js - Blog module (blog/index.html, blog/category.html, blog/post.html)
import { formatJalaliLong } from './jalali.js';

const PUBLIC_API_URL = '../api/blog.php';
const SPRITE_PATH = '../assets/icons/sprite.svg';
const SITE_URL = 'https://famoacademy.ir';

// The 5 site categories (static nav). Order matters for display.
const BLOG_CATEGORIES = [
    { name: 'کنکور', icon: 'icon-school' },
    { name: 'تیزهوشان', icon: 'icon-star' },
    { name: 'مشاوره تحصیلی', icon: 'icon-help-circle' },
    { name: 'روش مطالعه', icon: 'icon-book' },
    { name: 'اخبار فامو', icon: 'icon-clipboard' },
];

// ---------- Helpers ----------
function svgIcon(name, cls = '') {
    const c = cls ? ` ${cls}` : '';
    return `<svg class="icon${c}" aria-hidden="true"><use href="${SPRITE_PATH}#${name}"/></svg>`;
}

function categoryIcon(name) {
    const cat = BLOG_CATEGORIES.find(c => c.name === name);
    return cat ? cat.icon : 'icon-file';
}

function faNum(value) {
    return Number(value || 0).toLocaleString('fa-IR');
}

function formatPostDate(dateStr) {
    if (!dateStr) return '-';
    const dateOnly = dateStr.split(' ')[0];
    return formatJalaliLong(dateOnly);
}

function getParam(name) {
    return new URLSearchParams(window.location.search).get(name);
}

function catPath(category) {
    return `category.html?category=${encodeURIComponent(category)}`;
}

function postPath(slug) {
    return `post.html?slug=${encodeURIComponent(slug)}`;
}

function showSkeletons() {
    document.querySelectorAll('.blog-skeleton').forEach(el => el.classList.remove('hidden'));
}

function hideSkeletons() {
    document.querySelectorAll('.blog-skeleton').forEach(el => el.classList.add('hidden'));
}

// ---------- Rendering ----------
function renderPostCard(post) {
    const cover = post.cover_image
        ? `<img src="${post.cover_image}" alt="${post.title} | آموزشگاه فامو"
                class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">`
        : `<div class="absolute inset-0 gradient-bg flex items-center justify-center">
               ${svgIcon(categoryIcon(post.category), 'icon--3xl text-white/70')}
           </div>`;

    return `
        <article class="bg-white rounded-2xl overflow-hidden shadow-lg border border-[#E2D9C6] hover-lift transition-all duration-300 hover:shadow-2xl group">
            <a href="${postPath(post.slug)}" class="block">
                <div class="relative h-44 overflow-hidden">
                    ${cover}
                    <a href="${catPath(post.category)}"
                        class="absolute top-3 right-3 bg-white/95 text-[#445D84] text-xs font-bold px-3 py-1 rounded-full shadow-md hover:bg-[#E2D9C6] transition">
                        ${post.category}
                    </a>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-4 text-xs text-gray-500 mb-3">
                        <span class="flex items-center gap-1">
                            ${svgIcon('icon-calendar', 'icon--sm')} ${formatPostDate(post.published_at)}
                        </span>
                        <span class="flex items-center gap-1">
                            ${svgIcon('icon-eye', 'icon--sm')} ${faNum(post.views)} بازدید
                        </span>
                    </div>
                    <h3 class="text-lg font-bold text-[#445D84] mb-2 leading-snug">${post.title}</h3>
                    <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">${post.excerpt || ''}</p>
                    <span class="inline-flex items-center gap-1 mt-4 text-[#445D84] font-bold text-sm">
                        ادامه مطلب ${svgIcon('icon-chevron-left', 'icon--sm')}
                    </span>
                </div>
            </a>
        </article>
    `;
}

function renderPagination(pagination, baseUrl) {
    const el = document.getElementById('pagination');
    if (!el) return;

    const { page, total_pages } = pagination;
    if (total_pages <= 1) {
        el.innerHTML = '';
        return;
    }

    const toUrl = (p) => baseUrl + (baseUrl.includes('?') ? '&' : '?') + `page=${p}`;
    const prev = page > 1
        ? `<a href="${toUrl(page - 1)}" class="flex items-center gap-1 bg-white border border-[#E2D9C6] text-[#445D84] px-4 py-2 rounded-full text-sm font-bold hover:bg-[#E2D9C6] transition">
               ${svgIcon('icon-chevron-right', 'icon--sm')} قبلی
           </a>`
        : `<span class="flex items-center gap-1 bg-gray-100 text-gray-400 px-4 py-2 rounded-full text-sm font-bold cursor-not-allowed">
               ${svgIcon('icon-chevron-right', 'icon--sm')} قبلی
           </span>`;

    const next = page < total_pages
        ? `<a href="${toUrl(page + 1)}" class="flex items-center gap-1 bg-white border border-[#E2D9C6] text-[#445D84] px-4 py-2 rounded-full text-sm font-bold hover:bg-[#E2D9C6] transition">
               بعدی ${svgIcon('icon-chevron-left', 'icon--sm')}
           </a>`
        : `<span class="flex items-center gap-1 bg-gray-100 text-gray-400 px-4 py-2 rounded-full text-sm font-bold cursor-not-allowed">
               بعدی ${svgIcon('icon-chevron-left', 'icon--sm')}
           </span>`;

    el.innerHTML = `
        <div class="flex items-center justify-center gap-4">
            ${prev}
            <span class="text-sm font-bold text-[#445D84]">صفحه ${faNum(page)} از ${faNum(total_pages)}</span>
            ${next}
        </div>
    `;
}

function renderCategoryBadges(activeCategory = null) {
    const holder = document.getElementById('categoryFilters');
    if (!holder) return;

    const all = activeCategory
        ? `<a href="index.html" class="px-4 py-2 rounded-full text-sm font-bold border transition bg-white text-gray-600 border-[#E2D9C6] hover:bg-[#E2D9C6]">همه</a>`
        : `<a href="index.html" class="px-4 py-2 rounded-full text-sm font-bold border transition bg-[#445D84] text-white border-[#445D84]">همه</a>`;

    const items = BLOG_CATEGORIES.map(cat => {
        const active = cat.name === activeCategory;
        return `<a href="${catPath(cat.name)}"
            class="px-4 py-2 rounded-full text-sm font-bold border transition ${active ? 'bg-[#445D84] text-white border-[#445D84]' : 'bg-white text-gray-600 border-[#E2D9C6] hover:bg-[#E2D9C6]'}">
            ${cat.name}</a>`;
    }).join('');

    holder.innerHTML = all + items;
}

// ---------- Loaders ----------
async function loadPostList(action, params, baseUrl) {
    const container = document.getElementById('postsContainer');
    if (!container) return;

    showSkeletons();
    try {
        const query = new URLSearchParams({ action, ...params }).toString();
        const response = await fetch(`${PUBLIC_API_URL}?${query}`);
        const result = await response.json();
        hideSkeletons();

        if (!result.success || !result.data) {
            container.innerHTML = '<p class="col-span-full text-center text-gray-500 py-12">خطا در بارگذاری پست‌ها</p>';
            return;
        }

        if (result.data.length === 0) {
            container.innerHTML = '<p class="col-span-full text-center text-gray-500 py-12">در حال حاضر پستی در این دسته منتشر نشده است.</p>';
            renderPagination({ page: 1, total_pages: 1 }, baseUrl);
            return;
        }

        container.innerHTML = result.data.map(renderPostCard).join('');
        renderPagination(result.pagination, baseUrl);
        container.classList.add('posts-loaded');
    } catch (error) {
        console.error('Error loading posts:', error);
        hideSkeletons();
        container.innerHTML = '<p class="col-span-full text-center text-gray-500 py-12">خطا در بارگذاری پست‌ها</p>';
    }
}

function initBlogIndex() {
    const page = Math.max(1, parseInt(getParam('page') || '1', 10));
    renderCategoryBadges(null);
    loadPostList('get_posts', { page }, 'index.html');
}

function initBlogCategory() {
    const category = getParam('category') || '';

    // Update page title + description for the active category
    const catTitle = document.getElementById('categoryTitle');
    if (catTitle) catTitle.textContent = category || 'دسته‌بندی';
    document.title = `${category || 'دسته‌بندی'} | وبلاگ آموزشی فامو`;

    renderCategoryBadges(category);

    if (!category) {
        const container = document.getElementById('postsContainer');
        if (container) container.innerHTML = '<p class="col-span-full text-center text-gray-500 py-12">دسته‌بندی نامعتبر است.</p>';
        return;
    }

    const page = Math.max(1, parseInt(getParam('page') || '1', 10));
    loadPostList('get_posts_by_category', { category, page }, catPath(category));
}

function initBlogPost() {
    const slug = getParam('slug');
    const container = document.getElementById('postContainer');
    if (!container) return;

    showSkeletons();

    if (!slug) {
        hideSkeletons();
        container.innerHTML = '<p class="text-center text-gray-500 py-12">مدخل پست نامعتبر است.</p>';
        return;
    }

    fetch(`${PUBLIC_API_URL}?action=get_post&slug=${encodeURIComponent(slug)}`)
        .then(res => res.json())
        .then(result => {
            hideSkeletons();

            if (!result.success || !result.data) {
                container.innerHTML = `
                    <div class="text-center py-16">
                        <p class="text-6xl mb-4 font-bold text-[#E2D9C6]">۴۰۴</p>
                        <h1 class="text-2xl font-bold text-[#445D84] mb-3">پست یافت نشد</h1>
                        <p class="text-gray-600 mb-6">ممکن است این پست منتشر نشده یا آدرس آن تغییر کرده باشد.</p>
                        <a href="index.html" class="inline-flex items-center gap-2 bg-[#445D84] text-white px-6 py-3 rounded-full font-bold hover:bg-[#344868] transition">
                            ${svgIcon('icon-arrow-right', 'icon--sm')} بازگشت به وبلاگ
                        </a>
                    </div>`;
                return;
            }

            renderPost(result.data);
        })
        .catch(err => {
            console.error('Error loading post:', err);
            hideSkeletons();
            container.innerHTML = '<p class="text-center text-gray-500 py-12">خطا در بارگذاری پست</p>';
        });
}

function renderPost(post) {
    const container = document.getElementById('postContainer');
    const cover = post.cover_image
        ? `<img src="${post.cover_image}" alt="${post.title}" class="w-full h-56 sm:h-80 object-cover rounded-2xl shadow-lg border border-[#E2D9C6]">
           <span class="absolute top-4 right-4 bg-white/95 text-[#445D84] text-sm font-bold px-4 py-1.5 rounded-full shadow-md">${post.category}</span>`
        : `<div class="w-full h-56 sm:h-80 gradient-bg rounded-2xl shadow-lg flex items-center justify-center">
               ${svgIcon(categoryIcon(post.category), 'icon--3xl text-white/70')}
           </div>`;

    container.innerHTML = `
        <nav class="text-sm text-gray-500 mb-6 flex flex-wrap items-center gap-2">
            <a href="../index.html" class="hover:text-[#445D84] transition flex items-center gap-1">${svgIcon('icon-home', 'icon--sm')} خانه</a>
            <span class="text-[#E2D9C6]">/</span>
            <a href="index.html" class="hover:text-[#445D84] transition">وبلاگ</a>
            <span class="text-[#E2D9C6]">/</span>
            <a href="${catPath(post.category)}" class="hover:text-[#445D84] transition">${post.category}</a>
            <span class="text-[#E2D9C6]">/</span>
            <span class="text-[#8B786D]">${post.title}</span>
        </nav>

        <article class="bg-white rounded-3xl shadow-xl border border-[#E2D9C6] overflow-hidden">
            <div class="relative">
                ${cover}
            </div>
            <div class="p-6 sm:p-10">
                <div class="flex flex-wrap items-center gap-5 text-sm text-gray-500 mb-5">
                    <span class="flex items-center gap-1.5">${svgIcon('icon-calendar', 'icon--sm text-[#445D84]')} ${formatPostDate(post.published_at)}</span>
                    <span class="flex items-center gap-1.5">${svgIcon('icon-eye', 'icon--sm text-[#445D84]')} ${faNum(post.views)} بازدید</span>
                    <a href="${catPath(post.category)}" class="flex items-center gap-1.5 text-[#445D84] font-bold">
                        ${svgIcon('icon-filter', 'icon--sm')} ${post.category}
                    </a>
                </div>

                <h1 class="text-2xl sm:text-3xl font-bold text-[#445D84] mb-6 leading-relaxed">${post.title}</h1>

                <div class="blog-content prose prose-lg max-w-none text-gray-700 leading-loose text-justify"
                     id="postContent"></div>

                <div class="mt-10 pt-6 border-t border-[#E2D9C6] flex items-center justify-between flex-wrap gap-3">
                    <a href="index.html" class="inline-flex items-center gap-2 bg-[#445D84] text-white px-5 py-2.5 rounded-full text-sm font-bold hover:bg-[#344868] transition">
                        ${svgIcon('icon-arrow-right', 'icon--sm')} همه مطالب
                    </a>
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <span>اشتراک‌گذاری:</span>
                        <a href="${SITE_URL}/blog/${postPath(post.slug)}"
                            class="bg-[#E2D9C6] text-[#445D84] w-9 h-9 rounded-full flex items-center justify-center hover:scale-110 transition" aria-label="تلگرام">
                            ${svgIcon('icon-telegram', 'icon--sm')}
                        </a>
                    </div>
                </div>
            </div>
        </article>
    `;

    // content (HTML body from DB)
    const contentEl = document.getElementById('postContent');
    contentEl.innerHTML = post.content || '<p>محتوا به‌زودی تکمیل می‌شود.</p>';

    updatePostSEO(post);
}

function updatePostSEO(post) {
    const title = `${post.title} | وبلاگ آموزشگاه فامو`;
    const desc = post.meta_description || post.excerpt || '';
    const ogImage = post.cover_image || `${SITE_URL}/assets/images/logo.png`;
    const canonical = `${SITE_URL}/blog/${postPath(post.slug)}`;

    document.title = title;

    const setMeta = (selector, attr, value) => {
        const el = document.querySelector(selector);
        if (el) el.setAttribute(attr, value);
    };
    setMeta('meta[name="description"]', 'content', desc);
    setMeta('meta[property="og:title"]', 'content', title);
    setMeta('meta[property="og:description"]', 'content', desc);
    setMeta('meta[property="og:image"]', 'content', ogImage);
    setMeta('meta[property="og:url"]', 'content', canonical);

    // JSON-LD BlogPosting
    const schema = {
        '@context': 'https://schema.org',
        '@type': 'BlogPosting',
        headline: post.title,
        description: desc,
        image: ogImage,
        datePublished: post.published_at,
        author: { '@type': 'Organization', name: 'آموزشگاه فامو' },
        publisher: {
            '@type': 'Organization',
            name: 'آموزشگاه فامو',
            logo: { '@type': 'ImageObject', url: `${SITE_URL}/assets/images/logo.png` },
        },
        mainEntityOfPage: canonical,
    };
    let tag = document.getElementById('blogPostingSchema');
    if (!tag) {
        tag = document.createElement('script');
        tag.type = 'application/ld+json';
        tag.id = 'blogPostingSchema';
        document.head.appendChild(tag);
    }
    tag.textContent = JSON.stringify(schema);
}

// ---------- Init ----------
const pageType = document.body.dataset.page;
if (pageType === 'blog-index') initBlogIndex();
else if (pageType === 'blog-category') initBlogCategory();
else if (pageType === 'blog-post') initBlogPost();
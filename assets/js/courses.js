// Public API URL (this page lives in /pages/, API lives in /api/)
const PUBLIC_API_URL = '../api/public.php';
const SPRITE_PATH = '../assets/icons/sprite.svg';

function svgIcon(name, cls = '') {
    const c = cls ? ` ${cls}` : '';
    return `<svg class="icon${c}" aria-hidden="true"><use href="${SPRITE_PATH}#${name}"/></svg>`;
}

function renderFeature(text) {
    return `
        <div class="flex items-center gap-2">
            ${svgIcon('icon-check', 'icon--sm text-[#445D84]')}
            <span>${text}</span>
        </div>
    `;
}

function renderCourseCard(course) {
    const featuresHtml = (course.features || []).map(renderFeature).join('');
    const featuresBlock = featuresHtml
        ? `<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm font-medium text-gray-700 pt-2">${featuresHtml}</div>`
        : '';

    const priceBlock = course.price
        ? `<div class="text-2xl font-bold text-[#445D84]">${course.price}</div>`
        : '';

    const badgeBlock = course.badge_label
        ? `<span class="bg-[#445D84]/10 text-[#445D84] text-xs font-bold px-3 py-1 rounded-full inline-block">${course.badge_label}</span>`
        : '';

    const bodyText = course.full_description || course.description || '';

    return `
        <article id="course-${course.id}"
            class="bg-white rounded-2xl shadow-xl border border-[#E2D9C6] overflow-hidden p-6 sm:p-8 flex flex-col md:flex-row gap-8 items-center">
            <div class="md:w-2/3 space-y-4">
                ${badgeBlock}
                <h2 class="text-2xl font-bold text-[#445D84]">${course.name}</h2>
                <p class="text-gray-600 leading-relaxed text-justify">${bodyText}</p>
                ${featuresBlock}
            </div>
            <div class="md:w-1/3 bg-[#f9f7f3] p-6 rounded-xl border border-[#E2D9C6] text-center w-full space-y-4">
                ${course.target_grades ? `<div class="text-[#445D84] font-bold text-lg">${course.target_grades}</div>` : ''}
                ${course.format ? `<p class="text-xs text-gray-500">${course.format}</p>` : ''}
                ${priceBlock}
                <a href="http://dashboard.famoacademy.ir/"
                    class="block bg-[#445D84] text-white py-3 rounded-xl font-bold hover:bg-[#344868] transition">مشاوره
                    و ثبت‌نام</a>
            </div>
        </article>
    `;
}

function updateCourseSchema(courses) {
    const schemaTag = document.getElementById('courseSchema');
    if (!schemaTag) return;
    try {
        const schema = JSON.parse(schemaTag.textContent);
        schema.itemListElement = courses.map((course, index) => ({
            '@type': 'ListItem',
            position: index + 1,
            name: course.name
        }));
        schemaTag.textContent = JSON.stringify(schema);
    } catch (e) {
        console.error('Error updating course schema:', e);
    }
}

async function loadCourses() {
    const container = document.getElementById('coursesContainer');
    if (!container) return;

    try {
        const response = await fetch(`${PUBLIC_API_URL}?action=get_courses`);
        const result = await response.json();

        if (!result.success || !result.data) {
            console.error('Error loading courses:', result.error);
            container.innerHTML = '<p class="text-center text-gray-500 py-8">خطا در بارگذاری دوره‌ها</p>';
            return;
        }

        if (result.data.length === 0) {
            container.innerHTML = '<p class="text-center text-gray-500 py-8">در حال حاضر دوره‌ای ثبت نشده است</p>';
            return;
        }

        container.innerHTML = result.data.map(renderCourseCard).join('');
        updateCourseSchema(result.data);
    } catch (error) {
        console.error('Error loading courses:', error);
        container.innerHTML = '<p class="text-center text-gray-500 py-8">خطا در بارگذاری دوره‌ها</p>';
    }
}

document.addEventListener('DOMContentLoaded', loadCourses);

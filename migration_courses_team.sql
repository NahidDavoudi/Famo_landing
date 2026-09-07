-- Active: 1781641511612@@127.0.0.1@3306@famo
-- ============================================================
-- Migration: separate Courses & Team pages
-- Safe to run now since courses / instructors / supporters
-- have no real production data yet.
-- ============================================================

-- ---------- COURSES ----------
-- `description` stays as the short teaser (used on the homepage swiper card).
-- `full_description` is the long explanation shown on the dedicated courses page.
ALTER TABLE courses
ADD COLUMN category VARCHAR(50) NULL AFTER name, -- 'تجربی' | 'ریاضی' | 'تیزهوشان' ...
ADD COLUMN badge_label VARCHAR(100) NULL AFTER category, -- 'دبیرستان و کنکور' | 'متوسطه اول' ...
ADD COLUMN full_description TEXT NULL AFTER description,
ADD COLUMN target_grades VARCHAR(150) NULL AFTER full_description, -- 'دهم، یازدهم، دوازدهم'
ADD COLUMN format VARCHAR(50) NULL AFTER target_grades;
-- 'حضوری' | 'آنلاین' | 'ترکیبی'

-- Bullet-point checklist per course (the little ✓ grid on each card).
-- Normalized instead of a comma-separated column, same call you made for majors.
CREATE TABLE course_features (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    feature_text VARCHAR(255) NOT NULL,
    display_order INT NOT NULL DEFAULT 0,
    FOREIGN KEY (course_id) REFERENCES courses (id) ON DELETE CASCADE
);

-- ---------- INSTRUCTORS ----------
-- `description` stays as the short line used in the homepage modal.
-- `full_bio` is the fuller work-history / intro paragraph for the team page.
ALTER TABLE instructors
ADD COLUMN full_bio TEXT NULL AFTER description;

-- One instructor can have several social links, so this is its own table
-- rather than a few fixed varchar columns (telegram_url, instagram_url, ...).
CREATE TABLE instructor_social_links (
    id INT AUTO_INCREMENT PRIMARY KEY,
    instructor_id INT NOT NULL,
    platform VARCHAR(30) NOT NULL, -- 'telegram' | 'instagram' | 'whatsapp' | 'linkedin' | 'website' | 'aparat' | 'eitaa' ...
    url VARCHAR(255) NOT NULL,
    display_order INT NOT NULL DEFAULT 0,
    FOREIGN KEY (instructor_id) REFERENCES instructors (id) ON DELETE CASCADE
);

-- ============================================================
-- Sample seed data so you can test end-to-end immediately.
-- Replace/delete once you have real content.
-- ============================================================
INSERT INTO
    courses (
        name,
        category,
        badge_label,
        icon,
        gradient_color_from,
        gradient_color_to,
        description,
        full_description,
        target_grades,
        format,
        price,
        display_order
    )
VALUES (
        'دوره جامع آمادگی کنکور علوم تجربی',
        'تجربی',
        'دبیرستان و کنکور',
        'fa-dna',
        '#445D84',
        '#5a779e',
        'زیست، شیمی، ریاضی و فیزیک با متد ترکیبی و مفهومی',
        'دوره تخصصی تجربی فامو شامل تدریس کامل زیست‌شناسی، شیمی، ریاضی و فیزیک با متدهای جدید ترکیبی و مفهومی است. جلسات رفع اشکال ۲۴ ساعته و آزمون‌های هفتگی شبیه‌سازی‌شده کنکور، شما را برای کسب رتبه زیر ۱۰۰۰ آماده می‌کند.',
        'دهم، یازدهم و دوازدهم',
        'حضوری',
        NULL,
        1
    );

SET @course_id = LAST_INSERT_ID();

INSERT INTO
    course_features (
        course_id,
        feature_text,
        display_order
    )
VALUES (
        @course_id,
        'مشاوره اختصاصی پزشکی و دندانپزشکی',
        1
    ),
    (
        @course_id,
        'تحلیل آزمون‌های قلم‌چی و ماز',
        2
    ),
    (
        @course_id,
        'رفع اشکال سریع توسط رتبه‌های برتر',
        3
    ),
    (
        @course_id,
        'بانک تست اختصاصی و جزوات ترکیبی',
        4
    );

INSERT INTO
    instructors (
        name,
        title,
        description,
        full_bio,
        initial_letter,
        display_order
    )
VALUES (
        'دکتر محمد موسوی',
        'مشاور تخصصی تحصیلی و کنکور',
        'مدیریت برنامه تحصیلی و هدایت تحصیلی داوطلبان کنکور',
        'مدیریت برنامه تحصیلی، ارائه استراتژی‌های آزمون‌دهی و هدایت تحصیلی داوطلبان کنکور تجربی و ریاضی در بابل. بیش از ده سال سابقه مشاوره تحصیلی و همراهی صدها داوطلب کنکور.',
        'م',
        1
    );

SET @instructor_id = LAST_INSERT_ID();

INSERT INTO
    instructor_social_links (
        instructor_id,
        platform,
        url,
        display_order
    )
VALUES (
        @instructor_id,
        'telegram',
        'https://t.me/example',
        1
    ),
    (
        @instructor_id,
        'instagram',
        'https://instagram.com/example',
        2
    );
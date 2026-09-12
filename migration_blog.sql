-- ============================================================
-- Migration: Blog module (subdirectory /blog/)
-- Safe to run - blog has no production data yet.
-- ============================================================

-- ---------- BLOG POSTS ----------
CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,           -- 'post.html?slug=...' clean, readable slug
    category VARCHAR(50) NOT NULL,               -- 'کنکور' | 'تیزهوشان' | 'مشاوره تحصیلی' | 'روش مطالعه' | 'اخبار فامو'
    excerpt VARCHAR(500) NULL,                    -- short teaser shown on cards
    content MEDIUMTEXT NULL,                      -- full article body (HTML)
    cover_image VARCHAR(255) NULL,                -- path to cover image (uploads/blog/...)
    meta_description VARCHAR(300) NULL,           -- SEO meta description for the post
    published_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    views INT NOT NULL DEFAULT 0,
    is_published TINYINT(1) NOT NULL DEFAULT 1,   -- 0 = draft, 1 = live
    INDEX idx_blog_category (category),
    INDEX idx_blog_published (is_published, published_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
-- ============================================================
-- Migration: Blog Categories (separate table with FK)
-- Run after migration_blog.sql
-- ============================================================

-- ---------- BLOG CATEGORIES ----------
CREATE TABLE IF NOT EXISTS blog_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description VARCHAR(500) NULL,
    icon VARCHAR(50) NULL,           -- e.g., 'icon-school', 'icon-star'
    color VARCHAR(20) NULL,          -- hex color for badge, e.g., '#445D84'
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default categories (matching the hardcoded ones in blog.js)
INSERT INTO blog_categories (name, slug, description, icon, color, sort_order) VALUES
('کنکور', 'konkoor', 'مقالات و راهنماهای کنکور', 'icon-school', '#445D84', 1),
('تیزهوشان', 'tizhoshan', 'مقالات و راهنماهای آزمون تیزهوشان', 'icon-star', '#8B786D', 2),
('مشاوره تحصیلی', 'moshavere-tahsili', 'مشاوره و راهنمایی تحصیلی', 'icon-help-circle', '#E2D9C6', 3),
('روش مطالعه', 'roosh-motale', 'تکنیک‌ها و روش‌های مطالعه موثر', 'icon-book', '#445D84', 4),
('اخبار فامو', 'famo-news', 'اخبار و اطلاعیه‌های آموزشگاه فامو', 'icon-clipboard', '#8B786D', 5)
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- ---------- ADD category_id TO BLOG_POSTS ----------
ALTER TABLE blog_posts
    ADD COLUMN category_id INT NULL AFTER slug,
    ADD INDEX idx_blog_category_id (category_id);

-- Migrate existing data: set category_id based on category name
UPDATE blog_posts bp
JOIN blog_categories bc ON bp.category = bc.name
SET bp.category_id = bc.id
WHERE bp.category_id IS NULL;

-- Add foreign key constraint (after data migration)
ALTER TABLE blog_posts
    ADD CONSTRAINT fk_blog_posts_category
    FOREIGN KEY (category_id) REFERENCES blog_categories(id)
    ON DELETE SET NULL ON UPDATE CASCADE;

-- Optional: Keep category column for backward compatibility during transition
-- Can be dropped later after confirming everything works
-- ALTER TABLE blog_posts DROP COLUMN category;
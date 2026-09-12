<?php
/**
 * Blog API - Famo Academy Website
 * API عمومی برای دریافت پست‌های وبلاگ
 * بدون نیاز به authentication
 */

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/config.php';

$pdo = getDB();

// ===================== Helper Functions =====================
function blogJSONResponse($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

// ===================== Router =====================
$action = $_GET['action'] ?? '';

switch ($action) {

    // ==================== Get Posts (paged list) ====================
    case 'get_posts':
        try {
            $page = max(1, intval($_GET['page'] ?? 1));
            $perPage = min(12, max(1, intval($_GET['per_page'] ?? 6)));
            $offset = ($page - 1) * $perPage;

            $total = (int)$pdo->query(
                "SELECT COUNT(*) FROM blog_posts WHERE is_published = 1"
            )->fetchColumn();

            $stmt = $pdo->prepare("
                SELECT id, title, slug, category, excerpt, cover_image, published_at, views
                FROM blog_posts
                WHERE is_published = 1
                ORDER BY published_at DESC, id DESC
                LIMIT :limit OFFSET :offset
            ");
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $posts = $stmt->fetchAll();

            blogJSONResponse([
                'success' => true,
                'data' => $posts,
                'pagination' => [
                    'page' => $page,
                    'per_page' => $perPage,
                    'total' => $total,
                    'total_pages' => (int)ceil($total / $perPage),
                ],
            ]);
        } catch (Exception $e) {
            error_log("Error in get_posts: " . $e->getMessage());
            blogJSONResponse(['success' => false, 'error' => 'خطا در دریافت پست‌ها'], 500);
        }
        break;

    // ==================== Get Posts By Category ====================
    case 'get_posts_by_category':
        try {
            $category = trim($_GET['category'] ?? '');
            if ($category === '') {
                blogJSONResponse(['success' => false, 'error' => 'دسته‌بندی نامعتبر است'], 400);
            }

            $page = max(1, intval($_GET['page'] ?? 1));
            $perPage = min(12, max(1, intval($_GET['per_page'] ?? 9)));
            $offset = ($page - 1) * $perPage;

            $countStmt = $pdo->prepare(
                "SELECT COUNT(*) FROM blog_posts WHERE is_published = 1 AND category = ?"
            );
            $countStmt->execute([$category]);
            $total = (int)$countStmt->fetchColumn();

            $stmt = $pdo->prepare("
                SELECT id, title, slug, category, excerpt, cover_image, published_at, views
                FROM blog_posts
                WHERE is_published = 1 AND category = ?
                ORDER BY published_at DESC, id DESC
                LIMIT :limit OFFSET :offset
            ");
            $stmt->bindValue(1, $category, PDO::PARAM_STR);
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $posts = $stmt->fetchAll();

            blogJSONResponse([
                'success' => true,
                'data' => $posts,
                'category' => $category,
                'pagination' => [
                    'page' => $page,
                    'per_page' => $perPage,
                    'total' => $total,
                    'total_pages' => (int)ceil($total / $perPage),
                ],
            ]);
        } catch (Exception $e) {
            error_log("Error in get_posts_by_category: " . $e->getMessage());
            blogJSONResponse(['success' => false, 'error' => 'خطا در دریافت پست‌ها'], 500);
        }
        break;

    // ==================== Get Single Post (by slug) ====================
    case 'get_post':
        try {
            $slug = trim($_GET['slug'] ?? '');
            if ($slug === '') {
                blogJSONResponse(['success' => false, 'error' => 'slug نامعتبر است'], 400);
            }

            $stmt = $pdo->prepare("
                SELECT id, title, slug, category, excerpt, content, cover_image,
                       meta_description, published_at, views
                FROM blog_posts
                WHERE slug = ? AND is_published = 1
                LIMIT 1
            ");
            $stmt->execute([$slug]);
            $post = $stmt->fetch();

            if (!$post) {
                blogJSONResponse(['success' => false, 'error' => 'پست مورد نظر یافت نشد'], 404);
            }

            // Increment view counter
            $pdo->prepare("UPDATE blog_posts SET views = views + 1 WHERE id = ?")
                ->execute([$post['id']]);
            $post['views']++;

            blogJSONResponse(['success' => true, 'data' => $post]);
        } catch (Exception $e) {
            error_log("Error in get_post: " . $e->getMessage());
            blogJSONResponse(['success' => false, 'error' => 'خطا در دریافت پست'], 500);
        }
        break;

    // ==================== Get Categories (with post counts) ====================
    case 'get_categories':
        try {
            $categories = $pdo->query("
                SELECT category AS name, COUNT(*) AS count
                FROM blog_posts
                WHERE is_published = 1
                GROUP BY category
                ORDER BY count DESC, category ASC
            ")->fetchAll();

            blogJSONResponse(['success' => true, 'data' => $categories]);
        } catch (Exception $e) {
            error_log("Error in get_categories: " . $e->getMessage());
            blogJSONResponse(['success' => false, 'error' => 'خطا در دریافت دسته‌بندی‌ها'], 500);
        }
        break;

    default:
        blogJSONResponse(['success' => false, 'error' => 'Action not found'], 404);
        break;
}
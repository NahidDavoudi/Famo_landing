<?php
/**
 * Public API - Famo Academy Website
 * API عمومی برای دریافت اطلاعات دوره‌ها، اساتید و پشتیبان‌ها
 * بدون نیاز به authentication
 */

header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/config.php';

$pdo = getDB();

// ===================== Helper Functions =====================
function jsonResponse($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

// Groups child rows (features / social links) by their parent's id,
// so we do 2 queries total instead of N+1.
function groupByParent(array $rows, string $parentKeyName): array {
    $grouped = [];
    foreach ($rows as $row) {
        $grouped[$row[$parentKeyName]][] = $row;
    }
    return $grouped;
}

// ===================== Router =====================
$action = $_GET['action'] ?? '';

switch ($action) {

    // ==================== Get Courses ====================
    case 'get_courses':
        try {
            $courses = $pdo->query("
                SELECT id, name, category, badge_label, icon, gradient_color_from, gradient_color_to,
                       background_image_url, description, full_description, target_grades, format,
                       price, display_order
                FROM courses
                ORDER BY display_order ASC, id ASC
            ")->fetchAll();

            $features = $pdo->query("
                SELECT course_id, feature_text
                FROM course_features
                ORDER BY course_id ASC, display_order ASC, id ASC
            ")->fetchAll();
            $featuresByCourse = groupByParent($features, 'course_id');

            foreach ($courses as &$course) {
                $course['features'] = array_map(
                    fn($f) => $f['feature_text'],
                    $featuresByCourse[$course['id']] ?? []
                );
            }
            unset($course);

            jsonResponse(['success' => true, 'data' => $courses]);
        } catch (Exception $e) {
            error_log("Error in get_courses: " . $e->getMessage());
            jsonResponse(['success' => false, 'error' => 'خطا در دریافت دوره‌ها'], 500);
        }
        break;

    // ==================== Get Instructors ====================
    case 'get_instructors':
        try {
            $instructors = $pdo->query("
                SELECT id, name, title, description, full_bio, image_url, initial_letter, display_order
                FROM instructors
                ORDER BY display_order ASC, id ASC
            ")->fetchAll();

            $links = $pdo->query("
                SELECT instructor_id, platform, url
                FROM instructor_social_links
                ORDER BY instructor_id ASC, display_order ASC, id ASC
            ")->fetchAll();
            $linksByInstructor = groupByParent($links, 'instructor_id');

            foreach ($instructors as &$instructor) {
                $instructor['social_links'] = $linksByInstructor[$instructor['id']] ?? [];
            }
            unset($instructor);

            jsonResponse(['success' => true, 'data' => $instructors]);
        } catch (Exception $e) {
            error_log("Error in get_instructors: " . $e->getMessage());
            jsonResponse(['success' => false, 'error' => 'خطا در دریافت اساتید'], 500);
        }
        break;

    // ==================== Get Supporters ====================
    case 'get_supporters':
        try {
            $stmt = $pdo->query("
                SELECT id, name, grade, field, chat_id
                FROM supporters
                ORDER BY grade ASC, field ASC, name ASC
            ");
            $supporters = $stmt->fetchAll();
            jsonResponse(['success' => true, 'data' => $supporters]);
        } catch (Exception $e) {
            error_log("Error in get_supporters: " . $e->getMessage());
            jsonResponse(['success' => false, 'error' => 'خطا در دریافت پشتیبان‌ها'], 500);
        }
        break;

    default:
        jsonResponse(['success' => false, 'error' => 'Action not found'], 404);
        break;
}

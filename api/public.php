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

// ===================== Router =====================
$action = $_GET['action'] ?? '';

switch ($action) {
    
    // ==================== Get Courses ====================
    case 'get_courses':
        try {
            $stmt = $pdo->query("
                SELECT id, name, icon, gradient_color_from, gradient_color_to, 
                       background_image_url, description, price, display_order
                FROM courses 
                ORDER BY display_order ASC, id ASC
            ");
            $courses = $stmt->fetchAll();
            jsonResponse(['success' => true, 'data' => $courses]);
        } catch (Exception $e) {
            error_log("Error in get_courses: " . $e->getMessage());
            jsonResponse(['success' => false, 'error' => 'خطا در دریافت دوره‌ها'], 500);
        }
        break;
    
    // ==================== Get Instructors ====================
    case 'get_instructors':
        try {
            $stmt = $pdo->query("
                SELECT id, name, title, description, image_url, initial_letter, display_order
                FROM instructors 
                ORDER BY display_order ASC, id ASC
            ");
            $instructors = $stmt->fetchAll();
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


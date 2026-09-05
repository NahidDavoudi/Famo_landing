<?php
/**
 * Auth Handler - Famo Academy
 * سیستم ورود و ثبت‌نام با رمز عبور (بدون تایید تلگرام)
 */

session_start();
header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . '/config.php';

$action = $_POST['action'] ?? '';

try {
    $pdo = getDB();
    
    switch ($action) {

        // ===== ثبت‌نام =====
        case 'register':
            $name = trim($_POST['full_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $password = $_POST['password'] ?? '';
            $grade = intval($_POST['grade'] ?? 0);
            $field = trim($_POST['field'] ?? '');

            // اعتبارسنجی
            if (empty($name) || strlen($name) < 3) {
                echo json_encode(['status' => 'error', 'message' => 'نام باید حداقل ۳ کاراکتر باشد']);
                exit;
            }
            
            if (!preg_match('/^09\d{9}$/', $phone)) {
                echo json_encode(['status' => 'error', 'message' => 'شماره موبایل نامعتبر است']);
                exit;
            }
            
            if (strlen($password) < 4) {
                echo json_encode(['status' => 'error', 'message' => 'رمز عبور باید حداقل ۴ کاراکتر باشد']);
                exit;
            }
            
            if ($grade < 7 || $grade > 12) {
                echo json_encode(['status' => 'error', 'message' => 'پایه تحصیلی نامعتبر است']);
                exit;
            }
            
            // برای پایه 7-9 رشته اختیاریه
            if ($grade >= 10 && !in_array($field, ['ریاضی', 'تجربی', 'انسانی'])) {
                echo json_encode(['status' => 'error', 'message' => 'رشته تحصیلی نامعتبر است']);
                exit;
            }
            if ($grade <= 9) {
                $field = 'راهنمایی';
            }
            
            // چک تکراری نبودن شماره
            $stmt = $pdo->prepare("SELECT id FROM students WHERE phone = ? LIMIT 1");
            $stmt->execute([$phone]);
            if ($stmt->fetch()) {
                echo json_encode(['status' => 'error', 'message' => 'این شماره قبلاً ثبت‌نام کرده است']);
                exit;
            }
            
            // ثبت در دیتابیس
            $pdo->beginTransaction();
            try {
                // ۱. ثبت در students
                $stmt = $pdo->prepare("
                    INSERT INTO students (name, grade, field, phone, created_at)
                    VALUES (?, ?, ?, ?, NOW())
                ");
                $stmt->execute([$name, $grade, $field, $phone]);
                $student_id = $pdo->lastInsertId();
                
                // ۲. ثبت در users
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("
                    INSERT INTO users (username, password_hash, role, linked_id, created_at)
                    VALUES (?, ?, 'student', ?, NOW())
                ");
                $stmt->execute([$phone, $password_hash, $student_id]);
                
                $pdo->commit();
                
                // ورود خودکار
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user_id'] = $student_id;
                $_SESSION['user_role'] = 'student';
                $_SESSION['user_phone'] = $phone;
                $_SESSION['user_name'] = $name;

                echo json_encode([
                    'status' => 'success',
                    'title' => 'ثبت‌نام موفق',
                    'message' => 'حساب شما ایجاد شد',
                    'redirect' => 'dashboard.html'
                ]);
                
            } catch (Exception $e) {
                $pdo->rollBack();
                throw $e;
            }
            break;

        // ===== ورود =====
        case 'login':
            $phone = trim($_POST['phone'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!preg_match('/^09\d{9}$/', $phone)) {
                echo json_encode(['status' => 'error', 'message' => 'شماره موبایل نامعتبر است']);
                exit;
            }
            
            if (empty($password)) {
                echo json_encode(['status' => 'error', 'message' => 'رمز عبور را وارد کنید']);
                exit;
            }
            
            // پیدا کردن کاربر
            $stmt = $pdo->prepare("
                SELECT u.*, s.name, s.id as student_id 
                FROM users u 
                JOIN students s ON u.linked_id = s.id 
                WHERE u.username = ? AND u.role = 'student'
                LIMIT 1
            ");
            $stmt->execute([$phone]);
            $user = $stmt->fetch();
            
            if (!$user) {
                echo json_encode(['status' => 'error', 'message' => 'کاربری با این شماره یافت نشد']);
                exit;
            }
            
            if (!password_verify($password, $user['password_hash'])) {
                echo json_encode(['status' => 'error', 'message' => 'رمز عبور اشتباه است']);
                exit;
            }
            
            // ورود موفق
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['student_id'];
            $_SESSION['user_role'] = 'student';
            $_SESSION['user_phone'] = $phone;
            $_SESSION['user_name'] = $user['name'];
            
            // آپدیت last_login
            $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?")->execute([$user['id']]);
            
            echo json_encode([
                'status' => 'success',
                'title' => 'ورود موفق',
                'message' => 'خوش آمدید ' . $user['name'],
                'redirect' => 'dashboard.html'
            ]);
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'درخواست نامعتبر']);
            break;
    }
    
} catch (PDOException $e) {
    error_log("Auth Error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'خطا در ارتباط با سرور']);
} catch (Exception $e) {
    error_log("Auth Error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'خطایی رخ داد']);
}
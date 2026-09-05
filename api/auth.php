<?php
/**
 * Auth Handler - Famo Academy
 * سیستم ورود و ثبت‌نام با رمز عبور
 */

session_start();
header("Content-Type: application/json; charset=utf-8");

require_once __DIR__ . '/config.php';

$action = $_POST['action'] ?? '';

// تنظیمات ربات تلگرام (برای ارسال کد تایید)
define('BOT_TOKEN', '8526217633:AAHiAl1KjjHsAyFGx1vad2Seoc1Ip4UnBHw');
define('TELEGRAM_API', 'https://api.telegram.org/bot' . BOT_TOKEN . '/');

function sendTelegramMessage($chat_id, $text) {
    $data = [
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => 'HTML'
    ];
    $ch = curl_init(TELEGRAM_API . 'sendMessage');
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10
    ]);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}

try {
    $pdo = getDB();
    
    switch ($action) {
        
        // ===== چک حساب ربات =====
        case 'check_bot_account':
            $phone = trim($_POST['phone'] ?? '');
            
            if (!preg_match('/^09\d{9}$/', $phone)) {
                echo json_encode(['status' => 'error', 'message' => 'شماره موبایل نامعتبر است']);
                exit;
            }
            
            // چک که آیا این شماره در ربات ثبت شده
            $stmt = $pdo->prepare("SELECT id, name, chat_id FROM students WHERE phone = ? LIMIT 1");
            $stmt->execute([$phone]);
            $student = $stmt->fetch();
            
            if ($student && $student['chat_id']) {
                // حساب ربات وجود داره
                echo json_encode([
                    'status' => 'success',
                    'has_bot_account' => true,
                    'name' => $student['name']
                ]);
            } else {
                echo json_encode([
                    'status' => 'success',
                    'has_bot_account' => false
                ]);
            }
            break;
        
        // ===== ارسال کد تایید به تلگرام =====
        case 'send_verify_code':
            $phone = trim($_POST['phone'] ?? '');
            
            if (!preg_match('/^09\d{9}$/', $phone)) {
                echo json_encode(['status' => 'error', 'message' => 'شماره موبایل نامعتبر است']);
                exit;
            }
            
            // پیدا کردن حساب با chat_id
            $stmt = $pdo->prepare("SELECT id, name, chat_id FROM students WHERE phone = ? AND chat_id IS NOT NULL LIMIT 1");
            $stmt->execute([$phone]);
            $student = $stmt->fetch();
            
            if (!$student) {
                echo json_encode(['status' => 'error', 'message' => 'حسابی با این شماره در ربات یافت نشد']);
                exit;
            }
            
            // تولید کد ۵ رقمی
            $code = rand(10000, 99999);
            
            // ذخیره کد در session
            $_SESSION['verify_code'] = $code;
            $_SESSION['verify_phone'] = $phone;
            $_SESSION['verify_student_id'] = $student['id'];
            $_SESSION['verify_expires'] = time() + 300; // 5 دقیقه
            
            // ارسال به تلگرام
            $message = "🔐 <b>کد تایید سایت آموزشگاه فامو</b>\n\n" .
                       "کد شما: <code>{$code}</code>\n\n" .
                       "⏳ این کد تا ۵ دقیقه معتبر است.";
            
            $result = sendTelegramMessage($student['chat_id'], $message);
            
            if ($result && $result['ok']) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'کد تایید به تلگرام شما ارسال شد'
                ]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'خطا در ارسال کد. لطفاً دوباره تلاش کنید.']);
            }
            break;
        
        // ===== تایید کد و اتصال حساب =====
        case 'verify_code':
            $code = trim($_POST['code'] ?? '');
            $password = $_POST['password'] ?? '';
            
            if (empty($code) || strlen($code) != 5) {
                echo json_encode(['status' => 'error', 'message' => 'کد تایید نامعتبر است']);
                exit;
            }
            
            if (strlen($password) < 4) {
                echo json_encode(['status' => 'error', 'message' => 'رمز عبور باید حداقل ۴ کاراکتر باشد']);
                exit;
            }
            
            // چک کد
            if (!isset($_SESSION['verify_code']) || 
                $_SESSION['verify_code'] != $code || 
                time() > $_SESSION['verify_expires']) {
                echo json_encode(['status' => 'error', 'message' => 'کد نامعتبر یا منقضی شده است']);
                exit;
            }
            
            $phone = $_SESSION['verify_phone'];
            $student_id = $_SESSION['verify_student_id'];
            
            // چک که user وجود نداشته باشه
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? AND role = 'student'");
            $stmt->execute([$phone]);
            if ($stmt->fetch()) {
                // کاربر قبلاً در سایت هم ثبت شده
                unset($_SESSION['verify_code'], $_SESSION['verify_phone'], $_SESSION['verify_student_id'], $_SESSION['verify_expires']);
                echo json_encode(['status' => 'error', 'message' => 'این حساب قبلاً فعال شده. از صفحه ورود استفاده کنید.']);
                exit;
            }
            
            // دریافت اطلاعات دانش‌آموز
            $stmt = $pdo->prepare("SELECT * FROM students WHERE id = ?");
            $stmt->execute([$student_id]);
            $student = $stmt->fetch();
            
            // ایجاد حساب کاربری
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password_hash, role, linked_id, created_at) VALUES (?, ?, 'student', ?, NOW())");
            $stmt->execute([$phone, $password_hash, $student_id]);
            
            // پاک کردن session موقت
            unset($_SESSION['verify_code'], $_SESSION['verify_phone'], $_SESSION['verify_student_id'], $_SESSION['verify_expires']);
            
            // ورود خودکار
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $student_id;
            $_SESSION['user_role'] = 'student';
            $_SESSION['user_phone'] = $phone;
            $_SESSION['user_name'] = $student['name'];
            
            echo json_encode([
                'status' => 'success',
                'title' => 'حساب فعال شد!',
                'message' => 'حساب سایت با ربات تلگرام شما متصل شد',
                'redirect' => 'dashboard.html'
            ]);
            break;
        
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
            $stmt = $pdo->prepare("SELECT id, chat_id FROM students WHERE phone = ? LIMIT 1");
            $stmt->execute([$phone]);
            $existing = $stmt->fetch();
            
            if ($existing) {
                if ($existing['chat_id']) {
                    // این شماره در ربات ثبت شده - باید از طریق کد تایید فعال بشه
                    echo json_encode([
                        'status' => 'error', 
                        'message' => 'این شماره در ربات ثبت شده. از گزینه «قبلاً از ربات ثبت‌نام کرده‌ام» استفاده کنید.',
                        'has_bot_account' => true
                    ]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'این شماره قبلاً ثبت‌نام کرده است']);
                }
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

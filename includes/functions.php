<?php
// includes/functions.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* ===================== أدوات عامة ===================== */

/**
 * دالة لتأمين البيانات قبل عرضها في HTML.
 *
 * @param string|null $str
 * @return string
 */
function esc(string|null $str): string
{
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}

/**
 * صنع URL نسبي للأصول/الروابط (يضيف BASE_URL).
 *
 * @param string $path
 * @return string
 */
function url_for(string $path): string
{
    $path = ltrim($path, '/');
    return rtrim(BASE_URL, '/') . '/' . $path;
}

/**
 * دالة مساعدة لإنشاء مسار الأصل (asset URL).
 *
 * @param string $path
 * @return string
 */
function asset(string $path): string
{
    return url_for($path);
}

/**
 * دالة لإعادة التوجيه (Redirection).
 *
 * @param string $path
 * @param int $status
 * @return never
 */
function redirect(string $path, int $status = 302): never
{
    header('Location: ' . url_for($path), true, $status);
    exit;
}

/**
 * تفعيل active في قائمة التنقل (Navbar).
 *
 * @param string $file
 * @return string
 */
function nav_active(string $file): string
{
    $current = basename(parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '');
    return ($current === $file) ? 'active' : '';
}

/**
 * إرجاع مسار الصورة أو مسار الصورة الافتراضية إذا كانت الصورة غير موجودة.
 * يجب أن يكون BASE_PATH معرفاً في init.php لتعمل هذه الدالة.
 *
 * @param string|null $relativePath
 * @param string $default
 * @return string
 */
if (!function_exists('image_or_default')) {
    /**
     * جلب صورة المستخدم أو صورة افتراضية إن لم توجد.
     *
     * @param string|null $image_path
     * @param string $default_image
     * @return string
     */
    function image_or_default(string|null $image_path, string $default_image = 'images/defaults/default-avatar.png'): string
    {
        if (empty($image_path)) {
            return asset($default_image);
        }
        return asset($image_path);
    }
}

/**
 * دالة لرفع الملفات مع التأكد من النوع والحجم.
 *
 * @param array $file
 * @param string $targetDir
 * @param string $webPath
 * @param array $allowedExt
 * @param int $maxSize
 * @param string $type
 * @return array
 */
function move_upload(array $file, string $targetDir, string $webPath, array $allowedExt, int $maxSize, string $type = 'file'): array
{
    $res = ['success' => false, 'message' => '', 'path' => ''];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $res['message'] = "خطأ في رفع الملف.";
        return $res;
    }
    $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($fileExt, $allowedExt)) {
        $res['message'] = "نوع ملف غير مسموح به. الأنواع المسموح بها: " . implode(', ', $allowedExt);
        return $res;
    }
    if ($file['size'] > $maxSize) {
        $res['message'] = "حجم الملف يتجاوز الحد المسموح به (" . round($maxSize / 1024 / 1024, 2) . "MB).";
        return $res;
    }
    $fileName = uniqid($type . '_', true) . '.' . $fileExt;
    $targetPath = $targetDir . '/' . $fileName;
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        $res['success'] = true;
        $res['path'] = $webPath . '/' . $fileName;
    } else {
        $res['message'] = "فشل نقل الملف.";
    }
    return $res;
}

/**
 * دالة مساعدة لرفع صورة الملف الشخصي.
 *
 * @param array $file
 * @return array
 */
function upload_profile_image(array $file): array
{
    return move_upload(
        $file,
        PROFILES_DIR,
        'uploads/profiles',
        list_to_array(ALLOWED_IMAGE_EXT),
        PROFILE_MAX_SIZE,
        'profile'
    );
}

/**
 * دالة مساعدة لرفع صورة الكورس.
 *
 * @param array $file
 * @return array
 */
/**
 * دالة لرفع صورة الكورس.
 *
 * @param array $file
 * @param int $teacher_id
 * @return array
 */
function upload_course_image(array $file, int $teacher_id): array
{
    return upload_file($file, 'course_images', $teacher_id);
}

/**
 * دالة لرفع فيديو الكورس.
 *
 * @param array $file
 * @param int $teacher_id
 * @return array
 */
function upload_course_video(array $file, int $teacher_id): array
{
    return upload_file($file, 'videos', $teacher_id);
}

/**
 * دالة مساعدة لرفع الملفات إلى مجلدات مخصصة لكل مستخدم/مدرس.
 *
 * @param array $file_info
 * @param string $folder_name
 * @param int $user_id
 * @return array
 */
function upload_file(array $file_info, string $folder_name, int $user_id): array
{
    if ($file_info['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'message' => 'خطأ في الرفع: ' . $file_info['error']];
    }

    $base_dir = UPLOADS_DIR . '/' . $folder_name;
    $user_dir = $base_dir . '/' . $user_id;

    if (!is_dir($user_dir)) {
        if (!mkdir($user_dir, 0755, true)) {
            return ['success' => false, 'message' => 'فشل إنشاء مجلد المستخدم.'];
        }
    }

    $ext = pathinfo($file_info['name'], PATHINFO_EXTENSION);
    $filename = uniqid('upload_', true) . '.' . $ext;
    $destination = $user_dir . '/' . $filename;

    if (move_uploaded_file($file_info['tmp_name'], $destination)) {
        return ['success' => true, 'path' => $folder_name . '/' . $user_id . '/' . $filename];
    } else {
        return ['success' => false, 'message' => 'فشل نقل الملف.'];
    }
}

/**
 * تحويل سلسلة نصية مفصولة بفواصل إلى مصفوفة.
 *
 * @param string|null $str
 * @return array
 */
function list_to_array(?string $str): array
{
    return array_map('trim', explode(',', (string)$str));
}

/* ===================== دوال التحقق من المستخدم ===================== */

/**
 * التحقق مما إذا كان المستخدم مسجلاً دخوله حالياً.
 *
 * @return bool
 */
function is_logged_in(): bool
{
    return isset($_SESSION['user_id']);
}

/**
 * إرجاع بيانات المستخدم المسجل دخوله حالياً.
 *
 * @return array|null
 */
function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

/**
 * إرجاع دور المستخدم المسجل دخوله حالياً (مثال: admin, teacher, student).
 *
 * @return string|null
 */
function current_role(): ?string
{
    $user = current_user();
    return $user['role'] ?? null;
}

/**
 * إرجاع اسم المستخدم المسجل دخوله حالياً.
 *
 * @return string|null
 */
function current_username(): ?string
{
    $user = current_user();
    return $user['username'] ?? null;
}

/**
 * إرجاع جنس المستخدم المسجل دخوله حالياً.
 *
 * @return string|null
 */
function current_gender(): ?string
{
    $user = current_user();
    return $user['gender'] ?? 'male'; // قيمة افتراضية
}

/**
 * إرجاع تحية بناءً على جنس المستخدم.
 *
 * @param string $gender
 * @return string
 */
function salutation(string $gender): string
{
    return ($gender === 'female') ? 'أهلاً بكِ' : 'أهلاً بك';
}

/**
 * إرجاع اسم الدور العربي بناءً على الدور الإنجليزي.
 *
 * @param string $role
 * @return string
 */
function get_role_name(string $role): string
{
    switch ($role) {
        case 'student':
            return 'طالب';
        case 'teacher':
            return 'مدرس';
        case 'admin':
            return 'مدير';
        default:
            return 'مستخدم';
    }
}

/**
 * دالة لتسجيل الدخول.
 *
 * @param PDO $pdo
 * @param string $email
 * @param string $password
 * @return array|null
 */
function login_user(PDO $pdo, string $email, string $password): ?array
{
    try {
        // استعلام لجلب بيانات المستخدم بالبريد الإلكتروني
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // التحقق من كلمة السر
        if ($user && password_verify($password, $user['password'])) {
            // تسجيل الدخول بنجاح
            $_SESSION['user_id'] = $user['id'];

            // إزالة كلمة السر قبل تخزين بيانات المستخدم في السيشن
            unset($user['password']);

            $_SESSION['user'] = $user;
            return $user;
        }
    } catch (PDOException $e) {
        // تسجيل الخطأ في اللوج
        error_log("Login error: " . $e->getMessage());
    }

    // في حالة الفشل
    return null;
}


/**
 * دالة لتسجيل مستخدم جديد.
 *
 * @param PDO $pdo
 * @param string $username
 * @param string $email
 * @param string $password
 * @param string $phone
 * @param string $role
 * @param string $gender
 * @return bool
 */
function register_user(PDO $pdo, string $username, string $email, string $password, string $phone, string $role = 'student', string $gender = 'male'): bool
{
    try {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, phone, role, gender) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$username, $email, $hashed_password, $phone, $role, $gender]);
    } catch (PDOException $e) {
        error_log("Registration error: " . $e->getMessage());
    }
    return false;
}

/**
 * التحقق من وجود مستخدم ببريد إلكتروني معين.
 *
 * @param PDO $pdo
 * @param string $email
 * @return bool
 */
function user_exists(PDO $pdo, string $email): bool
{
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetchColumn() > 0;
}

/**
 * التحويل بناءً على دور المستخدم.
 *
 * @param string $role
 * @return never
 */
function redirect_based_on_role(string $role): never
{
    switch ($role) {
        case 'student':
            redirect('student-dashboard.php');
        case 'teacher':
            redirect('teacher-dashboard.php');
        case 'admin':
            redirect('admin-dashboard.php');
        default:
            redirect('index.php');
    }
}

/**
 * دالة لطباعة المحتويات وتوقف التنفيذ.
 *
 * @param mixed $value
 * @return never
 */
function dd(mixed $value): never
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    die();
}

/**
 * جلب عدد المستخدمين.
 *
 * @return int
 */
function get_users_count(): int
{
    $pdo = db();
    $stmt = $pdo->query('SELECT COUNT(*) FROM users');
    return (int) $stmt->fetchColumn();
}

/**
 * جلب عدد الكورسات.
 *
 * @return int
 */
function get_courses_count(): int
{
    $pdo = db();
    $stmt = $pdo->query('SELECT COUNT(*) FROM courses');
    return (int) $stmt->fetchColumn();
}

/**
 * جلب أحدث المستخدمين.
 *
 * @param int $limit
 * @return array
 */
function get_latest_users(int $limit = 5): array
{
    $pdo = db();
    $stmt = $pdo->prepare('SELECT username, role FROM users ORDER BY created_at DESC LIMIT :limit');
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * جلب أحدث الكورسات.
 *
 * @param int $limit
 * @return array
 */
function get_latest_courses(int $limit = 5): array
{
    $pdo = db();
    $stmt = $pdo->prepare('SELECT name AS title FROM courses ORDER BY created_at DESC LIMIT :limit');
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

/**
 * دالة مساعدة لاختيار مسار الصورة الصحيح أو الافتراضي.
 *
 * @param string|null $path
 * @param string $default_path
 * @return string
 */
function image_or_default(string|null $path, string $default_path = 'images/defaults/placeholder.png'): string
{
    if (empty($path)) {
        return asset($default_path);
    }
    // تأكد من أن المسار هو رابط كامل أو مسار نسبي
    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
        return $path;
    }
    return asset($path);
}
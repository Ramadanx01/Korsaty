<?php
// includes/init.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// اضبط المنطقة الزمنية (اختياري)
date_default_timezone_set('Africa/Cairo');

// مسارات أساسية
define('BASE_PATH', realpath(__DIR__ . '/..')); // مسار المشروع على القرص

// محاولة اكتشاف BASE_URL تلقائياً بناءً على مكان المجلد تحت htdocs
$docRoot = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : null;
$appRoot = realpath(BASE_PATH);
$baseUrl = '/';
if ($docRoot && $appRoot && str_starts_with(str_replace('\\','/',$appRoot), str_replace('\\','/',$docRoot))) {
    $rel = str_replace('\\','/', substr($appRoot, strlen($docRoot)));
    $rel = '/' . ltrim($rel, '/');
    $baseUrl = rtrim($rel, '/');
}
if ($baseUrl === '') { $baseUrl = '/'; }
define('BASE_URL', $baseUrl); // مثال: /korsaty.com

// ثوابت الرفع
define('UPLOADS_DIR', BASE_PATH . '/uploads');
define('PROFILES_DIR', UPLOADS_DIR . '/profiles');
define('COURSE_IMAGES_DIR', UPLOADS_DIR . '/course_images');
define('VIDEOS_DIR', UPLOADS_DIR . '/videos');

// أحجام قصوى (عدّل لو حابب)
define('PROFILE_MAX_SIZE', 2 * 1024 * 1024);     // 2MB
define('COURSE_IMG_MAX_SIZE', 5 * 1024 * 1024);   // 5MB
define('VIDEO_MAX_SIZE', 50 * 1024 * 1024);      // 50MB

// أنواع الملفات المسموح بها
define('ALLOWED_IMAGE_EXT', 'jpg,jpeg,png,gif,webp');
define('ALLOWED_VIDEO_EXT', 'mp4,avi,mov,mkv');

// إعدادات أخرى
define('DEFAULT_PAGE_SIZE', 10);

// تضمين الملفات الأساسية
require_once BASE_PATH . '/includes/db.php';
require_once BASE_PATH . '/includes/functions.php';

?>
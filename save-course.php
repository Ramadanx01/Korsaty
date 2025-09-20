<?php
require_once 'includes/init.php';
require_once 'includes/functions.php';

// ✅ تأكد من تسجيل دخول المدرس
if (!is_logged_in() || current_role() !== 'teacher') {
    redirect('login.php');
}

$user = current_user();
$teacher_id = $user['id'];

// ✅ استلام البيانات
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$price = (float)($_POST['price'] ?? 0);
$youtube_url = trim($_POST['youtube_url'] ?? '');
$course_id = (int)($_POST['course_id'] ?? 0);

// ✅ رفع صورة الكورس
$image_path = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $upload = upload_course_image($_FILES['image'], $teacher_id);
    if ($upload['success']) {
        $image_path = $upload['path'];
    } else {
        die('خطأ في رفع الصورة: ' . $upload['message']);
    }
}

// ✅ رفع فيديو (اختياري)
$video_path = null;
if (isset($_FILES['video']) && $_FILES['video']['error'] === UPLOAD_ERR_OK) {
    $upload = upload_course_video($_FILES['video'], $teacher_id);
    if ($upload['success']) {
        $video_path = $upload['path'];
    } else {
        die('خطأ في رفع الفيديو: ' . $upload['message']);
    }
}

// ✅ إذا كان YouTube مرفوعًا بدل الفيديو
if (!empty($youtube_url)) {
    $video_path = $youtube_url;
}

// ✅ حفظ في قاعدة البيانات
$pdo = db();

if ($course_id > 0) {
    // ✅ تعديل كورس موجود
    $stmt = $pdo->prepare("UPDATE courses SET title = ?, description = ?, price = ?, image_path = ?, video_path = ?, updated_at = NOW() WHERE id = ? AND teacher_id = ?");
    $stmt->execute([$title, $description, $price, $image_path, $video_path, $course_id, $teacher_id]);
} else {
    // ✅ إنشاء كورس جديد
    $stmt = $pdo->prepare("INSERT INTO courses (teacher_id, title, description, price, image_path, video_path, is_published, created_at) VALUES (?, ?, ?, ?, ?, ?, 1, NOW())");
    $stmt->execute([$teacher_id, $title, $description, $price, $image_path, $video_path]);
}

// ✅ إعادة التوجيه
redirect('teacher-dashboard.php');
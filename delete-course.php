<?php
require_once 'includes/init.php';
require_once 'includes/functions.php';

// ✅ تأكد من تسجيل دخول المدرس
if (!is_logged_in() || current_role() !== 'teacher') {
    redirect('login.php');
}

$user = current_user();
$course_id = (int)($_GET['id'] ?? 0);

if ($course_id > 0) {
    $pdo = db();
    // حذف الكورس فقط إذا كان يخص المدرس الحالي
    $stmt = $pdo->prepare("DELETE FROM courses WHERE id = ? AND teacher_id = ?");
    $stmt->execute([$course_id, $user['id']]);
}

redirect('teacher-dashboard.php');
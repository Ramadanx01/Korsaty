<?php
// الاتصال بقاعدة البيانات
require_once '../db.php'; // استخدام الاتصال بـ PDO

// معالجة النموذج عند الإرسال
if (isset($_POST['submit'])) {
    $course_name = trim($_POST['course_name'] ?? '');
    $course_desc = trim($_POST['course_desc'] ?? '');
    $youtube_link = trim($_POST['youtube_link'] ?? '');
    $file_path = '';

    // رفع صورة أو فيديو
    if (isset($_FILES['media']) && $_FILES['media']['error'] == 0) {
        $target_dir = '../uploads/courses/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . '_' . basename($_FILES['media']['name']);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES['media']['tmp_name'], $target_file)) {
            $file_path = $target_file;
        }
    }

    // حفظ بيانات الكورس في قاعدة البيانات باستخدام prepared statements
    $stmt = db()->prepare("INSERT INTO courses (name, description, media_path, youtube_link, created_at) VALUES (?, ?, ?, ?, NOW())");
    if ($stmt->execute([$course_name, $course_desc, $file_path, $youtube_link])) {
        echo '<div style="color:green">تم إضافة الكورس بنجاح!</div>';
    } else {
        echo '<div style="color:red">حدث خطأ أثناء إضافة الكورس.</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إضافة كورس جديد</title>
</head>
<body>
    <h2>إضافة كورس جديد</h2>
    <form method="post" enctype="multipart/form-data">
        <label>اسم الكورس:</label><br>
        <input type="text" name="course_name" required><br><br>
        <label>وصف الكورس:</label><br>
        <textarea name="course_desc" required></textarea><br><br>
        <label>صورة أو فيديو:</label><br>
        <input type="file" name="media" accept="image/*,video/*"><br><br>
        <label>لينك يوتيوب (اختياري):</label><br>
        <input type="text" name="youtube_link"><br><br>
        <button type="submit" name="submit">إضافة الكورس</button>
    </form>
</body>
</html>

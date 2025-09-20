<?php
include '../db_connect.php';
include '../functions.php';

// تحقق من أن المستخدم مدرس
if (current_role() !== 'teacher') {
    redirect('login.php');
}

if (!isset($_GET['course_id'])) {
    die('لم يتم تحديد الكورس.');
}
$course_id = intval($_GET['course_id']);

// معالجة النموذج عند الإرسال
if (isset($_POST['submit'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $youtube_link = mysqli_real_escape_string($conn, $_POST['youtube_link']);
    $media_path = '';

    // رفع ملف (صورة/فيديو)
    if (isset($_FILES['media']) && $_FILES['media']['error'] == 0) {
        $target_dir = '../uploads/lessons/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . '_' . basename($_FILES['media']['name']);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES['media']['tmp_name'], $target_file)) {
            $media_path = $target_file;
        }
    }

    $sql = "INSERT INTO lessons (course_id, title, description, media_path, youtube_link, created_at) VALUES ($course_id, '$title', '$description', '$media_path', '$youtube_link', NOW())";
    if (mysqli_query($conn, $sql)) {
        echo '<div style="color:green">تم إضافة الدرس بنجاح!</div>';
    } else {
        echo '<div style="color:red">حدث خطأ: ' . mysqli_error($conn) . '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إضافة درس جديد</title>
</head>
<body>
    <h2>إضافة درس جديد</h2>
    <form method="post" enctype="multipart/form-data">
        <label>عنوان الدرس:</label><br>
        <input type="text" name="title" required><br><br>
        <label>وصف الدرس:</label><br>
        <textarea name="description" required></textarea><br><br>
        <label>صورة أو فيديو:</label><br>
        <input type="file" name="media" accept="image/*,video/*"><br><br>
        <label>لينك يوتيوب (اختياري):</label><br>
        <input type="text" name="youtube_link"><br><br>
        <button type="submit" name="submit">إضافة الدرس</button>
    </form>
    <br>
    <a href="teacher-lessons.php?course_id=<?php echo $course_id; ?>">العودة لدروس الكورس</a>
</body>
</html>
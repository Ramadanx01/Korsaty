<?php
// الاتصال بقاعدة البيانات
include '../db_connect.php';

// جلب بيانات الكورس
if (!isset($_GET['id'])) {
    die('معرّف الكورس غير موجود.');
}
$id = intval($_GET['id']);
$sql = "SELECT * FROM courses WHERE id = $id";
$result = mysqli_query($conn, $sql);
if (!$result || mysqli_num_rows($result) == 0) {
    die('الكورس غير موجود.');
}
$course = mysqli_fetch_assoc($result);

// تحديث بيانات الكورس
if (isset($_POST['submit'])) {
    $course_name = mysqli_real_escape_string($conn, $_POST['course_name']);
    $course_desc = mysqli_real_escape_string($conn, $_POST['course_desc']);
    $youtube_link = mysqli_real_escape_string($conn, $_POST['youtube_link']);
    $file_path = $course['media_path'];

    // رفع صورة أو فيديو جديد
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

    $update_sql = "UPDATE courses SET name='$course_name', description='$course_desc', media_path='$file_path', youtube_link='$youtube_link' WHERE id=$id";
    if (mysqli_query($conn, $update_sql)) {
        echo '<div style=\'color:green\'>تم تحديث بيانات الكورس بنجاح!</div>';
        // تحديث بيانات الكورس للعرض بعد الحفظ
        $course['name'] = $course_name;
        $course['description'] = $course_desc;
        $course['media_path'] = $file_path;
        $course['youtube_link'] = $youtube_link;
    } else {
        echo '<div style=\'color:red\'>حدث خطأ: ' . mysqli_error($conn) . '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تعديل الكورس</title>
</head>
<body>
    <h2>تعديل الكورس</h2>
    <form method="post" enctype="multipart/form-data">
        <label>اسم الكورس:</label><br>
        <input type="text" name="course_name" value="<?php echo htmlspecialchars($course['name']); ?>" required><br><br>
        <label>وصف الكورس:</label><br>
        <textarea name="course_desc" required><?php echo htmlspecialchars($course['description']); ?></textarea><br><br>
        <label>صورة أو فيديو حالي:</label><br>
        <?php if ($course['media_path']): ?>
            <?php if (preg_match('/\.(mp4|webm|ogg)$/i', $course['media_path'])): ?>
                <video controls src="<?php echo $course['media_path']; ?>" style="max-width:120px;max-height:80px;"></video>
            <?php else: ?>
                <img src="<?php echo $course['media_path']; ?>" alt="صورة الكورس" style="max-width:120px;max-height:80px;">
            <?php endif; ?>
        <?php else: ?>-
        <?php endif; ?><br>
        <label>تغيير صورة أو فيديو:</label><br>
        <input type="file" name="media" accept="image/*,video/*"><br><br>
        <label>لينك يوتيوب (اختياري):</label><br>
        <input type="text" name="youtube_link" value="<?php echo htmlspecialchars($course['youtube_link']); ?>"><br><br>
        <button type="submit" name="submit">حفظ التعديلات</button>
    </form>
    <br>
    <a href="admin-courses.php">العودة لإدارة الكورسات</a>
</body>
</html>

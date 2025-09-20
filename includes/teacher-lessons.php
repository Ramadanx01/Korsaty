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

// جلب الدروس الخاصة بالكورس
$sql = "SELECT * FROM lessons WHERE course_id = $course_id ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>دروس الكورس</title>
    <style>
        table {width: 100%; border-collapse: collapse;}
        th, td {border: 1px solid #ccc; padding: 8px; text-align: center;}
        img, video {max-width: 120px; max-height: 80px;}
        .actions a {margin: 0 5px;}
    </style>
</head>
<body>
    <h2>دروس الكورس</h2>
    <a href="add_lesson.php?course_id=<?php echo $course_id; ?>" style="margin-bottom:15px; display:inline-block;">+ إضافة درس جديد</a>
    <table>
        <tr>
            <th>العنوان</th>
            <th>الوصف</th>
            <th>صورة/فيديو</th>
            <th>لينك يوتيوب</th>
            <th>تاريخ الإضافة</th>
            <th>إجراءات</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['title']); ?></td>
            <td><?php echo htmlspecialchars($row['description']); ?></td>
            <td>
                <?php if ($row['media_path']): ?>
                    <?php if (preg_match('/\.(mp4|webm|ogg)$/i', $row['media_path'])): ?>
                        <video controls src="<?php echo $row['media_path']; ?>"></video>
                    <?php else: ?>
                        <img src="<?php echo $row['media_path']; ?>" alt="صورة الدرس">
                    <?php endif; ?>
                <?php else: ?>-
                <?php endif; ?>
            </td>
            <td>
                <?php if ($row['youtube_link']): ?>
                    <a href="<?php echo htmlspecialchars($row['youtube_link']); ?>" target="_blank">مشاهدة</a>
                <?php else: ?>-
                <?php endif; ?>
            </td>
            <td><?php echo $row['created_at']; ?></td>
            <td class="actions">
                <a href="edit_lesson.php?id=<?php echo $row['id']; ?>&course_id=<?php echo $course_id; ?>">تعديل</a>
                <a href="delete_lesson.php?id=<?php echo $row['id']; ?>&course_id=<?php echo $course_id; ?>" onclick="return confirm('هل أنت متأكد من حذف الدرس؟');">حذف</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="teacher-courses.php">العودة إلى كورساتي</a>
</body>
</html>
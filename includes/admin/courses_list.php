<?php
// الاتصال بقاعدة البيانات
include '../db_connect.php';

// جلب جميع الكورسات
$sql = "SELECT * FROM courses ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>قائمة الكورسات</title>
    <style>
        table {width: 100%; border-collapse: collapse;}
        th, td {border: 1px solid #ccc; padding: 8px; text-align: center;}
        img, video {max-width: 120px; max-height: 80px;}
    </style>
</head>
<body>
    <h2>قائمة الكورسات</h2>
    <table>
        <tr>
            <th>الاسم</th>
            <th>الوصف</th>
            <th>صورة/فيديو</th>
            <th>لينك يوتيوب</th>
            <th>تاريخ الإضافة</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['description']); ?></td>
            <td>
                <?php if ($row['media_path']): ?>
                    <?php if (preg_match('/\.(mp4|webm|ogg)$/i', $row['media_path'])): ?>
                        <video controls src="<?php echo $row['media_path']; ?>"></video>
                    <?php else: ?>
                        <img src="<?php echo $row['media_path']; ?>" alt="صورة الكورس">
                    <?php endif; ?>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>
            <td>
                <?php if ($row['youtube_link']): ?>
                    <a href="<?php echo htmlspecialchars($row['youtube_link']); ?>" target="_blank">مشاهدة</a>
                <?php else: ?>-
                <?php endif; ?>
            </td>
            <td><?php echo $row['created_at']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>

<?php
// الاتصال بقاعدة البيانات
include '../db_connect.php';

if (!isset($_GET['id'])) {
    die('معرّف الكورس غير موجود.');
}
$id = intval($_GET['id']);

// حذف الكورس
$sql = "DELETE FROM courses WHERE id = $id";
if (mysqli_query($conn, $sql)) {
    header('Location: admin-courses.php');
    exit;
} else {
    echo 'حدث خطأ أثناء الحذف: ' . mysqli_error($conn);
}
?>

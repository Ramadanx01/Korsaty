<?php
require_once 'includes/init.php';
require_once 'includes/functions.php';

$course_id = (int)($_GET['course_id'] ?? 0);
$student_id = (int)($_GET['student_id'] ?? 0);

$pdo = db();
$stmt = $pdo->prepare("SELECT c.title, u.username FROM courses c JOIN users u ON u.id = ? WHERE c.id = ?");
$stmt->execute([$student_id, $course_id]);
$data = $stmt->fetch();
if (!$data) die('❌ بيانات غير صحيحة');
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <title>شهادة إتمام</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: url('images/certificate-bg.jpg') center/cover; height: 100vh; display: flex; align-items: center; justify-content: center; color: #333; }
        .certificate { background: #fff; padding: 40px; border-radius: 15px; box-shadow: 0 0 30px rgba(0,0,0,.2); text-align: center; max-width: 600px; }
        .certificate h1 { color: #0d6efd; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="certificate">
        <h1>شهادة إتمام</h1>
        <p>يُمنح هذه الشهادة للطالب</p>
        <h2><?= esc($data['username']) ?></h2>
        <p>لإكماله بنجاح كورس</p>
        <h3>«<?= esc($data['title']) ?>»</h3>
        <p>بتاريخ: <?= date('Y/m/d') ?></p>
        <a href="javascript:window.print()" class="btn btn-primary mt-3">طباعة</a>
        <a href="students-list.php?course_id=<?= $course_id ?>" class="btn btn-secondary mt-3 ms-2">رجوع</a>
    </div>
</body>
</html>
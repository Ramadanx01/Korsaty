<?php
require_once 'includes/init.php';
require_once 'includes/functions.php';

if (!is_logged_in() || current_role() !== 'teacher') redirect('login.php');

$user = current_user();
$course_id = (int)($_GET['course_id'] ?? 0);

$pdo = db();
$stmt = $pdo->prepare("SELECT title FROM courses WHERE id = ? AND teacher_id = ?");
$stmt->execute([$course_id, $user['id']]);
$course = $stmt->fetch();
if (!$course) die('❌ لا تملك صلاحية لعرض هذا الكورس');

$stmt = $pdo->prepare("SELECT u.id, u.username, u.email, u.profile_image, e.created_at FROM enrollments e JOIN users u ON e.user_id = u.id WHERE e.course_id = ? ORDER BY e.created_at DESC");
$stmt->execute([$course_id]);
$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <title>الطلاب - <?= esc($course['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard-style.css">
</head>
<body>
<?php require_once 'includes/dashboard-sidebar.php'; ?>

<div class="content-wrapper p-4">
    <h2 class="fw-bold mb-4">الطلاب المسجّلين في: <?= esc($course['title']) ?></h2>

    <?php if ($students): ?>
        <table class="table table-hover text-center align-middle">
            <thead class="table-primary"><tr><th>#</th><th>الصورة</th><th>الاسم</th><th>البريد</th><th>تاريخ التسجيل</th><th>شهادة</th></tr></thead>
            <tbody>
                <?php $i = 1; foreach ($students as $s): ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><img src="<?= image_or_default($s['profile_image']) ?>" width="40" class="rounded-circle"></td>
                        <td><?= esc($s['username']) ?></td>
                        <td><?= esc($s['email']) ?></td>
                        <td><?= date('Y-m-d', strtotime($s['created_at'])) ?></td>
                        <td><a href="certificate.php?course_id=<?= $course_id ?>&student_id=<?= $s['id'] ?>" class="btn btn-success btn-sm"><i class="fas fa-certificate"></i></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info text-center">لا يوجد طلاب مسجّلين بهذا الكورس.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
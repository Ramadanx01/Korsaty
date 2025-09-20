<?php
require_once 'includes/init.php';
require_once 'includes/functions.php';

if (!is_logged_in() || current_role() !== 'teacher') {
    redirect('login.php');
}

$user = current_user();
$course_id = (int)($_GET['course_id'] ?? 0);

// ✅ تأكد من ملكية الكورس
$pdo = db();
$stmt = $pdo->prepare("SELECT title FROM courses WHERE id = ? AND teacher_id = ?");
$stmt->execute([$course_id, $user['id']]);
$course = $stmt->fetch();

if (!$course) {
    die('❌ لا تملك صلاحية لعرض هذا الكورس');
}

// ✅ جلب التقييمات
$stmt = $pdo->prepare("
    SELECT
        u.username,
        u.profile_image,
        r.rating,
        r.comment,
        r.created_at
    FROM course_reviews r
    JOIN users u ON r.student_id = u.id
    WHERE r.course_id = ?
    ORDER BY r.created_at DESC
");
$stmt->execute([$course_id]);
$reviews = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقييمات الكورس - <?= esc($course['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard-style.css">
</head>
<body>
<?php require_once 'includes/dashboard-sidebar.php'; ?>

<div class="content-wrapper p-4">
    <h2 class="fw-bold mb-4">
        <i class="fas fa-star me-2"></i>
        تقييمات الكورس: <?= esc($course['title']) ?>
    </h2>

    <?php if ($reviews): ?>
        <div class="row g-4">
            <?php foreach ($reviews as $review): ?>
                <div class="col-md-6">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <img src="<?= image_or_default($review['profile_image']) ?>" width="40" height="40" class="rounded-circle me-2">
                                <span class="fw-bold"><?= esc($review['username']) ?></span>
                            </div>
                            <div class="mb-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star text-warning <?= $i <= $review['rating'] ? '' : 'text-muted' ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <p class="mb-1"><?= nl2br(esc($review['comment'])) ?></p>
                            <small class="text-muted"><?= date('Y-m-d H:i', strtotime($review['created_at'])) ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">لا توجد تقييمات لهذا الكورس حتى الآن.</div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
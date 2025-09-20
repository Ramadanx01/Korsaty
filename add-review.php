<?php
require_once 'includes/init.php';
require_once 'includes/functions.php';

if (!is_logged_in() || current_role() !== 'teacher') {
    redirect('login.php');
}

$user = current_user();
$course_id = (int)($_GET['course_id'] ?? 0);
$student_id = (int)($_GET['student_id'] ?? 0);

// ✅ تحقق من ملكية الكورس والطالب
$pdo = db();
$stmt = $pdo->prepare("SELECT 1 FROM courses WHERE id = ? AND teacher_id = ?");
$stmt->execute([$course_id, $user['id']]);
if (!$stmt->fetch()) {
    die('❌ لا تملك صلاحية لتقييم هذا الكورس');
}

// ✅ جلب اسم الطالب
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$student_id]);
$student = $stmt->fetch();
if (!$student) {
    die('❌ الطالب غير موجود');
}

// ✅ إرسال التقييم
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = (int)($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');

    if ($rating < 1 || $rating > 5) {
        $error = 'التقييم يجب أن يكون بين 1 و 5';
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO course_reviews (course_id, student_id, rating, comment)
            VALUES (?, ?, ?, ?)
            ON DUPLICATE KEY UPDATE rating = VALUES(rating), comment = VALUES(comment)
        ");
        $stmt->execute([$course_id, $student_id, $rating, $comment]);
        redirect("course-reviews.php?course_id=$course_id");
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تقييم الطالب <?= esc($student['username']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/dashboard-style.css">
</head>
<body>
<?php require_once 'includes/dashboard-sidebar.php'; ?>

<div class="content-wrapper p-4">
    <h2 class="fw-bold mb-4">تقييم الطالب: <?= esc($student['username']) ?></h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= esc($error) ?></div>
    <?php endif; ?>

    <form action="" method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label">التقييم (1-5 نجوم)</label>
            <select name="rating" class="form-select" required>
                <option value="" disabled selected>اختر التقييم</option>
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <option value="<?= $i ?>"><?= $i ?> نجوم</option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">تعليق (اختياري)</label>
            <textarea name="comment" rows="3" class="form-control" placeholder="اكتب تعليقك هنا..."></textarea>
        </div>
        <button type="submit" class="btn btn-success">حفظ التقييم</button>
        <a href="course-reviews.php?course_id=<?= $course_id ?>" class="btn btn-secondary ms-2">رجوع</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
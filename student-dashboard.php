<?php
require_once 'includes/init.php';
require_once 'includes/functions.php';
require_once 'includes/db.php';

// التحقق من صلاحية الوصول (للطالب فقط)
if (!is_logged_in() || current_role() !== 'student') {
    redirect('login.php');
}

// جلب بيانات المستخدم الحالي
$user = current_user();
$salutation = salutation($user['gender'] ?? 'male');

// جلب عدد الكورسات المسجلة للطالب
$pdo = db();
try {
    $stmt = $pdo->prepare("SELECT COUNT(user_id) AS total_courses FROM registrations WHERE user_id = ?");
    $stmt->execute([$user['id']]);
    $totalCourses = $stmt->fetchColumn();

    // جلب كورسات الطالب مع معلومات المدرب ونسبة التقدم
    $stmt = $pdo->prepare("
        SELECT
            c.title,
            c.image,
            t.username AS teacher_name,
            r.progress_percentage
        FROM
            registrations r
        JOIN
            courses c ON r.course_id = c.id
        JOIN
            users t ON c.teacher_id = t.id
        WHERE
            r.user_id = ?
    ");
    $stmt->execute([$user['id']]);
    $myCourses = $stmt->fetchAll();

    // جلب آخر التقييمات
    // بما أننا لم نقم بإنشاء جدول التقييمات بعد، سنترك هذا الجزء فارغاً.
    // يمكنك إضافة الكود هنا لاحقاً عند إنشاء الجدول.
    $latestReviews = [];

} catch (PDOException $e) {
    // يمكنك إضافة رسالة خطأ مناسبة هنا
    $myCourses = [];
    $totalCourses = 0;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>لوحة تحكم الطالب - Korsaty</title>

  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <?php require_once 'includes/navbar.php'; ?>

  <section class="container mt-5 pt-5">
    <h1 class="fw-bold mb-4">أهلاً بك، <?php echo esc($user['username']); ?>! 👋</h1>

    <div class="row g-4 mb-5">
      <div class="col-md-4">
        <div class="stat-card bg-primary text-white">
          <h5><i class="fas fa-book-open me-2"></i>الكورسات المسجّلة</h5>
          <p class="fs-2 fw-bold mb-0"><?php echo esc($totalCourses); ?></p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card bg-warning text-dark">
          <h5><i class="fas fa-award me-2"></i>الشهادات المكتسبة</h5>
          <p class="fs-2 fw-bold mb-0">0</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card bg-success text-white">
          <h5><i class="fas fa-tasks me-2"></i>المهام المكتملة</h5>
          <p class="fs-2 fw-bold mb-0">0</p>
        </div>
      </div>
    </div>

    <div class="card shadow-sm p-4 mb-5">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary mb-0">كورساتي</h3>
        <a href="courses.php" class="btn btn-outline-primary">تصفح المزيد</a>
      </div>
      <div class="row g-4">
        <?php if (!empty($myCourses)): ?>
            <?php foreach ($myCourses as $course): ?>
                <div class="col-lg-4 col-md-6">
                    <div class="course-card card h-100 shadow-sm">
                        <img src="<?php echo image_or_default($course['image'], 'images/defaults/course-placeholder.jpg'); ?>" class="card-img-top" alt="<?php echo esc($course['title']); ?>">
                        <div class="card-body">
                            <h5 class="fw-bold"><?php echo esc($course['title']); ?></h5>
                            <p class="text-muted small">م. <?php echo esc($course['teacher_name']); ?></p>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-warning" style="width: <?php echo esc($course['progress_percentage']); ?>%"></div>
                            </div>
                            <p class="small text-muted mb-2"><?php echo esc($course['progress_percentage']); ?>% مكتمل</p>
                            <a href="course-details.php" class="btn btn-warning btn-sm w-100">متابعة الكورس</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center p-5">
                <p>لم تقم بالتسجيل في أي كورس بعد.</p>
                <a href="courses.php" class="btn btn-primary mt-3">اكتشف الكورسات</a>
            </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="card shadow-sm p-4">
      <h3 class="fw-bold text-primary mb-4">آخر التقييمات</h3>
      <div class="list-group">
        <?php if (!empty($latestReviews)): ?>
            <?php foreach ($latestReviews as $review): ?>
                <?php endforeach; ?>
        <?php else: ?>
            <div class="text-center p-4">
                <p>لا يوجد تقييمات لعرضها حالياً.</p>
            </div>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <footer class="footer text-center text-white py-4 mt-5">
    <div class="container">
      <p class="mb-0">&copy; 2025 Korsaty. جميع الحقوق محفوظة.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script src="js/script.js"></script>
</body>
</html>
<?php
require_once 'includes/init.php';
require_once 'includes/functions.php';
require_once 'includes/db.php';

if (!is_logged_in() || current_role() !== 'teacher') {
    redirect('login.php');
}

$user = current_user();
$salutation = salutation($user['gender'] ?? 'male');

$pdo = db();
$course_id_to_edit = (int)($_GET['edit'] ?? 0);
$edit_course = null;

if ($course_id_to_edit > 0) {
    $stmt = $pdo->prepare("SELECT * FROM courses WHERE id = ? AND teacher_id = ?");
    $stmt->execute([$course_id_to_edit, $user['id']]);
    $edit_course = $stmt->fetch();
}

$stmt = $pdo->prepare("SELECT id, title, price, is_published, created_at FROM courses WHERE teacher_id = ? ORDER BY created_at DESC");
$stmt->execute([$user['id']]);
$courses = $stmt->fetchAll();

$studentsCount = [];
foreach ($courses as $course) {
    $stmt = $pdo->prepare("SELECT COUNT(DISTINCT user_id) FROM enrollments WHERE course_id = ?");
    $stmt->execute([$course['id']]);
    $studentsCount[$course['id']] = $stmt->fetchColumn();
}

// Stats
$totalCourses = count($courses);
$totalStudents = 0;
foreach ($studentsCount as $count) {
    $totalStudents += $count;
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة تحكم المدرس - Korsaty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/dashboard-style.css">
</head>
<body>
<?php require_once 'includes/dashboard-sidebar.php'; ?>
<button class="btn btn-dark sidebar-toggle-btn d-lg-none" type="button">
    <i class="fas fa-bars"></i>
</button>

<div class="content-wrapper p-4">
    <h2 class="fw-bold mb-4">أهلاً بك، <?= esc($salutation) ?> <?= esc($user['username']) ?>!</h2>
    
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="card stat-card bg-primary text-white shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title fw-bold">إجمالي الكورسات</h5>
                        <p class="card-text fs-3 fw-bold"><?= $totalCourses ?></p>
                    </div>
                    <i class="fas fa-book-open fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card stat-card bg-success text-white shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title fw-bold">إجمالي الطلاب</h5>
                        <p class="card-text fs-3 fw-bold"><?= $totalStudents ?></p>
                    </div>
                    <i class="fas fa-users fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card stat-card bg-info text-white shadow-sm">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title fw-bold">التقييمات</h5>
                        <p class="card-text fs-3 fw-bold">--</p>
                    </div>
                    <i class="fas fa-star fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div id="addCourseForm" class="card p-4 shadow-sm">
                <h3 class="card-title fw-bold text-center mb-4"><?= $edit_course ? 'تعديل كورس' : 'نشر كورس جديد' ?></h3>
                <form action="save-course.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="course_id" value="<?= esc($edit_course['id'] ?? 0) ?>">
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">عنوان الكورس:</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= esc($edit_course['title'] ?? '') ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">الوصف:</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required><?= esc($edit_course['description'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="price" class="form-label">السعر ($):</label>
                        <input type="number" class="form-control" id="price" name="price" value="<?= esc($edit_course['price'] ?? '') ?>" step="0.01" required>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="image" class="form-label">صورة الكورس:</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <?php if (!empty($edit_course['image_path'])): ?>
                                <img src="<?= asset($edit_course['image_path']) ?>" alt="صورة الكورس" class="img-thumbnail mt-2">
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">محتوى الفيديو:</label>
                            <div class="mb-2">
                                <select class="form-select" onchange="toggleVideoInput(this)">
                                    <option value="file">رفع فيديو</option>
                                    <option value="youtube" <?= !empty($edit_course['video_path']) && str_contains($edit_course['video_path'], 'youtube.com') ? 'selected' : '' ?>>رابط YouTube</option>
                                </select>
                            </div>
                            <div id="videoFileInput" style="display: <?= !empty($edit_course['video_path']) && str_contains($edit_course['video_path'], 'youtube.com') ? 'none' : 'block' ?>">
                                <input type="file" name="video" class="form-control" accept="video/*">
                            </div>
                            <div id="videoUrlInput" style="display: <?= !empty($edit_course['video_path']) && str_contains($edit_course['video_path'], 'youtube.com') ? 'block' : 'none' ?>">
                                <input type="url" name="youtube_url" class="form-control" value="<?= !empty($edit_course['video_path']) && str_contains($edit_course['video_path'], 'youtube.com') ? esc($edit_course['video_path']) : '' ?>" placeholder="https://www.youtube.com/watch?v=...">
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg"><?= $edit_course ? 'تحديث الكورس' : 'نشر الكورس' ?></button>
                        <?php if ($edit_course): ?>
                            <a href="teacher-dashboard.php" class="btn btn-secondary btn-lg">إلغاء التعديل</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card p-4 shadow-sm">
                <h3 class="card-title fw-bold text-center mb-4">كورساتي</h3>
                <?php if (!empty($courses)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped text-center align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>العنوان</th>
                                    <th>السعر</th>
                                    <th>عدد الطلاب</th>
                                    <th>الحالة</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($courses as $course): ?>
                                    <tr>
                                        <td><?= esc($course['title']) ?></td>
                                        <td><?= esc($course['price']) ?>$</td>
                                        <td><?= esc($studentsCount[$course['id']] ?? 0) ?></td>
                                        <td>
                                            <span class="badge rounded-pill bg-<?= $course['is_published'] ? 'success' : 'secondary' ?>">
                                                <?= $course['is_published'] ? 'منشور' : 'مسودة' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="students-list.php?course_id=<?= $course['id'] ?>" class="btn btn-sm btn-info text-white" title="الطلاب"><i class="fas fa-users"></i></a>
                                                <a href="teacher-dashboard.php?edit=<?= $course['id'] ?>#addCourseForm" class="btn btn-sm btn-warning text-white" title="تعديل"><i class="fas fa-edit"></i></a>
                                                <a href="delete-course.php?id=<?= $course['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا الكورس؟')" title="حذف"><i class="fas fa-trash-alt"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info text-center mt-3">
                        <p class="mb-0">لم تقم بإنشاء أي كورسات بعد.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
<script>
    function toggleVideoInput(selectElement) {
        const fileInput = document.getElementById('videoFileInput');
        const urlInput = document.getElementById('videoUrlInput');
        if (selectElement.value === 'youtube') {
            fileInput.style.display = 'none';
            urlInput.style.display = 'block';
        } else {
            fileInput.style.display = 'block';
            urlInput.style.display = 'none';
        }
    }
</script>
</body>
</html>
<?php
require_once __DIR__ . '/functions.php';

$user = current_user();
$role_name = get_role_name($user['role'] ?? 'student');
$profile_image = image_or_default($user['profile_image'], 'images/defaults/default-avatar.png');
?>

<button class="btn btn-dark sidebar-toggle-btn d-lg-none" type="button">
    <i class="fas fa-bars"></i>
</button>

<div class="sidebar-wrapper d-flex flex-column bg-dark text-white p-4">
    <div class="logo text-center mb-4">
        <a href="index.php"><img src="images/logo.png" alt="شعار Korsaty" width="70"></a>
    </div>

    <div class="user-info text-center mb-4">
        <img src="<?= esc($profile_image) ?>" class="rounded-circle object-fit-cover"
             style="width: 90px; height: 90px; border: 3px solid #fff;">
        <h5 class="fw-bold text-white mb-0"><?= esc($user['username']) ?></h5>
        <span class="badge bg-light text-dark"><?= esc($role_name) ?></span>
    </div>

    <nav class="sidebar-nav flex-grow-1">
        <ul class="nav flex-column mb-auto">
            <li class="nav-item"><a class="nav-link text-white" href="index.php"><i class="fas fa-home me-2"></i> الصفحة الرئيسية</a></li>
            <li class="nav-item"><a class="nav-link text-white <?= nav_active('teacher-dashboard.php') ?>" href="teacher-dashboard.php"><i class="fas fa-tachometer-alt me-2"></i> لوحة التحكم</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="teacher-dashboard.php#addCourseForm"><i class="fas fa-plus-circle me-2"></i> إضافة كورس </a></li>
            <li class="nav-item"><a class="nav-link text-white" href="students-list.php"><i class="fas fa-users me-2"></i> الطلاب</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="certificates.php"><i class="fas fa-certificate me-2"></i> الشهادات</a></li>
            <li class="nav-item"><a class="nav-link text-white" href="reviews.php"><i class="fas fa-comments me-2"></i> التقييمات</a></li>
        </ul>
    </nav>

    <div class="sidebar-footer mt-auto pt-3">
        <a class="d-flex align-items-center text-white text-decoration-none" href="logout.php">
            <i class="fas fa-sign-out-alt me-2"></i>
            <span>تسجيل الخروج</span>
        </a>
    </div>
</div>
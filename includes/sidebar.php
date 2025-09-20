<?php
// includes/sidebar.php

$current_page = basename($_SERVER['PHP_SELF']);
$user_info = current_user();
$profile_image = image_or_default($user_info['profile_image'] ?? null, 'images/defaults/default-avatar.png');
$role = current_role();
?>

<div class="sidebar-wrapper d-flex flex-column">

    <div class="logo-container text-center mb-4">
        <a href="index.php">
            <img src="<?= asset('images/logo.png') ?>" alt="شعار Korsaty" width="70">
        </a>
    </div>

    <div class="user-info text-center mb-4">
        <img src="<?= esc($profile_image) ?>" class="rounded-circle object-fit-cover" style="width: 90px; height: 90px; border: 3px solid #fff;">
        <h5 class="fw-bold text-white mb-0"><?= esc(current_username()) ?></h5>
        <span class="badge bg-light text-dark"><?= esc(get_role_name($role)) ?></span>
    </div>
    
    <nav class="sidebar-nav flex-grow-1">
        <ul class="nav flex-column mb-auto">
            <?php if ($role === 'teacher'): ?>
                <li class="nav-item">
                    <a class="nav-link text-white <?= nav_active('teacher-dashboard.php') ?>" href="teacher-dashboard.php">
                        <i class="fas fa-tachometer-alt me-2"></i> لوحة التحكم
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?= nav_active('teacher-dashboard.php#addCourseForm') ?>" href="teacher-dashboard.php#addCourseForm">
                        <i class="fas fa-plus-circle me-2"></i> إضافة كورس
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?= nav_active('students-list.php') ?>" href="students-list.php">
                        <i class="fas fa-users me-2"></i> الطلاب
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?= nav_active('certificates.php') ?>" href="certificates.php">
                        <i class="fas fa-certificate me-2"></i> الشهادات
                    </a>
                </li>
            <?php elseif ($role === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link text-white <?= nav_active('admin-dashboard.php') ?>" href="admin-dashboard.php">
                        <i class="fas fa-tachometer-alt me-2"></i> الرئيسية
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?= nav_active('admin-users.php') ?>" href="admin-users.php">
                        <i class="fas fa-users me-2"></i> إدارة المستخدمين
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?= nav_active('admin-courses.php') ?>" href="admin-courses.php">
                        <i class="fas fa-book-open me-2"></i> إدارة الكورسات
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?= nav_active('teacher-dashboard.php') ?>" href="teacher-dashboard.php">
                        <i class="fas fa-tachometer-alt me-2"></i> لوحة التحكم
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?= nav_active('profile-settings.php') ?>" href="profile-settings.php">
                        <i class="fas fa-user-circle me-2"></i> إعدادات الملف الشخصي
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    
    <div class="logout-container text-center mt-4">
        <a class="btn btn-danger" href="logout.php">
            <i class="fas fa-sign-out-alt me-2"></i> تسجيل الخروج
        </a>
    </div>

</div>


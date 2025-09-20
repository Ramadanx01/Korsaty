<?php
// includes/navbar.php
require_once __DIR__ . '/functions.php';

$is_logged = is_logged_in();
$user_role = current_role();
$username = current_username();
$salutation = salutation(current_gender());
$profile_image = image_or_default(current_user()['profile_image'] ?? null, 'images/defaults/default-avatar.png');
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?php echo url_for('index.php'); ?>">
            <img src="<?php echo asset('images/logo.png'); ?>" alt="شعار Korsaty" width="50" height="50">
            <span class="fw-bold ms-2 fs-4 text-primary">Korsaty</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link <?php echo nav_active('index.php'); ?>" href="<?php echo url_for('index.php'); ?>">الرئيسية</a></li>
                <li class="nav-item"><a class="nav-link <?php echo nav_active('courses.php'); ?>" href="<?php echo url_for('courses.php'); ?>">الكورسات</a></li>
                <li class="nav-item"><a class="nav-link <?php echo nav_active('contact.php'); ?>" href="<?php echo url_for('contact.php'); ?>">تواصل معنا</a></li>
            </ul>

            <div class="d-flex align-items-center">
                <?php if ($is_logged): ?>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?php echo esc($profile_image); ?>" class="rounded-circle me-2" alt="بروفايل" width="40" height="40">
                            <span class="fw-bold"><?php echo esc($username); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <?php if ($user_role === 'student'): ?>
                                <li><a class="dropdown-item" href="<?php echo url_for('student-dashboard.php'); ?>">لوحة تحكم الطالب</a></li>
                            <?php elseif ($user_role === 'teacher'): ?>
                                <li><a class="dropdown-item" href="<?php echo url_for('teacher-dashboard.php'); ?>">لوحة تحكم المدرس</a></li>
                            <?php elseif ($user_role === 'admin'): ?>
                                <li><a class="dropdown-item" href="<?php echo url_for('admin-dashboard.php'); ?>">لوحة تحكم الأدمن</a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="#">تعديل الملف الشخصي</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?php echo url_for('logout.php'); ?>">تسجيل الخروج</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?php echo url_for('login.php'); ?>" class="btn btn-outline-primary me-2">تسجيل الدخول</a>
                    <a href="<?php echo url_for('register.php'); ?>" class="btn btn-primary">سجل الآن</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
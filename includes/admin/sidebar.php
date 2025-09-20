<?php
// includes/admin/sidebar.php

$current_page = basename($_SERVER['PHP_SELF']);
$user_info = current_user();
$profile_image = image_or_default($user_info['profile_image'] ?? null, 'images/defaults/default-avatar.png');
?>

<div class="sidebar d-flex flex-column">

    <div class="logo-container">
        <a href="<?php echo url_for('admin-dashboard.php'); ?>">
            <img src="<?php echo asset('images/logo.png'); ?>" alt="شعار Korsaty">
        </a>
    </div>
    
    <ul class="nav flex-column mb-auto">
        <li class="nav-item">
            <a class="nav-link <?php echo ($current_page === 'admin-dashboard.php' ? 'active' : ''); ?>" href="<?php echo url_for('admin-dashboard.php'); ?>">
                <i class="fas fa-tachometer-alt me-2"></i>الرئيسية
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo ($current_page === 'admin-users.php' ? 'active' : ''); ?>" href="<?php echo url_for('admin-users.php'); ?>">
                <i class="fas fa-users me-2"></i>إدارة المستخدمين
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?php echo ($current_page === 'admin-courses.php' ? 'active' : ''); ?>" href="<?php echo url_for('admin-courses.php'); ?>">
                <i class="fas fa-book-open me-2"></i>إدارة الكورسات
            </a>
        </li>
        
    </ul>

    <div class="sidebar-footer">
        <a class="profile-link text-decoration-none" href="<?php echo url_for('profile.php'); ?>">
            <div class="profile-info mb-3">
                <img src="<?php echo esc($profile_image); ?>" alt="صورة الملف الشخصي">
                <p class="mb-0 fw-bold"><?php echo esc(current_username()); ?></p>
                <small class="text-muted"><?php echo esc(current_role()); ?></small>
            </div>
        </a>
        <a class="logout-link d-block text-center" href="<?php echo url_for('logout.php'); ?>">
            <i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج
        </a>
    </div>
</div>
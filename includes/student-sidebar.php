<?php
require_once __DIR__ . '/functions.php';
$user = current_user();
$role_name = 'طالب';
$profile_image = image_or_default($user['profile_image'] ?? null, 'images/defaults/default-avatar.png');
?>

<div class="sidebar-wrapper d-flex flex-column bg-success text-white p-4">
  <div class="logo text-center mb-4">
    <a href="index.php"><img src="images/logo.png" alt="شعار Korsaty" width="70"></a>
  </div>

  <div class="user-info text-center mb-4">
    <img src="<?= esc($profile_image) ?>" alt="صورة الملف الشخصي" class="rounded-circle object-fit-cover" style="width:90px;height:90px;border:3px solid #fff;">
    <h5 class="fw-bold text-white mb-0"><?= esc($user['name']) ?></h5>
    <span class="badge bg-light text-dark"><?= $role_name ?></span>
  </div>

  <nav class="sidebar-nav flex-grow-1">
    <ul class="nav flex-column mb-auto">
      <li class="nav-item">
        <a class="nav-link text-white <?= nav_active('student-dashboard.php') ?>" href="student-dashboard.php">
          <i class="fas fa-home me-2"></i> الرئيسية
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white <?= nav_active('student-profile.php') ?>" href="student-profile.php">
          <i class="fas fa-user-circle me-2"></i> ملفي الشخصي
        </a>
      </li>
    </ul>
  </nav>

  <div class="sidebar-footer mt-auto">
    <hr class="text-white-50">
    <a href="logout.php" class="btn btn-light w-100 text-dark fw-bold">
      <i class="fas fa-sign-out-alt me-2"></i> تسجيل الخروج
    </a>
  </div>
</div>
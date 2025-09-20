<?php
require_once 'includes/init.php';

if (!is_logged_in() || current_role() !== 'admin') {
    redirect('login.php');
}

// إحصائيات
$users_count = get_users_count();
$courses_count = get_courses_count();
$latest_users = get_latest_users(5);
$latest_courses = get_latest_courses(5);

$user = current_user();
$salutation = salutation($user['gender'] ?? 'male');
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة تحكم الأدمن</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/admin.css">


    <style>
        body {background: #f8f9fa;}
        .sidebar {min-width: 220px; background: #fff; border-left: 1px solid #eee; min-height: 100vh;}
        .sidebar .logo-container {text-align: center; padding: 20px 0;}
        .sidebar img {max-width: 120px;}
        .sidebar .nav-link.active {background: #0d6efd; color: #fff !important;}
        .sidebar-footer {padding: 20px; border-top: 1px solid #eee;}
        .profile-info img {width: 48px; height: 48px; border-radius: 50%;}
        .main-content {padding: 30px;}
        .stat-card {background: #fff; border-radius: 8px; box-shadow: 0 1px 4px #0001; padding: 20px; margin-bottom: 20px;}
        .table {background: #fff;}
    </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-3 col-lg-2 p-0">
      <?php include 'includes/admin/sidebar.php'; ?>
    </div>
    <div class="col-md-9 col-lg-10 main-content">
      <h1 class="mb-4">مرحباً بك في لوحة تحكم الأدمن 👋</h1>
      <div class="row mb-4">
        <div class="col-md-6">
          <div class="stat-card text-center">
            <i class="fas fa-users fa-2x mb-2 text-primary"></i>
            <h4>عدد المستخدمين</h4>
            <p class="fs-3 fw-bold"><?php echo $users_count; ?></p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="stat-card text-center">
            <i class="fas fa-book-open fa-2x mb-2 text-success"></i>
            <h4>عدد الكورسات</h4>
            <p class="fs-3 fw-bold"><?php echo $courses_count; ?></p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="stat-card">
            <h5 class="mb-3">أحدث المستخدمين</h5>
            <table class="table table-sm">
              <thead><tr><th>الاسم</th><th>الدور</th></tr></thead>
              <tbody>
                <?php foreach($latest_users as $u): ?>
                  <tr>
                    <td><?php echo esc($u['username']); ?></td>
                    <td><?php echo get_role_name($u['role']); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-6">
          <div class="stat-card">
            <h5 class="mb-3">أحدث الكورسات</h5>
            <table class="table table-sm">
              <thead><tr><th>اسم الكورس</th></tr></thead>
              <tbody>
                <?php foreach($latest_courses as $c): ?>
                  <tr>
                    <td><?php echo esc($c['title']); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col">
          <a href="admin-users.php" class="btn btn-primary me-2"><i class="fas fa-users"></i> إدارة المستخدمين</a>
          <a href="admin-courses.php" class="btn btn-success"><i class="fas fa-book-open"></i> إدارة الكورسات</a>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
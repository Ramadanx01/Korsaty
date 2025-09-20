<?php
require_once 'includes/init.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $role = $_POST['accountRole'] ?? 'student';

    // التحقق من صحة البيانات
    if (empty($username) || empty($email) || empty($password) || empty($phone)) {
        $error = 'يرجى ملء جميع الحقول المطلوبة.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'صيغة البريد الإلكتروني غير صحيحة.';
    } elseif (mb_strlen($password) < 6) {
        $error = 'يجب أن لا تقل كلمة المرور عن 6 أحرف.';
    } elseif (user_exists(db(), $email)) { 
        $error = 'البريد الإلكتروني هذا مستخدم بالفعل.';
    } else {
        if (register_user(db(), $username, $email, $password, $phone, $role)) {
            $success = 'تم تسجيل حسابك بنجاح! سيتم تحويلك لصفحة الدخول.';
            redirect('login.php');
        } else {
            $error = 'حدث خطأ أثناء التسجيل، يرجى المحاولة مرة أخرى.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تسجيل حساب جديد - Korsaty</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body style="font-family: 'Cairo', sans-serif; background-color: #f0f2f5;">

  <nav class="navbar navbar-expand-lg shadow-sm bg-white">
    <div class="container">
      <a class="navbar-brand fw-bold text-primary" href="index.html">
        <img src="images/logo.png" alt="Korsaty" width="40" height="40">
        كورساتي
      </a>
    </div>
  </nav>
  <section class="d-flex align-items-center justify-content-center py-5" style="min-height: 90vh;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-8 col-sm-10">
          <div class="card p-4 shadow-lg rounded-3 border-0">
            <h2 class="text-center fw-bold mb-4">إنشاء حساب جديد</h2>
            
            <?php if ($error): ?>
              <div class="alert alert-danger" role="alert"><?php echo esc($error); ?></div>
            <?php elseif ($success): ?>
              <div class="alert alert-success" role="alert"><?php echo esc($success); ?></div>
            <?php endif; ?>

            <form action="" method="POST">
              <div class="mb-3">
                <label for="username" class="form-label">اسم المستخدم:</label>
                  <input type="text" class="form-control rounded-3" id="username" name="username" required placeholder="ادخل اسم المستخدم">
                <div class="invalid-feedback">يرجى إدخال اسم المستخدم.</div>
              </div>
              
              <div class="mb-3">
                <label for="email" class="form-label">البريد الإلكتروني:</label>
                <input type="email" class="form-control rounded-3" id="email" name="email" required>
                <div class="invalid-feedback">يرجى إدخال بريد إلكتروني صالح.</div>
              </div>
              
              <div class="mb-3">
                <label for="password" class="form-label">كلمة المرور:</label>
                <input type="password" class="form-control rounded-3" id="password" name="password" required>
                <div class="invalid-feedback">يجب أن لا تقل كلمة المرور عن 6 أحرف.</div>
              </div>

              <div class="mb-3">
                <label for="phone" class="form-label">رقم الهاتف:</label>
                <input type="tel" class="form-control rounded-3" id="phone" name="phone" required>
                <div class="invalid-feedback">يرجى إدخال رقم الهاتف.</div>
              </div>

              <div class="mb-4">
                <label class="form-label">نوع الحساب:</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="accountRole" id="roleStudent" value="student" checked>
                  <label class="form-check-label" for="roleStudent">طالب</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="accountRole" id="roleTeacher" value="teacher">
                  <label class="form-check-label" for="roleTeacher">مدرس</label>
                </div>
              </div>

              <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg rounded-3">تسجيل</button>
              </div>
            </form>

            <div class="mt-3 text-center text-muted">
              لديك حساب بالفعل؟ 
              <a href="login.php" class="fw-bold text-warning text-decoration-none">سجل الدخول</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php include 'includes/footer.php'; ?>

</body>
</html>
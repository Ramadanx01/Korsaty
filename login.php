<?php
require_once 'includes/init.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

$error = null;

// التحقق من أن الطلب POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // التحقق من صحة البيانات المدخلة
    if (empty($email) || empty($password)) {
        $error = 'يرجى إدخال البريد الإلكتروني وكلمة السر.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'صيغة البريد الإلكتروني غير صحيحة.';
    } else {
        // محاولة تسجيل الدخول باستخدام الدالة الجديدة
        $loggedInUser = login_user(db(), $email, $password);
        
        if ($loggedInUser) {
            // تسجيل الدخول بنجاح، تحويل المستخدم بناءً على دوره
            redirect_based_on_role($loggedInUser['role']);
        } else {
            $error = 'البريد الإلكتروني أو كلمة السر غير صحيحة.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تسجيل الدخول - Korsaty</title>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body style="font-family: 'Cairo', sans-serif; background-color: #f0f2f5;">

  <section class="d-flex align-items-center justify-content-center py-5" style="min-height: 100vh;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card p-4 shadow-lg border-0 rounded-4">
            
            <div class="text-center mb-4">
              <img src="images/logo.png" alt="شعار Korsaty" width="80" height="80">
            </div>

            <h2 class="text-center fw-bold mb-4 text-primary">أهلاً بك مرة أخرى!</h2>

            <?php if ($error): ?>
                <div class="alert alert-danger text-center"><?php echo esc($error); ?></div>
            <?php endif; ?>

            <div class="d-grid mb-3">
              <button class="btn btn-outline-dark btn-lg" type="button">
                <i class="fab fa-google me-2"></i> تسجيل الدخول باستخدام Google
              </button>
            </div>
            
            <div class="d-flex align-items-center my-3">
              <hr class="flex-grow-1">
              <span class="px-3 text-muted">أو</span>
              <hr class="flex-grow-1">
            </div>
            
            <form action="" method="POST" class="needs-validation" novalidate>
              <div class="mb-3">
                <label for="email" class="form-label">البريد الإلكتروني:</label>
                <input type="email" class="form-control rounded-3" id="email" name="email" required placeholder="ادخل بريدك الإلكتروني">
                <div class="invalid-feedback">
                  يرجى إدخال بريد إلكتروني صحيح.
                </div>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">كلمة السر:</label>
                <input type="password" class="form-control rounded-3" id="password" name="password" required placeholder="ادخل كلمة السر">
                <div class="invalid-feedback">
                  يرجى إدخال كلمة السر.
                </div>
                <div class="text-start mt-2">
                  <a href="#" class="text-decoration-none small text-muted">هل نسيت كلمة السر؟</a>
                </div>
              </div>

              <div class="d-grid my-4">
                <button type="submit" class="btn btn-primary btn-lg rounded-3">تسجيل الدخول</button>
              </div>
            </form>
            
            <div class="text-center text-muted">
              ليس لديك حساب؟ 
              <a href="register.php" class="text-decoration-none fw-bold text-warning">سجل الآن</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <footer class="text-center py-4 text-white" style="background-color: #0d6efd;">
    <div class="container">
      <p class="mb-0">&copy; 2025 Korsaty. جميع الحقوق محفوظة.</p>
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- <script src="js/script.js"></script> -->
</body>
</html>

البريد الإلكتروني: admin@example.com

كلمة المرور: password

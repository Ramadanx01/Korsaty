<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>كورساتي | الرئيسية</title>
  <link rel="icon" href="images/logo.png">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

  <!-- نافبار -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-2">
    <div class="container">
      <a class="navbar-brand fw-bold" href="index.php">
        <img src="images/logo.png" alt="شعار كورساتي" width="40" height="40" class="me-2">
        كورساتي
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link active" href="index.php">الرئيسية</a></li>
          <li class="nav-item"><a class="nav-link" href="courses.php">الكورسات</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">من نحن</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.php">تواصل معنا</a></li>
        </ul>
        <a href="login.php" class="btn btn-primary ms-3">تسجيل الدخول</a>
      </div>
    </div>
  </nav>

  <!-- قسم الهيرو -->
  <section class="hero-section text-center text-white d-flex align-items-center">
    <div class="container">
      <h1 class="mb-3">تعلم من أفضل المدربين وطور مهاراتك مع كورساتي</h1>
      <p class="lead">منصة عربية تقدم كورسات احترافية في البرمجة، التصميم، التسويق، والمزيد. ابدأ رحلتك الآن!</p>
      <a href="courses.php" class="btn btn-warning btn-lg mt-3">تصفح الكورسات</a>
    </div>
  </section>

  <!-- مميزات المنصة -->
  <section class="container my-5">
    <div class="row g-4">
      <div class="col-md-4">
        <div class="feature-box p-4 bg-white shadow-sm text-center">
          <i class="fa-solid fa-chalkboard-user fa-2x mb-3 text-primary"></i>
          <h5>مدربين محترفين</h5>
          <p>جميع الكورسات مقدمة من خبراء معتمدين في مجالاتهم.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-box p-4 bg-white shadow-sm text-center">
          <i class="fa-solid fa-laptop-code fa-2x mb-3 text-primary"></i>
          <h5>تجربة تعليمية تفاعلية</h5>
          <p>دروس عملية واختبارات تفاعلية لكل كورس.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-box p-4 bg-white shadow-sm text-center">
          <i class="fa-solid fa-certificate fa-2x mb-3 text-primary"></i>
          <h5>شهادات معتمدة</h5>
          <p>احصل على شهادة إتمام لكل كورس تنهيه بنجاح.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- كورسات مختارة -->
  <section class="container my-5">
    <h2 class="mb-4 text-center">كورسات مختارة</h2>
    <div class="row g-4">
      <!-- كورس 1 -->
      <div class="col-md-4">
        <div class="course-card shadow-sm">
          <img src="images/course1.jpg" class="course-img" alt="كورس برمجة">
          <div class="course-content p-3">
            <h5>أساسيات البرمجة بلغة بايثون</h5>
            <p>تعلم البرمجة من الصفر مع تطبيقات عملية.</p>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <span class="price">مجاني</span>
            <a href="course-details.php?id=1" class="btn btn-outline-primary btn-sm">التفاصيل</a>
            </div>
          </div>
        </div>
      </div>
      <!-- كورس 2 -->
      <div class="col-md-4">
        <div class="course-card shadow-sm">
          <img src="images/course2.jpg" class="course-img" alt="كورس تصميم">
          <div class="course-content p-3">
            <h5>تصميم واجهات المستخدم UI/UX</h5>
            <p>أساسيات التصميم وتجربة المستخدم للمبتدئين.</p>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <span class="price">199 جنيه</span>
              <a href="course-details.php?id=2" class="btn btn-outline-primary btn-sm">التفاصيل</a>
            </div>
          </div>
        </div>
      </div>
      <!-- كورس 3 -->
      <div class="col-md-4">
        <div class="course-card shadow-sm">
          <img src="images/course3.jpg" class="course-img" alt="كورس تسويق">
          <div class="course-content p-3">
            <h5>أساسيات التسويق الرقمي</h5>
            <p>تعلم أهم استراتيجيات التسويق عبر الإنترنت.</p>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <span class="price">149 جنيه</span>
              <a href="course-details.php?id=3" class极="btn btn-outline-primary btn-sm">التفاصيل</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="text-center mt-4">
      <a href="courses.php" class="btn btn-primary btn-lg">عرض جميع الكورسات</a>
    </div>
  </section>

  <!-- فوتر -->
  <footer class="text-center py-5 text-white" style="background-color: #0d6efd;">
    <div class="container">
      <div class="row">
        <div class="col-md-4 mb-3">
          <h5 class="fw-bold">روابط سريعة</h5>
          <ul class="list-unstyled">
            <li><a href="index.php" class="text-white text-decoration-none">الرئيسية</a></li>
            <li><a href="courses.php" class="text-white text-decoration-none">كل الكورسات</a></li>
            <li><a href="about.php" class="text-white text-decoration-none">عن المنصة</a></li>
          </ul>
        </div>
        <div class="col-md-4 mb-3">
          <h5 class="fw-bold">تواصل معنا</h5>
          <ul class="list-unstyled">
            <li><a href="contact.php" class="text-white text-decoration-none">اتصل بنا</a></li>
            <li><a href="mailto:info@korsaty.com" class="text-white text-decoration-none">info@korsaty.com</a></li>
          </ul>
        </div>
        <div class="col-md-4 mb-3">
          <h5 class="fw-bold">تابعنا</h5>
          <div class="social-icons mt-3">
            <a href="#" class="text-white mx-2"><i class="fab fa-facebook-f fa-lg"></i></a>
            <a href="#" class="text-white mx-2"><i class="fab fa-twitter fa-lg"></i></a>
            <a href="#" class="text-white mx-2"><i class="fab fa-linkedin-in fa-lg"></i></a>
            <a href="#" class="text-white mx-2"><i class="fab fa-instagram fa-lg"></i></a>
          </div>
        </div>
      </div>
      <hr class="my-4" style="border-color: rgba(255, 255, 255, 0.2);">
      <p class="mb-0">&copy; 2025 Korsaty. جميع الحقوق محفوظة.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

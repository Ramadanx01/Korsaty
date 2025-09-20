<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تواصل معنا - Korsaty</title>

  <!-- خطوط + مكتبات خارجية -->
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <!-- ============ نافبار موحّد ============ -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-2">
    <div class="container">
      <a class="navbar-brand fw-bold d-flex align-items-center" href="index.html">
        <img src="images/logo.png" alt="شعار Korsaty" width="50" height="50" class="me-2">
        <span class="text-primary">Korsaty</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="index.html">الرئيسية</a></li>
          <li class="nav-item"><a class="nav-link" href="all-courses.html">الكورسات</a></li>
          <li class="nav-item"><a class="nav-link" href="about.html">من نحن</a></li>
          <li class="nav-item"><a class="nav-link active" href="contact.html">تواصل معنا</a></li>
        </ul>
        <a href="login.html" class="btn btn-primary ms-3">تسجيل الدخول</a>
      </div>
    </div>
  </nav>

  <!-- ============ هيدر الصفحة ============ -->
  <section class="container text-center py-5 mt-5">
    <h1 class="fw-bold mb-3 text-primary animate__animated animate__fadeInDown">تواصل معنا</h1>
    <p class="lead text-muted">فريقنا جاهز دائمًا لمساعدتك. لا تتردد في مراسلتنا في أي وقت.</p>
  </section>

  <!-- ============ المحتوى (معلومات + فورم) ============ -->
  <section class="container mb-5">
    <div class="row g-4">
      <!-- معلومات الاتصال -->
      <div class="col-md-5">
        <div class="card p-4 shadow-sm h-100 animate__animated animate__fadeInLeft">
          <h4 class="fw-bold mb-3 text-primary">معلومات الاتصال</h4>

          <div class="d-flex align-items-center mb-3">
            <i class="fas fa-envelope fa-2x me-3 text-primary"></i>
            <div>
              <p class="fw-bold mb-0">البريد الإلكتروني:</p>
              <a href="mailto:info@korsaty.com" class="text-decoration-none text-muted">info@korsaty.com</a>
            </div>
          </div>

          <div class="d-flex align-items-center mb-3">
            <i class="fas fa-phone fa-2x me-3 text-primary"></i>
            <div>
              <p class="fw-bold mb-0">رقم الهاتف:</p>
              <a href="tel:+201001234567" class="text-decoration-none text-muted">+20 100 123 4567</a>
            </div>
          </div>

          <h5 class="fw-bold mt-4 mb-3 text-primary">تابعنا على:</h5>
          <div class="social-icons">
            <a href="#" class="me-3 text-primary"><i class="fab fa-facebook-f fa-2x"></i></a>
            <a href="#" class="me-3 text-info"><i class="fab fa-twitter fa-2x"></i></a>
            <a href="#" class="me-3 text-danger"><i class="fab fa-instagram fa-2x"></i></a>
            <a href="#" class="text-primary"><i class="fab fa-linkedin-in fa-2x"></i></a>
          </div>
        </div>
      </div>

      <!-- فورم التواصل -->
      <div class="col-md-7">
        <div class="card p-4 shadow-sm h-100 animate__animated animate__fadeInRight">
          <h4 class="fw-bold mb-3 text-primary">أرسل لنا رسالة</h4>
          <form id="contactForm" class="needs-validation" novalidate>
            <div class="mb-3">
              <label for="name" class="form-label">الاسم:</label>
              <input type="text" class="form-control" id="name" required placeholder="ادخل اسمك بالكامل">
              <div class="invalid-feedback">يرجى إدخال اسمك.</div>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">البريد الإلكتروني:</label>
              <input type="email" class="form-control" id="email" required placeholder="ادخل بريدك الإلكتروني">
              <div class="invalid-feedback">يرجى إدخال بريد إلكتروني صحيح.</div>
            </div>
            <div class="mb-3">
              <label for="subject" class="form-label">الموضوع:</label>
              <input type="text" class="form-control" id="subject" required placeholder="موضوع الرسالة">
              <div class="invalid-feedback">يرجى إدخال موضوع الرسالة.</div>
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">الرسالة:</label>
              <textarea class="form-control" id="message" rows="5" required placeholder="اكتب رسالتك هنا..."></textarea>
              <div class="invalid-feedback">يرجى كتابة رسالة.</div>
            </div>
            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-primary btn-lg">إرسال الرسالة</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- ============ فوتر موحّد ============ -->
  <footer class="text-center py-4 footer-bg text-white">
    <p>© 2025 Korsaty. جميع الحقوق محفوظة.</p>
  </footer>

  <!-- سكريبتات -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>

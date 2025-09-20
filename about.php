<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>كورساتي | من نحن</title>
  <link rel="icon" href="images/logo.png">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
  

  <!-- نافبار موحد -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-2">
    <div class="container">
      <a class="navbar-brand fw-bold" href="index.html">
        <img src="images/logo.png" alt="شعار كورساتي" width="40" height="40" class="me-2">
        كورساتي
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="قائمة">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainNavbar">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link" href="index.html">الرئيسية</a></li>
          <li class="nav-item"><a class="nav-link" href="courses.html">الكورسات</a></li>
          <li class="nav-item"><a class="nav-link active" href="about.html">من نحن</a></li>
          <li class="nav-item"><a class="nav-link" href="contact.html">تواصل معنا</a></li>
        </ul>
        <a href="login.html" class="btn btn-primary ms-3">تسجيل الدخول</a>
      </div>
    </div>
  </nav>

  <!-- هيرو من نحن -->
  <section class="about-hero-section py-5 text-center">
    <div class="container">
      <h1 class="mb-3">منصة كورساتي</h1>
      <p class="lead">منصة عربية تهدف لتقديم أفضل تجربة تعليمية أونلاين في العالم العربي.</p>
    </div>
  </section>

  <!-- من نحن -->
  <section class="container my-5">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0">
        <img src="images/about.jpg" alt="من نحن" class="img-fluid rounded shadow-sm">
      </div>
      <div class="col-md-6">
        <h4 class="mb-3">رسالتنا</h4>
        <p>نحن نؤمن أن التعليم حق للجميع، ونسعى لتوفير كورسات عالية الجودة في مختلف المجالات التقنية والإبداعية، بإشراف مدربين محترفين وبأسعار مناسبة للجميع.</p>
        <h4 class="mb-3 mt-4">قيمنا</h4>
        <ul>
          <li>الجودة والاحترافية في تقديم المحتوى.</li>
          <li>سهولة الوصول والتعلم من أي مكان.</li>
          <li>دعم مستمر للمتعلمين.</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- فريق العمل -->
  <section class="container my-5">
    <h2 class="text-center mb-4">فريق العمل</h2>
    <div class="row g-4 justify-content-center">
      <div class="col-md-4">
        <div class="card text-center p-3">
          <img src="images/team1.jpg" alt="أحمد علي" class="rounded-circle mx-auto mb-3" width="100" height="100">
          <h5>أحمد علي</h5>
          <p class="text-muted mb-1">المؤسس والمدير التنفيذي</p>
          <p>خبرة 10 سنوات في تطوير المنصات التعليمية.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center p-3">
          <img src="images/team2.jpg" alt="سارة محمد" class="rounded-circle mx-auto mb-3" width="100" height="100">
          <h5>سارة محمد</h5>
          <p class="text-muted mb-1">مديرة المحتوى</p>
          <p>متخصصة في تصميم المناهج الرقمية وتطوير المحتوى.</p>
        </div>
      </div>
      <!-- أضف أعضاء آخرين إذا أردت -->
    </div>
  </section>

  <!-- الفوتر الموحد -->
  <footer class="mt-5 py-4">
    <div class="container text-center">
      <div class="mb-2 social-icons">
        <a href="#" class="mx-2"><i class="fab fa-facebook fa-lg"></i></a>
        <a href="#" class="mx-2"><i class="fab fa-twitter fa-lg"></i></a>
        <a href="#" class="mx-2"><i class="fab fa-instagram fa-lg"></i></a>
      </div>
      <p class="mb-0">&copy; 2025 كورساتي. جميع الحقوق محفوظة.</p>
    </div>
  </footer>

  <script
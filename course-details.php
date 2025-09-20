<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل الكورس - Korsaty</title>

    <!-- خطوط وجماليات -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- أيقونات -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- ملف CSS الأساسي -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- ========== Navbar ========== -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm py-3 bg-light">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.html">
                <!-- ✅ تعديل المسار -->
                <img src="images/logo.png" alt="شعار Korsaty" width="50" height="50">
                <span class="fw-bold ms-2 fs-4 text-primary">Korsaty</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="index.html">الرئيسية</a></li>
                    <li class="nav-item"><a class="nav-link" href="courses.html">كل الكورسات</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html">تواصل معنا</a></li>
                </ul>
                <div class="d-flex align-items-center me-3">
                    <a href="login.html" class="btn btn-primary me-2">تسجيل الدخول</a>
                    <a href="register.html" class="btn btn-warning">التسجيل</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- ========== Course Details Section ========== -->
    <section class="container my-5 pt-5">
        <div class="row">
            <!-- محتوى الكورس -->
            <div class="col-lg-8">
                <h1 class="fw-bold mb-3 text-primary">دورة تصميم واجهة المستخدم الكاملة (UI/UX)</h1>
                <p class="lead mb-4 text-muted">تعلم كل ما تحتاجه لتصميم واجهات مستخدم جذابة وسهلة الاستخدام من الصفر حتى الاحتراف.</p>

                <!-- التقييم -->
                <div class="d-flex align-items-center mb-4">
                    <div class="text-warning">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                        <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                    </div>
                    <span class="ms-2 fw-bold text-secondary">4.7</span>
                    <span class="text-muted ms-1">(1,250 تقييم)</span>
                    <span class="mx-3 text-muted">|</span>
                    <span class="text-muted"><i class="fas fa-users me-1"></i> 25,000 مشترك</span>
                </div>

                <!-- تفاصيل -->
                <ul class="list-unstyled mb-4">
                    <li class="mb-2"><i class="fas fa-user-tie text-primary me-2"></i> <strong>المدرس:</strong> محمد علي</li>
                    <li class="mb-2"><i class="fas fa-play-circle text-primary me-2"></i> <strong>الدروس:</strong> 80 درسًا</li>
                    <li class="mb-2"><i class="fas fa-clock text-primary me-2"></i> <strong>المدة:</strong> 25 ساعة</li>
                    <li class="mb-2"><i class="fas fa-chart-bar text-primary me-2"></i> <strong>المستوى:</strong> متقدم</li>
                </ul>

                <hr class="my-4">

                <!-- ماذا ستتعلم -->
                <h3 class="fw-bold mb-3 text-primary">ماذا ستتعلم في هذا الكورس؟</h3>
                <ul class="list-unstyled mb-5">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> مبادئ تصميم تجربة المستخدم (UX).</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> استخدام Adobe XD وFigma.</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> تصميم واجهات متجاوبة.</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> إنشاء نماذج أولية تفاعلية.</li>
                </ul>

                <!-- المحتويات -->
                <h3 class="fw-bold mb-3 text-primary">محتويات الكورس</h3>
                <div class="accordion mb-5" id="courseAccordion">
                    <!-- فصل 1 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                الفصل 1: مقدمة إلى UI/UX
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show">
                            <div class="accordion-body text-muted">
                                <ul>
                                    <li><i class="fas fa-video me-2"></i> الدرس 1.1: ما هو UI/UX؟</li>
                                    <li><i class="fas fa-video me-2"></i> الدرس 1.2: أهمية التصميم الرقمي.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- فصل 2 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                الفصل 2: أدوات التصميم (Figma)
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse">
                            <div class="accordion-body text-muted">
                                <ul>
                                    <li><i class="fas fa-video me-2"></i> الدرس 2.1: التعرف على واجهة Figma.</li>
                                    <li><i class="fas fa-video me-2"></i> الدرس 2.2: أدوات أساسية للتصميم.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- عن المدرس -->
                <h3 class="fw-bold mb-3 text-primary">نبذة عن المدرس</h3>
                <div class="card p-4 mb-5 shadow-sm">
                    <div class="d-flex align-items-center">
                        <!-- ✅ تعديل المسار -->
                        <img src="images/instructors/instructor1.jpg" class="rounded-circle me-3" alt="صورة المدرس" width="80" height="80">
                        <div>
                            <h5 class="fw-bold mb-0">محمد علي</h5>
                            <p class="text-muted mb-0">مصمم UI/UX بخبرة 10 سنوات</p>
                        </div>
                    </div>
                    <p class="mt-3 text-muted">
                        محمد علي مصمم واجهات مستخدم محترف، عمل مع العديد من الشركات الناشئة وقام بتدريب آلاف الطلاب حول العالم.
                    </p>
                </div>
            </div>

            <!-- العمود الجانبي -->
            <div class="col-lg-4">
                <div class="card p-4 shadow-sm sticky-top" style="top: 100px;">
                    <!-- ✅ تعديل المسار -->
                    <img src="images/course-thumbnails/ui-ux.jpg" class="card-img-top mb-3 rounded" alt="صورة الكورس">
                    <h2 class="text-center fw-bold text-warning mb-3">150$</h2>
                    <button class="btn btn-warning btn-lg fw-bold mb-3">اشترك الآن</button>
                    <p class="text-center text-muted small"><i class="fas fa-undo-alt me-1"></i> ضمان استعادة أموالك 30 يومًا</p>
                    <hr>
                    <h5 class="fw-bold mb-3 text-primary">يشمل الكورس:</h5>
                    <ul class="list-unstyled small">
                        <li><i class="fas fa-video me-2"></i> وصول مدى الحياة للدروس.</li>
                        <li><i class="fas fa-file-alt me-2"></i> مواد داعمة قابلة للتحميل.</li>
                        <li><i class="fas fa-certificate me-2"></i> شهادة إتمام.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ========== Footer ========== -->
    <footer class="text-center py-5 text-white bg-primary">
        <div class="container">
            <div class="row">
                <!-- روابط -->
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold">روابط سريعة</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.html" class="text-white text-decoration-none">الرئيسية</a></li>
                        <li><a href="courses.html" class="text-white text-decoration-none">كل الكورسات</a></li>
                        <li><a href="about.html" class="text-white text-decoration-none">عن المنصة</a></li>
                    </ul>
                </div>
                <!-- تواصل -->
                <div class="col-md-4 mb-3">
                    <h5 class="fw-bold">تواصل معنا</h5>
                    <ul class="list-unstyled">
                        <li><a href="contact.html" class="text-white text-decoration-none">اتصل بنا</a></li>
                        <li><a href="mailto:info@korsaty.com" class="text-white text-decoration-none">info@korsaty.com</a></li>
                    </ul>
                </div>
                <!-- سوشيال -->
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
            <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
            <p class="mb-0">&copy; 2025 Korsaty. جميع الحقوق محفوظة.</p>
        </div>
    </footer>

    <!-- سكربتات -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>

<?php
require_once 'includes/init.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

// التحقق أن الأدمن هو اللي داخل
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$error = null;
$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username   = trim($_POST['username'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $password   = $_POST['password'] ?? '';
    $full_name  = trim($_POST['full_name'] ?? '');
    $phone      = trim($_POST['phone'] ?? '');
    $gender     = $_POST['gender'] ?? '';

    if (empty($username) || empty($email) || empty($password) || empty($full_name)) {
        $error = "الرجاء إدخال جميع الحقول المطلوبة.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "صيغة البريد الإلكتروني غير صحيحة.";
    } else {
        try {
            $pdo = db();
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
            $stmt->execute([$email, $username]);

            if ($stmt->fetch()) {
                $error = "البريد الإلكتروني أو اسم المستخدم موجود بالفعل.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("
                    INSERT INTO users (username, email, password, role, full_name, phone, gender, created_at) 
                    VALUES (?, ?, ?, 'teacher', ?, ?, ?, NOW())
                ");
                $stmt->execute([$username, $email, $hashedPassword, $full_name, $phone, $gender]);
                $success = "تم إضافة المدرس بنجاح.";
            }
        } catch (PDOException $e) {
            $error = "حدث خطأ في قاعدة البيانات: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إضافة مدرس جديد - Korsaty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="card shadow p-4">
        <h2 class="mb-4 text-center text-primary">إضافة مدرس جديد</h2>

        <?php if ($error): ?>
            <div class="alert alert-danger text-center"><?php echo $error; ?></div>
        <?php elseif ($success): ?>
            <div class="alert alert-success text-center"><?php echo $success; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">اسم المستخدم</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">كلمة المرور</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">الاسم الكامل</label>
                <input type="text" name="full_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">رقم الهاتف</label>
                <input type="text" name="phone" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">الجنس</label>
                <select name="gender" class="form-select">
                    <option value="">اختر</option>
                    <option value="male">ذكر</option>
                    <option value="female">أنثى</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">إضافة المدرس</button>
        </form>
    </div>
</div>
</body>
</html>

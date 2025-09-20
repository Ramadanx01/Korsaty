<?php
include 'db_connect.php';
include 'functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}

$user = current_user();

// تحديث كلمة المرور أو الصورة
if (isset($_POST['update'])) {
    $messages = [];
    // تغيير كلمة المرور
    if (!empty($_POST['new_password'])) {
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $id = $user['id'];
        $sql = "UPDATE users SET password='$new_password' WHERE id=$id";
        if (mysqli_query($conn, $sql)) {
            $messages[] = '<span style="color:green">تم تحديث كلمة المرور بنجاح</span>';
        } else {
            $messages[] = '<span style="color:red">حدث خطأ في تحديث كلمة المرور</span>';
        }
    }
    // تغيير الصورة الشخصية
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
        $target_dir = 'uploads/profiles/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $file_name = time() . '_' . basename($_FILES['profile_image']['name']);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
            $id = $user['id'];
            $sql = "UPDATE users SET profile_image='$target_file' WHERE id=$id";
            if (mysqli_query($conn, $sql)) {
                $messages[] = '<span style="color:green">تم تحديث الصورة الشخصية بنجاح</span>';
                $_SESSION['user']['profile_image'] = $target_file;
            } else {
                $messages[] = '<span style="color:red">حدث خطأ في تحديث الصورة</span>';
            }
        } else {
            $messages[] = '<span style="color:red">فشل رفع الصورة</span>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>الملف الشخصي</title>
</head>
<body>
    <h2>الملف الشخصي</h2>
    <?php if (!empty($messages)) foreach($messages as $msg) echo $msg . '<br>'; ?>
    <form method="post" enctype="multipart/form-data">
        <label>اسم المستخدم:</label><br>
        <input type="text" value="<?php echo esc($user['username']); ?>" disabled><br><br>
        <label>البريد الإلكتروني:</label><br>
        <input type="text" value="<?php echo esc($user['email']); ?>" disabled><br><br>
        <label>الصورة الشخصية الحالية:</label><br>
        <img src="<?php echo esc(image_or_default($user['profile_image'] ?? null)); ?>" alt="الصورة الشخصية" style="max-width:120px;"><br><br>
        <label>تغيير الصورة الشخصية:</label><br>
        <input type="file" name="profile_image" accept="image/*"><br><br>
        <label>تغيير كلمة المرور:</label><br>
        <input type="password" name="new_password" placeholder="كلمة مرور جديدة"><br><br>
        <button type="submit" name="update">حفظ التغييرات</button>
    </form>
</body>
</html>
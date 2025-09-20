<?php
// includes/db.php
$DB_HOST = '127.0.0.1';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'korsaty';

try {
    // الاتصال باستخدام PDO
    $dsn = "mysql:host={$DB_HOST};dbname={$DB_NAME};charset=utf8mb4";
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS);
    
    // ضبط الخيارات للتعامل مع الأخطاء
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    http_response_code(500);
    die('Database connection error: ' . $e->getMessage());
}

// دالة مساعدة لارجاع اتصال PDO
function db(): PDO {
    global $pdo;
    return $pdo;
}
?>